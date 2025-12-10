<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use App\Models\UserSubscription;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class PricingPlanController extends Controller
{
    private $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
        
        // Log controller initialization
        Log::info('PricingPlanController initialized', [
            'stripe_service' => get_class($stripeService),
            'timestamp' => now()
        ]);
    }

    public function index(Request $request)
    {
        try {
            Log::info('PricingPlanController@index - Start', [
                'request_params' => $request->all(),
                'user' => auth('admin')->id()
            ]);

            $query = PricingPlan::query();

            // Search functionality
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%')
                      ->orWhere('short_description', 'like', '%' . $request->search . '%');
                });
                
                Log::debug('Applied search filter', ['search' => $request->search]);
            }

            // Filter by status
            if ($request->status && in_array($request->status, ['active', 'inactive'])) {
                $query->where('status', $request->status);
                Log::debug('Applied status filter', ['status' => $request->status]);
            }

            // Filter by home display
            if ($request->has('show_in_home') && $request->show_in_home !== '') {
                $query->where('show_in_home', (bool) $request->show_in_home);
                Log::debug('Applied home display filter', ['show_in_home' => $request->show_in_home]);
            }

            // Filter by pricing display
            if ($request->has('show_in_pricing') && $request->show_in_pricing !== '') {
                $query->where('show_in_pricing', (bool) $request->show_in_pricing);
                Log::debug('Applied pricing display filter', ['show_in_pricing' => $request->show_in_pricing]);
            }

            // Load subscriptions count
            $query->withCount(['subscriptions', 'subscriptions as active_subscriptions_count' => function ($q) {
                $q->where('status', 'active');
            }]);

            $plans = $query->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            Log::info('Plans retrieved successfully', ['count' => $plans->count()]);

            // Get statistics
            $stats = [
                'total' => PricingPlan::count(),
                'active' => PricingPlan::where('status', 'active')->count(),
                'inactive' => PricingPlan::where('status', 'inactive')->count(),
                'show_in_home' => PricingPlan::where('show_in_home', true)->count(),
                'popular' => PricingPlan::where('is_popular', true)->count(),
                'total_subscribers' => UserSubscription::where('status', 'active')->count(),
            ];

            Log::info('Statistics calculated', $stats);

            Log::info('PricingPlanController@index - Success');
            return view('admin.pricing.index', compact('plans', 'stats'));

        } catch (Exception $e) {
            Log::error('PricingPlanController@index - Error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Failed to load pricing plans: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            Log::info('PricingPlanController@create - Start', [
                'user' => auth('admin')->id()
            ]);

            // Get next sort order
            $nextSortOrder = PricingPlan::max('sort_order') + 1;

            Log::info('PricingPlanController@create - Success');
            return view('admin.pricing.create', compact('nextSortOrder'));

        } catch (Exception $e) {
            Log::error('PricingPlanController@create - Error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->route('admin.pricing-plans.index')
                ->withErrors(['error' => 'Failed to load create form: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        Log::info('PricingPlanController@store - Start', [
            'request_data' => $request->except(['_token']),
            'user' => auth('admin')->id()
        ]);

        try {
            // Enhanced validation with detailed logging
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:pricing_plans,slug',
                'description' => 'nullable|string',
                'short_description' => 'nullable|string|max:500',
                'price_monthly' => 'nullable|numeric|min:0',
                'price_yearly' => 'nullable|numeric|min:0',
                'setup_fee' => 'nullable|numeric|min:0',
                'currency' => 'required|string|size:3',
                'features' => 'nullable|array',
                'features.*' => 'string|max:255',
                'max_users' => 'nullable|integer|min:1',
                'max_projects' => 'nullable|integer|min:1',
                'storage_limit' => 'nullable|string|max:50',
                'bandwidth_limit' => 'nullable|string|max:50',
                'support_level' => 'required|in:basic,priority,premium',
                'trial_days' => 'nullable|integer|min:0|max:365',
                'icon' => 'nullable|string|max:255',
                'color' => 'required|string|max:50',
                'is_popular' => 'boolean',
                'is_featured' => 'boolean',
                'show_in_home' => 'boolean',
                'show_in_pricing' => 'boolean',
                'sort_order' => 'required|integer|min:0',
                'status' => 'required|in:active,inactive',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed', [
                    'errors' => $validator->errors()->toArray(),
                    'request_data' => $request->except(['_token'])
                ]);

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('form_error', 'Please check the form for errors and try again.');
            }

            Log::info('Validation passed successfully');

            DB::beginTransaction();
            Log::info('Database transaction started');

            // Generate slug if not provided
            $slug = $request->slug ?: Str::slug($request->name);
            
            // Ensure unique slug
            $originalSlug = $slug;
            $counter = 1;
            while (PricingPlan::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            Log::info('Slug generated', ['original_slug' => $request->slug, 'final_slug' => $slug]);

            // Prepare data for creation
            $planData = [
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'price_monthly' => $request->price_monthly,
                'price_yearly' => $request->price_yearly,
                'setup_fee' => $request->setup_fee ?? 0,
                'currency' => strtoupper($request->currency),
                'features' => $request->features ? array_filter($request->features) : null,
                'max_users' => $request->max_users,
                'max_projects' => $request->max_projects,
                'storage_limit' => $request->storage_limit,
                'bandwidth_limit' => $request->bandwidth_limit,
                'support_level' => $request->support_level,
                'trial_days' => $request->trial_days ?? 0,
                'icon' => $request->icon ?: 'fas fa-star',
                'color' => $request->color,
                'is_popular' => $request->boolean('is_popular'),
                'is_featured' => $request->boolean('is_featured'),
                'show_in_home' => $request->boolean('show_in_home'),
                'show_in_pricing' => $request->boolean('show_in_pricing'),
                'sort_order' => $request->sort_order,
                'status' => $request->status,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ];

            Log::info('Plan data prepared', ['plan_data' => $planData]);

            // Check if PricingPlan model exists
            if (!class_exists(PricingPlan::class)) {
                throw new Exception('PricingPlan model not found');
            }

            $plan = PricingPlan::create($planData);

            if (!$plan) {
                throw new Exception('Failed to create pricing plan - create() returned null');
            }

            Log::info('Pricing plan created successfully', [
                'plan_id' => $plan->id,
                'plan_name' => $plan->name
            ]);

            // Create Stripe product and prices if configured
            try {
                Log::info('Checking Stripe configuration');
                
                if (method_exists($this->stripeService, 'getSettings') && 
                    $this->stripeService->getSettings() && 
                    method_exists($this->stripeService->getSettings(), 'isConfigured') &&
                    $this->stripeService->getSettings()->isConfigured()) {
                    
                    Log::info('Stripe is configured, creating products');
                    
                    $product = $this->stripeService->createProduct($plan);
                    Log::info('Stripe product created', ['product_id' => $product->id ?? 'unknown']);

                    if ($plan->price_monthly) {
                        $monthlyPrice = $this->stripeService->createPrice($plan, 'monthly');
                        Log::info('Stripe monthly price created', ['price_id' => $monthlyPrice->id ?? 'unknown']);
                    }

                    if ($plan->price_yearly) {
                        $yearlyPrice = $this->stripeService->createPrice($plan, 'yearly');
                        Log::info('Stripe yearly price created', ['price_id' => $yearlyPrice->id ?? 'unknown']);
                    }
                } else {
                    Log::info('Stripe not configured, skipping product creation');
                }
            } catch (Exception $stripeError) {
                // Log stripe error but don't fail the creation
                Log::warning('Failed to create Stripe product for pricing plan', [
                    'plan_id' => $plan->id,
                    'stripe_error' => $stripeError->getMessage(),
                    'stripe_trace' => $stripeError->getTraceAsString()
                ]);
            }

            DB::commit();
            Log::info('Database transaction committed successfully');

            Log::info('PricingPlanController@store - Success', [
                'plan_id' => $plan->id,
                'redirect_to' => route('admin.pricing-plans.index')
            ]);

            return redirect()->route('admin.pricing-plans.index')
                ->with('success', 'Pricing plan created successfully!')
                ->with('form_submitted', true);

        } catch (Exception $e) {
            DB::rollback();
            
            Log::error('PricingPlanController@store - Critical Error', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['_token']),
                'user' => auth('admin')->id()
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Failed to create pricing plan: ' . $e->getMessage()])
                ->withInput()
                ->with('form_error', 'An error occurred while creating the plan. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            Log::info('PricingPlanController@show - Start', [
                'plan_id' => $id,
                'user' => auth('admin')->id()
            ]);

            // Find the pricing plan by ID with error handling
            $pricingPlan = PricingPlan::find($id);
            
            if (!$pricingPlan) {
                Log::error('PricingPlan not found', ['plan_id' => $id]);
                
                return redirect()->route('admin.pricing-plans.index')
                    ->withErrors(['error' => 'Pricing plan not found.']);
            }

            $pricingPlan->load(['subscriptions.user']);

            $stats = [
                'total_subscribers' => $pricingPlan->subscriptions()->count(),
                'active_subscribers' => $pricingPlan->subscriptions()->where('status', 'active')->count(),
                'monthly_revenue' => $pricingPlan->subscriptions()
                    ->where('billing_cycle', 'monthly')
                    ->where('status', 'active')
                    ->sum('amount'),
                'yearly_revenue' => $pricingPlan->subscriptions()
                    ->where('billing_cycle', 'yearly')
                    ->where('status', 'active')
                    ->sum('amount'),
            ];

            $recentSubscriptions = $pricingPlan->subscriptions()
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            Log::info('PricingPlanController@show - Success', [
                'stats' => $stats,
                'recent_subscriptions_count' => $recentSubscriptions->count()
            ]);

            return view('admin.pricing.show', compact('pricingPlan', 'stats', 'recentSubscriptions'));

        } catch (ModelNotFoundException $e) {
            Log::error('PricingPlanController@show - Model Not Found', [
                'plan_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('admin.pricing-plans.index')
                ->withErrors(['error' => 'Pricing plan not found.']);

        } catch (Exception $e) {
            Log::error('PricingPlanController@show - Error', [
                'plan_id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->route('admin.pricing-plans.index')
                ->withErrors(['error' => 'Failed to load pricing plan details: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            Log::info('PricingPlanController@edit - Start', [
                'plan_id' => $id,
                'user' => auth('admin')->id()
            ]);

            // Find the pricing plan by ID with error handling
            $pricingPlan = PricingPlan::find($id);
            
            if (!$pricingPlan) {
                Log::error('PricingPlan not found for edit', ['plan_id' => $id]);
                
                return redirect()->route('admin.pricing-plans.index')
                    ->withErrors(['error' => 'Pricing plan not found.']);
            }

            Log::info('PricingPlanController@edit - Success');
            return view('admin.pricing.edit', compact('pricingPlan'));

        } catch (ModelNotFoundException $e) {
            Log::error('PricingPlanController@edit - Model Not Found', [
                'plan_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('admin.pricing-plans.index')
                ->withErrors(['error' => 'Pricing plan not found.']);

        } catch (Exception $e) {
            Log::error('PricingPlanController@edit - Error', [
                'plan_id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->route('admin.pricing-plans.index')
                ->withErrors(['error' => 'Failed to load edit form: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('PricingPlanController@update - Start', [
            'plan_id' => $id,
            'request_data' => $request->except(['_token', '_method']),
            'user' => auth('admin')->id()
        ]);

        try {
            // Find the pricing plan by ID with error handling
            $pricingPlan = PricingPlan::find($id);
            
            if (!$pricingPlan) {
                Log::error('PricingPlan not found for update', ['plan_id' => $id]);
                
                return redirect()->route('admin.pricing-plans.index')
                    ->withErrors(['error' => 'Pricing plan not found.']);
            }

            // Enhanced validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:pricing_plans,slug,' . $pricingPlan->id,
                'description' => 'nullable|string',
                'short_description' => 'nullable|string|max:500',
                'price_monthly' => 'nullable|numeric|min:0',
                'price_yearly' => 'nullable|numeric|min:0',
                'setup_fee' => 'nullable|numeric|min:0',
                'currency' => 'required|string|size:3',
                'features' => 'nullable|array',
                'features.*' => 'string|max:255',
                'max_users' => 'nullable|integer|min:1',
                'max_projects' => 'nullable|integer|min:1',
                'storage_limit' => 'nullable|string|max:50',
                'bandwidth_limit' => 'nullable|string|max:50',
                'support_level' => 'required|in:basic,priority,premium',
                'trial_days' => 'nullable|integer|min:0|max:365',
                'icon' => 'nullable|string|max:255',
                'color' => 'required|string|max:50',
                'is_popular' => 'boolean',
                'is_featured' => 'boolean',
                'show_in_home' => 'boolean',
                'show_in_pricing' => 'boolean',
                'sort_order' => 'required|integer|min:0',
                'status' => 'required|in:active,inactive',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::error('Update validation failed', [
                    'plan_id' => $pricingPlan->id,
                    'errors' => $validator->errors()->toArray()
                ]);

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('form_error', 'Please check the form for errors and try again.');
            }

            DB::beginTransaction();

            // Generate slug if changed
            $slug = $request->slug ?: Str::slug($request->name);
            
            // Ensure unique slug (excluding current plan)
            if ($slug !== $pricingPlan->slug) {
                $originalSlug = $slug;
                $counter = 1;
                while (PricingPlan::where('slug', $slug)->where('id', '!=', $pricingPlan->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }

            $updateData = [
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'price_monthly' => $request->price_monthly,
                'price_yearly' => $request->price_yearly,
                'setup_fee' => $request->setup_fee ?? 0,
                'currency' => strtoupper($request->currency),
                'features' => $request->features ? array_filter($request->features) : null,
                'max_users' => $request->max_users,
                'max_projects' => $request->max_projects,
                'storage_limit' => $request->storage_limit,
                'bandwidth_limit' => $request->bandwidth_limit,
                'support_level' => $request->support_level,
                'trial_days' => $request->trial_days ?? 0,
                'icon' => $request->icon ?: $pricingPlan->icon,
                'color' => $request->color,
                'is_popular' => $request->boolean('is_popular'),
                'is_featured' => $request->boolean('is_featured'),
                'show_in_home' => $request->boolean('show_in_home'),
                'show_in_pricing' => $request->boolean('show_in_pricing'),
                'sort_order' => $request->sort_order,
                'status' => $request->status,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ];

            Log::info('Update data prepared', ['update_data' => $updateData]);

            $updated = $pricingPlan->update($updateData);

            if (!$updated) {
                throw new Exception('Failed to update pricing plan - update() returned false');
            }

            Log::info('Pricing plan updated successfully', ['plan_id' => $pricingPlan->id]);

            // Update Stripe prices if needed
            try {
                if (method_exists($this->stripeService, 'getSettings') && 
                    $this->stripeService->getSettings() && 
                    method_exists($this->stripeService->getSettings(), 'isConfigured') &&
                    $this->stripeService->getSettings()->isConfigured()) {
                    
                    // Create product if doesn't exist
                    if (!$pricingPlan->stripe_product_id) {
                        $this->stripeService->createProduct($pricingPlan);
                        Log::info('Stripe product created for existing plan');
                    }

                    // Create/update monthly price
                    if ($pricingPlan->price_monthly && !$pricingPlan->stripe_price_id_monthly) {
                        $this->stripeService->createPrice($pricingPlan, 'monthly');
                        Log::info('Stripe monthly price created for existing plan');
                    }

                    // Create/update yearly price
                    if ($pricingPlan->price_yearly && !$pricingPlan->stripe_price_id_yearly) {
                        $this->stripeService->createPrice($pricingPlan, 'yearly');
                        Log::info('Stripe yearly price created for existing plan');
                    }
                }
            } catch (Exception $stripeError) {
                Log::warning('Failed to update Stripe product for pricing plan', [
                    'plan_id' => $pricingPlan->id,
                    'stripe_error' => $stripeError->getMessage()
                ]);
            }

            DB::commit();

            Log::info('PricingPlanController@update - Success', ['plan_id' => $pricingPlan->id]);

            return redirect()->route('admin.pricing-plans.index')
                ->with('success', 'Pricing plan updated successfully!')
                ->with('form_submitted', true);

        } catch (ModelNotFoundException $e) {
            DB::rollback();
            
            Log::error('PricingPlanController@update - Model Not Found', [
                'plan_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('admin.pricing-plans.index')
                ->withErrors(['error' => 'Pricing plan not found.']);

        } catch (Exception $e) {
            DB::rollback();
            
            Log::error('PricingPlanController@update - Error', [
                'plan_id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'Failed to update pricing plan: ' . $e->getMessage()])
                ->withInput()
                ->with('form_error', 'An error occurred while updating the plan. Please try again.');
        }
    }

    public function destroy($id)
    {
        Log::info('PricingPlanController@destroy - Start', [
            'plan_id' => $id,
            'user' => auth('admin')->id()
        ]);

        try {
            // Find the pricing plan by ID with error handling
            $pricingPlan = PricingPlan::find($id);
            
            if (!$pricingPlan) {
                Log::error('PricingPlan not found for delete', ['plan_id' => $id]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Pricing plan not found'
                ], 404);
            }

            // Check if plan has active subscriptions
            $activeSubscriptionsCount = $pricingPlan->subscriptions()->where('status', 'active')->count();
            
            if ($activeSubscriptionsCount > 0) {
                Log::warning('Cannot delete plan with active subscriptions', [
                    'plan_id' => $pricingPlan->id,
                    'active_subscriptions' => $activeSubscriptionsCount
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete plan with active subscriptions'
                ], 400);
            }

            $planName = $pricingPlan->name;
            $deleted = $pricingPlan->delete();

            if (!$deleted) {
                throw new Exception('Failed to delete pricing plan - delete() returned false');
            }

            Log::info('Pricing plan deleted successfully', [
                'plan_name' => $planName,
                'deleted_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pricing plan deleted successfully'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::error('PricingPlanController@destroy - Model Not Found', [
                'plan_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Pricing plan not found'
            ], 404);

        } catch (Exception $e) {
            Log::error('PricingPlanController@destroy - Error', [
                'plan_id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete pricing plan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        Log::info('PricingPlanController@updateStatus - Start', [
            'plan_id' => $id,
            'new_status' => $request->status,
            'user' => auth('admin')->id()
        ]);

        try {
            // Find the pricing plan by ID with error handling
            $pricingPlan = PricingPlan::find($id);
            
            if (!$pricingPlan) {
                Log::error('PricingPlan not found for status update', ['plan_id' => $id]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Pricing plan not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:active,inactive'
            ]);

            if ($validator->fails()) {
                Log::error('Status update validation failed', [
                    'plan_id' => $pricingPlan->id,
                    'errors' => $validator->errors()->toArray()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid status value'
                ], 400);
            }

            $oldStatus = $pricingPlan->status;
            $updated = $pricingPlan->update(['status' => $request->status]);

            if (!$updated) {
                throw new Exception('Failed to update status - update() returned false');
            }

            Log::info('Pricing plan status updated successfully', [
                'plan_id' => $pricingPlan->id,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'user' => auth('admin')->user()->email ?? 'unknown'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'data' => [
                    'plan_id' => $pricingPlan->id,
                    'status' => $pricingPlan->status
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            Log::error('PricingPlanController@updateStatus - Model Not Found', [
                'plan_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Pricing plan not found'
            ], 404);

        } catch (Exception $e) {
            Log::error('PricingPlanController@updateStatus - Error', [
                'plan_id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateSortOrder(Request $request)
    {
        Log::info('PricingPlanController@updateSortOrder - Start', [
            'items' => $request->items,
            'user' => auth('admin')->id()
        ]);

        try {
            $validator = Validator::make($request->all(), [
                'items' => 'required|array',
                'items.*.id' => 'required|integer|exists:pricing_plans,id',
                'items.*.sort_order' => 'required|integer|min:0'
            ]);

            if ($validator->fails()) {
                Log::error('Sort order validation failed', [
                    'errors' => $validator->errors()->toArray()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid sort order data'
                ], 400);
            }

            DB::beginTransaction();

            foreach ($request->items as $item) {
                $pricingPlan = PricingPlan::find($item['id']);
                
                if (!$pricingPlan) {
                    throw new Exception("PricingPlan not found for ID: {$item['id']}");
                }

                $updated = $pricingPlan->update(['sort_order' => $item['sort_order']]);
                
                if (!$updated) {
                    throw new Exception("Failed to update sort order for plan ID: {$item['id']}");
                }

                Log::debug('Sort order updated', [
                    'plan_id' => $item['id'],
                    'new_sort_order' => $item['sort_order']
                ]);
            }

            DB::commit();

            Log::info('PricingPlanController@updateSortOrder - Success', [
                'updated_items' => count($request->items)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sort order updated successfully'
            ]);

        } catch (Exception $e) {
            DB::rollback();
            
            Log::error('PricingPlanController@updateSortOrder - Error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update sort order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function duplicate($id)
    {
        Log::info('PricingPlanController@duplicate - Start', [
            'original_plan_id' => $id,
            'user' => auth('admin')->id()
        ]);

        try {
            // Find the pricing plan by ID with error handling
            $pricingPlan = PricingPlan::find($id);
            
            if (!$pricingPlan) {
                Log::error('PricingPlan not found for duplicate', ['plan_id' => $id]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Pricing plan not found'
                ], 404);
            }

            DB::beginTransaction();

            $newPlan = $pricingPlan->replicate();
            $newPlan->name = $pricingPlan->name . ' (Copy)';
            $newPlan->slug = Str::slug($newPlan->name) . '-' . time();
            $newPlan->stripe_product_id = null;
            $newPlan->stripe_price_id_monthly = null;
            $newPlan->stripe_price_id_yearly = null;
            $newPlan->status = 'inactive';
            $newPlan->sort_order = PricingPlan::max('sort_order') + 1;
            
            $saved = $newPlan->save();

            if (!$saved) {
                throw new Exception('Failed to save duplicated plan');
            }

            DB::commit();

            Log::info('Pricing plan duplicated successfully', [
                'original_plan_id' => $pricingPlan->id,
                'new_plan_id' => $newPlan->id,
                'new_plan_name' => $newPlan->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pricing plan duplicated successfully',
                'redirect' => route('admin.pricing-plans.edit', $newPlan->id)
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollback();
            
            Log::error('PricingPlanController@duplicate - Model Not Found', [
                'plan_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Pricing plan not found'
            ], 404);

        } catch (Exception $e) {
            DB::rollback();
            
            Log::error('PricingPlanController@duplicate - Error', [
                'plan_id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to duplicate pricing plan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function syncStripe($id)
    {
        Log::info('PricingPlanController@syncStripe - Start', [
            'plan_id' => $id,
            'user' => auth('admin')->id()
        ]);

        try {
            // Find the pricing plan by ID with error handling
            $pricingPlan = PricingPlan::find($id);
            
            if (!$pricingPlan) {
                Log::error('PricingPlan not found for Stripe sync', ['plan_id' => $id]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Pricing plan not found'
                ], 404);
            }

            if (!method_exists($this->stripeService, 'getSettings') || 
                !$this->stripeService->getSettings() || 
                !method_exists($this->stripeService->getSettings(), 'isConfigured') ||
                !$this->stripeService->getSettings()->isConfigured()) {
                
                Log::warning('Stripe not configured for sync', [
                    'plan_id' => $pricingPlan->id
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Stripe is not configured'
                ], 400);
            }

            // Create product if doesn't exist
            if (!$pricingPlan->stripe_product_id) {
                $product = $this->stripeService->createProduct($pricingPlan);
                Log::info('Stripe product created during sync', [
                    'plan_id' => $pricingPlan->id,
                    'product_id' => $product->id ?? 'unknown'
                ]);
            }

            // Create prices if they don't exist
            if ($pricingPlan->price_monthly && !$pricingPlan->stripe_price_id_monthly) {
                $monthlyPrice = $this->stripeService->createPrice($pricingPlan, 'monthly');
                Log::info('Stripe monthly price created during sync', [
                    'plan_id' => $pricingPlan->id,
                    'price_id' => $monthlyPrice->id ?? 'unknown'
                ]);
            }

            if ($pricingPlan->price_yearly && !$pricingPlan->stripe_price_id_yearly) {
                $yearlyPrice = $this->stripeService->createPrice($pricingPlan, 'yearly');
                Log::info('Stripe yearly price created during sync', [
                    'plan_id' => $pricingPlan->id,
                    'price_id' => $yearlyPrice->id ?? 'unknown'
                ]);
            }

            Log::info('PricingPlanController@syncStripe - Success', [
                'plan_id' => $pricingPlan->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Plan synchronized with Stripe successfully'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::error('PricingPlanController@syncStripe - Model Not Found', [
                'plan_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Pricing plan not found'
            ], 404);

        } catch (Exception $e) {
            Log::error('PricingPlanController@syncStripe - Error', [
                'plan_id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to sync with Stripe: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get section title data for pricing plans
     */
    public function getSectionTitle()
    {
        try {
            Log::info('PricingPlanController@getSectionTitle - Start');

            $firstPlan = PricingPlan::getFirstPlan();
            
            return response()->json([
                'success' => true,
                'title_part1' => $firstPlan->title_part1 ?? 'Choose Your',
                'title_part2' => $firstPlan->title_part2 ?? 'Perfect Plan',
                'subtitle' => $firstPlan->subtitle ?? 'Flexible pricing designed to scale with your needs, from startup to enterprise'
            ]);

        } catch (Exception $e) {
            Log::error('PricingPlanController@getSectionTitle - Error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to get section title: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update section title for pricing plans
     */
    public function updateSectionTitle(Request $request)
    {
        Log::info('PricingPlanController@updateSectionTitle - Start', [
            'request_data' => $request->all(),
            'user' => auth('admin')->id()
        ]);

        try {
            $validator = Validator::make($request->all(), [
                'title_part1' => 'nullable|string|max:255',
                'title_part2' => 'nullable|string|max:255',
                'subtitle' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                Log::error('Section title update validation failed', [
                    'errors' => $validator->errors()->toArray()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $firstPlan = PricingPlan::getFirstPlan();
            
            if ($firstPlan) {
                // Update existing first plan
                $updated = $firstPlan->update([
                    'title_part1' => $request->title_part1 ?: 'Choose Your',
                    'title_part2' => $request->title_part2 ?: 'Perfect Plan',
                    'subtitle' => $request->subtitle ?: 'Flexible pricing designed to scale with your needs, from startup to enterprise'
                ]);

                if (!$updated) {
                    throw new Exception('Failed to update existing plan section title');
                }

                Log::info('Updated existing plan section title', [
                    'plan_id' => $firstPlan->id,
                    'plan_name' => $firstPlan->name
                ]);

            } else {
                // Create default plan for section title management
                $defaultPlan = PricingPlan::create([
                    'name' => 'Default Plan',
                    'slug' => 'default-plan-' . time(),
                    'description' => 'This is a default plan created for section title management.',
                    'short_description' => 'Default plan for section title.',
                    'title_part1' => $request->title_part1 ?: 'Choose Your',
                    'title_part2' => $request->title_part2 ?: 'Perfect Plan',
                    'subtitle' => $request->subtitle ?: 'Flexible pricing designed to scale with your needs, from startup to enterprise',
                    'currency' => 'USD',
                    'support_level' => 'basic',
                    'icon' => 'fas fa-star',
                    'color' => 'primary',
                    'is_popular' => false,
                    'is_featured' => false,
                    'show_in_home' => false,
                    'show_in_pricing' => true,
                    'sort_order' => 0,
                    'status' => 'active'
                ]);

                Log::info('Created default plan for section title', [
                    'plan_id' => $defaultPlan->id
                ]);
            }

            DB::commit();

            Log::info('PricingPlanController@updateSectionTitle - Success');

            return response()->json([
                'success' => true,
                'message' => 'Section title updated successfully!'
            ]);

        } catch (Exception $e) {
            DB::rollback();
            
            Log::error('PricingPlanController@updateSectionTitle - Error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update section title: ' . $e->getMessage()
            ], 500);
        }
    }
}