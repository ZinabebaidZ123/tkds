<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Service;
use App\Models\Product;
use App\Services\EmailSpamPrevention;
class ServiceContactManagementController extends Controller
{
    public function index()
    {
        $services = Service::select('id', 'title', 'contact_email')->orderBy('title')->get();
        $products = Product::select('id', 'title', 'contact_email')->orderBy('title')->get();

        $stats = [
            'total_services' => $services->count(),
            'services_with_email' => $services->whereNotNull('contact_email')->where('contact_email', '!=', '')->count(),
            'total_products' => $products->count(),
            'products_with_email' => $products->whereNotNull('contact_email')->where('contact_email', '!=', '')->count()
        ];

        Log::info('Service Contact Management - Data retrieved', [
            'services_count' => $services->count(),
            'products_count' => $products->count(),
            'first_service_email' => $services->first()?->contact_email ?? 'N/A',
            'services_sample' => $services->take(3)->map(function($s) {
                return ['id' => $s->id, 'title' => $s->title, 'email' => $s->contact_email];
            })
        ]);

        return view('admin.service-contact.index', compact('services', 'products', 'stats'));
    }

  public function updateServiceEmail(Request $request, $id)
    {
        $request->validate([
            'contact_email' => 'nullable|email|max:255'
        ]);

        try {
            // جيب الـ service بالـ ID
            $service = Service::findOrFail($id);
            
            Log::info('Attempting to update service email', [
                'service_id' => $service->id,
                'service_title' => $service->title,
                'current_email' => $service->contact_email,
                'new_email' => $request->contact_email,
                'request_data' => $request->all()
            ]);

            $oldEmail = $service->contact_email;
            
            // طريقة 1: تحديث مباشر بالـ model
            $service->contact_email = $request->contact_email;
            $updated = $service->save();

            if ($updated) {
                // تحقق من التحديث
                $service->refresh();
                
                Log::info('Service contact email update result', [
                    'service_id' => $service->id,
                    'service_title' => $service->title,
                    'old_email' => $oldEmail,
                    'new_email' => $request->contact_email,
                    'update_successful' => true,
                    'current_email' => $service->contact_email
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Service contact email updated successfully!',
                    'service' => [
                        'id' => $service->id,
                        'title' => $service->title,
                        'contact_email' => $service->contact_email
                    ]
                ]);
            } else {
                throw new \Exception('Failed to save service');
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Service not found', [
                'service_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Service not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to update service contact email', [
                'service_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update service email: ' . $e->getMessage()
            ], 500);
        }
    }

 public function updateProductEmail(Request $request, $id)
    {
        $request->validate([
            'contact_email' => 'nullable|email|max:255'
        ]);

        try {
            // جيب الـ product بالـ ID
            $product = Product::findOrFail($id);
            
            Log::info('Attempting to update product email', [
                'product_id' => $product->id,
                'product_title' => $product->title,
                'current_email' => $product->contact_email,
                'new_email' => $request->contact_email
            ]);

            $oldEmail = $product->contact_email;
            
            // تحديث مباشر بالـ model
            $product->contact_email = $request->contact_email;
            $updated = $product->save();

            if ($updated) {
                // تحقق من التحديث
                $product->refresh();

                Log::info('Product contact email update result', [
                    'product_id' => $product->id,
                    'old_email' => $oldEmail,
                    'new_email' => $request->contact_email,
                    'update_successful' => true,
                    'current_email' => $product->contact_email
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Product contact email updated successfully!',
                    'product' => [
                        'id' => $product->id,
                        'title' => $product->title,
                        'contact_email' => $product->contact_email
                    ]
                ]);
            } else {
                throw new \Exception('Failed to save product');
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Product not found', [
                'product_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Failed to update product contact email', [
                'product_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update product email: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkUpdateEmails(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.type' => 'required|in:service,product',
            'items.*.id' => 'required|integer',
            'items.*.email' => 'nullable|email|max:255'
        ]);

        $updated = 0;
        $errors = [];

        DB::beginTransaction();
        
        try {
            foreach ($request->items as $item) {
                try {
                    if ($item['type'] === 'service') {
                        $rowsAffected = DB::table('services')
                            ->where('id', $item['id'])
                            ->update(['contact_email' => $item['email']]);
                        
                        if ($rowsAffected > 0) {
                            $updated++;
                            Log::info('Bulk update: Service email updated', [
                                'service_id' => $item['id'],
                                'email' => $item['email']
                            ]);
                        }
                    } elseif ($item['type'] === 'product') {
                        $rowsAffected = DB::table('products')
                            ->where('id', $item['id'])
                            ->update(['contact_email' => $item['email']]);
                        
                        if ($rowsAffected > 0) {
                            $updated++;
                            Log::info('Bulk update: Product email updated', [
                                'product_id' => $item['id'],
                                'email' => $item['email']
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    $errors[] = "Failed to update {$item['type']} ID {$item['id']}: " . $e->getMessage();
                    Log::error('Bulk update failed for item', [
                        'item' => $item,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            DB::commit();

            if (!empty($errors)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some updates failed: ' . implode(', ', $errors),
                    'updated' => $updated
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => "Updated {$updated} items successfully!"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk update transaction failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Bulk update failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function testEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'item_type' => 'required|in:service,product',
            'item_id' => 'required|integer'
        ]);

        try {
            $this->configureSMTP();

            if ($request->item_type === 'service') {
                $item = DB::table('services')
                    ->select('id', 'title', 'contact_email')
                    ->where('id', $request->item_id)
                    ->first();
                $itemName = $item ? $item->title : 'Unknown Service';
                $storedEmail = $item ? $item->contact_email : null;
            } else {
                $item = DB::table('products')
                    ->select('id', 'title', 'contact_email')
                    ->where('id', $request->item_id)
                    ->first();
                $itemName = $item ? $item->title : 'Unknown Product';
                $storedEmail = $item ? $item->contact_email : null;
            }

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found'
                ], 404);
            }

            Log::info('Test email - checking stored vs requested email', [
                'item_type' => $request->item_type,
                'item_id' => $request->item_id,
                'stored_email' => $storedEmail,
                'requested_email' => $request->email,
                'item_name' => $itemName
            ]);

            if (!view()->exists('emails.service-contact')) {
                Log::error('Email template missing: emails.service-contact');
                return response()->json([
                    'success' => false,
                    'message' => 'Email template not found. Please check if emails/service-contact.blade.php exists.'
                ], 500);
            }

            $testData = [
                'name' => 'Test Customer',
                'email' => 'test@example.com',
                'phone' => '+1234567890',
                'customerMessage' => 'This is a test message to verify the email configuration works correctly. This email was sent from the admin panel to test the contact email setup.',
                'payNow' => false,
                'itemType' => ucfirst($request->item_type),
                'itemName' => $itemName,
                'itemId' => $request->item_id,
                'submittedAt' => now()->format('F j, Y g:i A'),
                'priority' => 'TEST'
            ];

            Mail::send('emails.service-contact', $testData, function ($mailMessage) use ($request, $itemName) {
                $mailMessage->to($request->email)
                           ->subject("[TEST] Email Configuration Test for {$itemName}")
                           ->from('ai@tkds.email', 'TKDS Media Test');
            });

            Log::info('Test email sent successfully', [
                'recipient' => $request->email,
                'item_type' => $request->item_type,
                'item_id' => $request->item_id,
                'item_name' => $itemName,
                'stored_email_in_db' => $storedEmail
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully to ' . $request->email . 
                           ($storedEmail ? " (Stored email in DB: {$storedEmail})" : " (No email stored in DB)")
            ]);

        } catch (\Exception $e) {
            Log::error('Test email failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'email' => $request->email,
                'item_type' => $request->item_type,
                'item_id' => $request->item_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send test email: ' . $e->getMessage()
            ], 500);
        }
    }

    private function configureSMTP()
    {
        try {
            config([
                'mail.default'                 => 'smtp',
                'mail.mailers.smtp.host'       => 'mail.tkds.email',
                'mail.mailers.smtp.port'       => 465,
                'mail.mailers.smtp.encryption' => 'ssl',
                'mail.mailers.smtp.username'   => 'ai@tkds.email',
                'mail.mailers.smtp.password'   => 'Ichn2020',
                'mail.from.address'            => 'ai@tkds.email',
                'mail.from.name'               => 'TKDS Media Test',
            ]);

            Log::debug('SMTP configuration applied for test email');

        } catch (\Exception $e) {
            Log::error('Failed to configure SMTP', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function checkEmailStatus()
    {
        try {
            $services = DB::table('services')->select('id', 'title', 'contact_email')->get();
            $products = DB::table('products')->select('id', 'title', 'contact_email')->get();

            Log::info('Current database state check', [
                'services_count' => $services->count(),
                'products_count' => $products->count(),
                'services_with_email' => $services->whereNotNull('contact_email')->where('contact_email', '!=', '')->count(),
                'products_with_email' => $products->whereNotNull('contact_email')->where('contact_email', '!=', '')->count()
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'services' => $services->map(function($service) {
                        return [
                            'id' => $service->id,
                            'title' => $service->title,
                            'contact_email' => $service->contact_email,
                            'has_email' => !empty($service->contact_email)
                        ];
                    }),
                    'products' => $products->map(function($product) {
                        return [
                            'id' => $product->id,
                            'title' => $product->title,
                            'contact_email' => $product->contact_email,
                            'has_email' => !empty($product->contact_email)
                        ];
                    })
                ],
                'stats' => [
                    'total_services' => $services->count(),
                    'services_with_email' => $services->whereNotNull('contact_email')->where('contact_email', '!=', '')->count(),
                    'total_products' => $products->count(),
                    'products_with_email' => $products->whereNotNull('contact_email')->where('contact_email', '!=', '')->count()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to check email status', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to check email status: ' . $e->getMessage()
            ], 500);
        }
    }
}