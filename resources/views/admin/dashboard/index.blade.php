@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-primary to-secondary rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">Welcome back, {{ auth('admin')->user()->name }}! 👋</h2>
                <p class="text-white/80 text-lg">Ready to manage your TKDS Media platform</p>
            </div>
            <div class="hidden md:block">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-chart-line text-4xl text-white"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Stat Card 1 -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Coming Soon</p>
                    <p class="text-2xl font-bold text-gray-900">Blog Posts</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-newspaper text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Stat Card 2 -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Coming Soon</p>
                    <p class="text-2xl font-bold text-gray-900">Services</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-cogs text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Stat Card 3 -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Coming Soon</p>
                    <p class="text-2xl font-bold text-gray-900">Packages</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Stat Card 4 -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Coming Soon</p>
                    <p class="text-2xl font-bold text-gray-900">Team Members</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Left Column -->
        <div class="space-y-6">
            
            <!-- Recent Activity Card -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                    <i class="fas fa-clock text-gray-400"></i>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user-plus text-primary"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Admin account created</p>
                            <p class="text-xs text-gray-500">Welcome to TKDS Media Admin Panel</p>
                        </div>
                        <span class="text-xs text-gray-400">Just now</span>
                    </div>
                    
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">More activities will appear here as you use the system</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions Card -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <button class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary hover:bg-primary/5 transition-colors duration-300 cursor-not-allowed opacity-50">
                        <i class="fas fa-plus text-2xl text-gray-400 mb-2"></i>
                        <span class="text-sm font-medium text-gray-600">Add Post</span>
                        <span class="text-xs text-gray-400 mt-1">Coming Soon</span>
                    </button>
                    
                    <button class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary hover:bg-primary/5 transition-colors duration-300 cursor-not-allowed opacity-50">
                        <i class="fas fa-cog text-2xl text-gray-400 mb-2"></i>
                        <span class="text-sm font-medium text-gray-600">Add Service</span>
                        <span class="text-xs text-gray-400 mt-1">Coming Soon</span>
                    </button>
                    
                    <button class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary hover:bg-primary/5 transition-colors duration-300 cursor-not-allowed opacity-50">
                        <i class="fas fa-box text-2xl text-gray-400 mb-2"></i>
                        <span class="text-sm font-medium text-gray-600">Add Package</span>
                        <span class="text-xs text-gray-400 mt-1">Coming Soon</span>
                    </button>
                    
                    <button class="flex flex-col items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary hover:bg-primary/5 transition-colors duration-300 cursor-not-allowed opacity-50">
                        <i class="fas fa-user-plus text-2xl text-gray-400 mb-2"></i>
                        <span class="text-sm font-medium text-gray-600">Add Team</span>
                        <span class="text-xs text-gray-400 mt-1">Coming Soon</span>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="space-y-6">
            
            <!-- System Info Card -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">System Information</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-600">Platform Version</span>
                        <span class="text-sm font-medium text-gray-900">v1.0.0</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-600">Laravel Version</span>
                        <span class="text-sm font-medium text-gray-900">{{ app()->version() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-600">PHP Version</span>
                        <span class="text-sm font-medium text-gray-900">{{ PHP_VERSION }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-600">Last Login</span>
                        <span class="text-sm font-medium text-gray-900">{{ now()->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Development Status Card -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                <div class="flex items-start">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-code text-blue-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Development Mode</h3>
                        <p class="text-sm text-blue-700 mb-4">The admin panel is ready for development. Features will be added progressively.</p>
                        
                        <div class="space-y-2">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span class="text-blue-700">Admin Authentication</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span class="text-blue-700">Dashboard Layout</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-clock text-yellow-500 mr-2"></i>
                                <span class="text-blue-700">Content Management (Coming Soon)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Help Card -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Need Help?</h3>
                
                <div class="space-y-3">
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-book text-primary mr-3"></i>
                        <span class="text-sm font-medium text-gray-700">Documentation</span>
                    </a>
                    
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-life-ring text-primary mr-3"></i>
                        <span class="text-sm font-medium text-gray-700">Support Center</span>
                    </a>
                    
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-envelope text-primary mr-3"></i>
                        <span class="text-sm font-medium text-gray-700">Contact Developer</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection