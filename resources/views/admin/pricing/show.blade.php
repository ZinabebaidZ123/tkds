@extends('admin.layouts.app')

@section('title', $pricingPlan->name . ' - Plan Details')
@section('page-title', 'Plan Details: ' . $pricingPlan->name)

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.pricing-plans.index') }}" 
               class="flex items-center justify-center w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                <i class="fas fa-arrow-left text-gray-600"></i>
            </a>
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $pricingPlan->name }}</h2>
                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $pricingPlan->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($pricingPlan->status) }}
                    </span>
                    @if($pricingPlan->isPopular())
                        <span class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Popular</span>
                    @endif
                    @if($pricingPlan->isFeatured())
                        <span class="px-3 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">Featured</span>
                    @endif
                </div>
                <p class="text-gray-600">{{ $pricingPlan->short_description }}</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.pricing-plans.edit', $pricingPlan) }}" 
               class="inline-flex items-center bg-primary hover:bg-secondary text-white px-4 py-2 rounded-xl font-medium transition-all duration-200">
                <i class="fas fa-edit mr-2"></i>
                Edit Plan
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Subscribers</p>
                    <p class="text-2xl font-bold">{{ $stats['total_subscribers'] }}</p>
                </div>
                <i class="fas fa-users text-3xl text-blue-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Active Subscribers</p>
                    <p class="text-2xl font-bold">{{ $stats['active_subscribers'] }}</p>
                </div>
                <i class="fas fa-check-circle text-3xl text-green-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Monthly Revenue</p>
                    <p class="text-2xl font-bold">${{ number_format($stats['monthly_revenue'], 0) }}</p>
                </div>
                <i class="fas fa-chart-line text-3xl text-purple-200"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Yearly Revenue</p>
                    <p class="text-2xl font-bold">${{ number_format($stats['yearly_revenue'], 0) }}</p>
                </div>
                <i class="fas fa-calendar text-3xl text-yellow-200"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Plan Details -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Plan Information</h3>
            </div>
            @if($pricingPlan->hasSetupFee())
    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-4">
        <div class="flex items-center">
            <i class="fas fa-plus-circle text-orange-600 mr-2"></i>
            <div>
                <div class="font-semibold text-orange-800">Setup Fee</div>
                <div class="text-orange-700">{{ $pricingPlan->getFormattedSetupFee() }}</div>
            </div>
        </div>
    </div>
@endif
            <div class="p-6 space-y-6">
                <!-- Plan Preview -->
                <div class="bg-gray-900 rounded-xl p-6 text-white text-center">
                    <div class="w-16 h-16 bg-gradient-to-r {{ $pricingPlan->getColorClass() }} rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="{{ $pricingPlan->icon }} text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">{{ $pricingPlan->name }}</h3>
                    <p class="text-gray-400 mb-4">{{ $pricingPlan->short_description }}</p>
                    
                    <div class="flex justify-center space-x-6 mb-6">
                        @if($pricingPlan->price_monthly)
                            <div class="text-center">
                                <div class="text-2xl font-bold">${{ number_format($pricingPlan->price_monthly, 0) }}</div>
                                <div class="text-sm text-gray-400">per month</div>
                            </div>
                        @endif
                        @if($pricingPlan->price_yearly)
                            <div class="text-center">
                                <div class="text-2xl font-bold">${{ number_format($pricingPlan->price_yearly, 0) }}</div>
                                <div class="text-sm text-gray-400">per year</div>
                                @if($pricingPlan->getYearlySavingsPercentage() > 0)
                                    <div class="text-xs text-green-400">Save {{ $pricingPlan->getYearlySavingsPercentage() }}%</div>
                                @endif
                            </div>
                        @endif
                        @if(!$pricingPlan->price_monthly && !$pricingPlan->price_yearly)
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-400">Free</div>
                                <div class="text-sm text-gray-400">forever</div>
                            </div>
                        @endif
                    </div>
                    
                    @if($pricingPlan->trial_days)
                        <div class="bg-blue-500/20 rounded-lg p-3 mb-4">
                            <div class="text-blue-300 text-sm">
                                <i class="fas fa-gift mr-2"></i>
                                {{ $pricingPlan->trial_days }} days free trial
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Basic Details -->
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <label class="text-gray-500">Slug</label>
                        <div class="font-medium">{{ $pricingPlan->slug }}</div>
                    </div>
                    <div>
                        <label class="text-gray-500">Currency</label>
                        <div class="font-medium">{{ $pricingPlan->currency }}</div>
                    </div>
                    <div>
                        <label class="text-gray-500">Sort Order</label>
                        <div class="font-medium">{{ $pricingPlan->sort_order }}</div>
                    </div>
                    <div>
                        <label class="text-gray-500">Support Level</label>
                        <div class="font-medium capitalize">{{ $pricingPlan->support_level }}</div>
                    </div>
                </div>

                <!-- Description -->
                @if($pricingPlan->description)
                    <div>
                        <label class="text-gray-500 text-sm">Description</label>
                        <div class="mt-1 text-gray-900">{{ $pricingPlan->description }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Features & Limits -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Features & Limits</h3>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Features -->
                @if($pricingPlan->getFeatures())
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Plan Features</h4>
                        <div class="space-y-2">
                            @foreach($pricingPlan->getFeatures() as $feature)
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-check text-green-500"></i>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Limits -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">Usage Limits</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-gray-500">Max Users</div>
                            <div class="font-semibold">{{ $pricingPlan->max_users ?: 'Unlimited' }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-gray-500">Max Projects</div>
                            <div class="font-semibold">{{ $pricingPlan->max_projects ?: 'Unlimited' }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-gray-500">Storage</div>
                            <div class="font-semibold">{{ $pricingPlan->storage_limit ?: 'Unlimited' }}</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="text-gray-500">Bandwidth</div>
                            <div class="font-semibold">{{ $pricingPlan->bandwidth_limit ?: 'Unlimited' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Display Settings -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3">Display Settings</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Show on Homepage</span>
                            <span class="px-2 py-1 text-xs rounded-full {{ $pricingPlan->show_in_home ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $pricingPlan->show_in_home ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Show on Pricing Page</span>
                            <span class="px-2 py-1 text-xs rounded-full {{ $pricingPlan->show_in_pricing ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $pricingPlan->show_in_pricing ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Stripe Integration -->
                @if($pricingPlan->stripe_product_id)
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Stripe Integration</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Product ID:</span>
                                <span class="font-mono text-xs">{{ $pricingPlan->stripe_product_id }}</span>
                            </div>
                            @if($pricingPlan->stripe_price_id_monthly)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Monthly Price ID:</span>
                                    <span class="font-mono text-xs">{{ $pricingPlan->stripe_price_id_monthly }}</span>
                                </div>
                            @endif
                            @if($pricingPlan->stripe_price_id_yearly)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Yearly Price ID:</span>
                                    <span class="font-mono text-xs">{{ $pricingPlan->stripe_price_id_yearly }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                            <span class="text-yellow-800 text-sm">Not connected to Stripe</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Subscriptions -->
    @if($recentSubscriptions->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Recent Subscriptions</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Billing</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentSubscriptions as $subscription)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">
                                            {{ substr($subscription->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $subscription->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $subscription->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php $badge = $subscription->getStatusBadge() @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badge['class'] }}">
                                        {{ $badge['text'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 capitalize">
                                    {{ $subscription->billing_cycle }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $subscription->getFormattedAmount() }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $subscription->created_at->format('M j, Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection