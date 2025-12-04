<div class="flex min-h-screen">
    <!-- Left Side - Branding (Hidden on mobile) -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-indigo-700 to-indigo-800 p-12 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <!-- Decorative Gradient Orbs -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-violet-500/20 rounded-full blur-3xl"></div>
        
        <!-- Content -->
        <div class="relative z-10 flex flex-col justify-center max-w-lg mx-auto">
            <!-- Logo -->
            @php
                $appLogo = \App\Models\Setting::get('app_logo');
                $appName = \App\Models\Setting::get('app_name', 'MowardCBT');
            @endphp
            <div class="flex items-center gap-3 mb-12 group">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/20 transition-all duration-300 group-hover:bg-white/20 group-hover:scale-105 overflow-hidden">
                    @if($appLogo)
                        <img src="{{ asset('storage/' . $appLogo) }}" alt="Logo" class="w-full h-full object-cover">
                    @else
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                        </svg>
                    @endif
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">{{ $appName }}</h1>
                    <p class="text-xs text-indigo-200 mt-1">by MowardStudio</p>
                </div>
            </div>
            
            <!-- Heading -->
            <h2 class="text-4xl font-bold text-white mb-6 leading-tight">
                Computer-Based<br/>Testing Platform
            </h2>
            <p class="text-xl text-indigo-100 mb-12 leading-relaxed">
                Streamline your assessment process with our comprehensive exam management system.
            </p>
            
            <!-- Features -->
            <div class="space-y-6">
                <div class="flex items-center gap-4 group">
                    <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0 border border-white/20 transition-all duration-300 group-hover:bg-white/20 group-hover:scale-110">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-lg">Question Management</h3>
                        <p class="text-indigo-200">Create and organize exam questions</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4 group">
                    <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0 border border-white/20 transition-all duration-300 group-hover:bg-white/20 group-hover:scale-110">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-lg">Student Tracking</h3>
                        <p class="text-indigo-200">Monitor progress and performance</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4 group">
                    <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center flex-shrink-0 border border-white/20 transition-all duration-300 group-hover:bg-white/20 group-hover:scale-110">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold text-lg">Automated Grading</h3>
                        <p class="text-indigo-200">Instant results and analytics</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="flex-1 flex items-center justify-center p-8 bg-slate-50/50 relative">
        <!-- Subtle Background Pattern -->
        <div class="absolute inset-0 opacity-[0.02]">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgb(51, 65, 85) 1px, transparent 0); background-size: 24px 24px;"></div>
        </div>
        
        <div class="w-full max-w-md relative z-10">
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-8">
                @php
                    $appLogo = \App\Models\Setting::get('app_logo');
                    $appName = \App\Models\Setting::get('app_name', 'MowardCBT');
                @endphp
                <div class="inline-flex items-center gap-2 mb-4">
                    <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-600/30 overflow-hidden">
                        @if($appLogo)
                            <img src="{{ asset('storage/' . $appLogo) }}" alt="Logo" class="w-full h-full object-cover">
                        @else
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">{{ $appName }}</h1>
                        <p class="text-[10px] text-slate-500 mt-0.5">by MowardStudio</p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5 p-8 transition-all duration-300 hover:shadow-md">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-900">Welcome Back</h2>
                    <p class="mt-2 text-sm text-slate-600">Sign in to access your account</p>
                </div>

                <form wire:submit="login" class="space-y-5">
                    <!-- Email/Username -->
                    <div>
                        <x-input-label for="identifier" :value="$loginMethod === 'email' ? 'Email Address' : 'Username'" />
                        <div class="mt-1.5">
                            <x-text-input 
                                wire:model="identifier" 
                                id="identifier" 
                                :type="$loginMethod === 'email' ? 'email' : 'text'" 
                                :autocomplete="$loginMethod === 'email' ? 'email' : 'username'" 
                                required 
                                :placeholder="$loginMethod === 'email' ? 'you@example.com' : 'your_username'"
                                class="w-full"
                            />
                            <x-input-error :messages="$errors->get('identifier')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" value="Password" />
                        <div class="mt-1.5">
                            <x-text-input 
                                wire:model="password" 
                                id="password" 
                                type="password" 
                                autocomplete="current-password" 
                                required 
                                placeholder="••••••••"
                                class="w-full"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <x-checkbox wire:model="remember" id="remember-me" />
                            <label for="remember-me" class="ml-2 text-sm text-slate-700">
                                Remember me
                            </label>
                        </div>
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <x-primary-button type="submit" class="w-full justify-center" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="login">Sign in</span>
                            <span wire:loading.flex wire:target="login" class="items-center gap-2">
                                <x-loading-spinner class="h-4 w-4" />
                                Signing in...
                            </span>
                        </x-primary-button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <p class="text-center text-sm text-slate-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" wire:navigate class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                            Sign up
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
