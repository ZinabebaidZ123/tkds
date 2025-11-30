{{-- File: resources/views/admin/stripe/subscriptions.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Subscriptions')
@section('page-title', 'Subscription Management')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Subscriptions</h2>
            <p class="text-gray-600 text-sm mt-1">Manage customer subscriptions and billing</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary"
                       placeholder="User name or email">
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="trialing" {{ request('status') === 'trialing' ? 'selected' : '' }}>Trialing</option>
                    <option value="past_due" {{ request('status') === 'past_due' ? 'selected' : '' }}>Past Due</option>
                    <option value="canceled" {{ request('status') === 'canceled' ? 'selected' : '' }}>Canceled</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            
            <div>
                <label for="plan_id" class="block text-sm font-medium text-gray-700 mb-2">Plan</label>
                <select name="plan_id" id="plan_id" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Plans</option>
                    @foreach(\App\Models\PricingPlan::all() as $plan)
                        <option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="billing_cycle" class="block text-sm font-medium text-gray-700 mb-2">Billing</label>
                <select name="billing_cycle" id="billing_cycle" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Cycles</option>
                    <option value="monthly" {{ request('billing_cycle') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ request('billing_cycle') === 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </div>
            
            <div class="md:col-span-4 flex space-x-3">
                <button type="submit" 
                        class="bg-primary hover:bg-secondary text-white px-6 py-3 rounded-xl font-medium transition-all duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Search
                </button>
                <a href="{{ route('admin.stripe.subscriptions') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition-all duration-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Subscriptions Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        @if($subscriptions->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Plan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Billing</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Next Payment</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($subscriptions as $subscription)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mr-4">
                                            <span class="text-primary font-semibold text-sm">
                                                {{ substr($subscription->user->name, 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $subscription->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $subscription->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $subscription->pricingPlan->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $subscription->getBillingCycleLabel() }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php $badge = $subscription->getStatusBadge() @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $badge['class'] }}">
                                        <i class="{{ $badge['icon'] }} mr-1"></i>
                                        {{ $badge['text'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900">{{ ucfirst($subscription->billing_cycle) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $subscription->getFormattedAmount() }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($subscription->next_payment_date)
                                        <div class="text-gray-900">{{ $subscription->next_payment_date->format('M j, Y') }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $subscription->getDaysUntilRenewal() }} days
                                        </div>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900">{{ $subscription->created_at->format('M j, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $subscription->created_at->diffForHumans() }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="lg:hidden space-y-4 p-6">
                @foreach($subscriptions as $subscription)
                    <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-primary font-semibold text-sm">
                                        {{ substr($subscription->user->name, 0, 2) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $subscription->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $subscription->user->email }}</div>
                                </div>
                            </div>
                            @php $badge = $subscription->getStatusBadge() @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $badge['class'] }}">
                                <i class="{{ $badge['icon'] }} mr-1"></i>
                                {{ $badge['text'] }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Plan:</span>
                                <div class="font-medium">{{ $subscription->pricingPlan->name }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500">Amount:</span>
                                <div class="font-medium">{{ $subscription->getFormattedAmount() }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500">Billing:</span>
                                <div class="font-medium">{{ ucfirst($subscription->billing_cycle) }}</div>
                            </div>
                            <div>
                                <span class="text-gray-500">Next Payment:</span>
                                <div class="font-medium">
                                    @if($subscription->next_payment_date)
                                        {{ $subscription->next_payment_date->format('M j, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($subscriptions->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $subscriptions->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-credit-card text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No subscriptions found</h3>
                <p class="text-gray-500 mb-6">No subscriptions match your current filters.</p>
                <a href="{{ route('admin.stripe.subscriptions') }}" 
                   class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors">
                    <i class="fas fa-refresh mr-2"></i>
                    Reset Filters
                </a>
            </div>
        @endif
    </div>
</div>
@endsection