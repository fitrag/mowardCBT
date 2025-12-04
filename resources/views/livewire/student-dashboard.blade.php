<div class="w-full px-3 sm:px-6 lg:px-8 py-4 sm:py-8">
    <!-- Hero Section -->
    <div class="mb-4 sm:mb-8">
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-xl sm:rounded-2xl shadow-lg p-5 sm:p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold mb-1 sm:mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-sm sm:text-base text-indigo-100">Ready to ace your tests? Let's get started!</p>
                </div>
                <div class="hidden md:block">
                    <svg class="h-20 w-20 lg:h-24 lg:w-24 text-white opacity-20" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-6 mb-4 sm:mb-8">
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 p-4">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="flex-shrink-0">
                    <div class="h-11 w-11 sm:h-12 sm:w-12 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-500">Active Tests</p>
                    <p class="text-xl sm:text-2xl font-bold text-slate-900">{{ count($activeTests) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 p-4">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="flex-shrink-0">
                    <div class="h-11 w-11 sm:h-12 sm:w-12 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-500">Upcoming</p>
                    <p class="text-xl sm:text-2xl font-bold text-slate-900">{{ count($upcomingTests) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 p-4">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="flex-shrink-0">
                    <div class="h-11 w-11 sm:h-12 sm:w-12 rounded-lg bg-purple-100 flex items-center justify-center">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.25m-12 0A2.25 2.25 0 005.25 18.75h13.5A2.25 2.25 0 0021 16.5v-13.5" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-slate-500">Completed</p>
                    <p class="text-xl sm:text-2xl font-bold text-slate-900">{{ count($completedTests) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Tests Section -->
    @if(count($activeTests) > 0)
        <div class="mb-6 sm:mb-8">
            <div class="flex items-center gap-2 mb-3 sm:mb-4">
                <div class="h-6 sm:h-8 w-1 bg-green-600 rounded-full"></div>
                <h2 class="text-lg sm:text-xl font-bold text-slate-900">Active Tests</h2>
                <span class="px-2 py-0.5 sm:py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Available Now</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
                @foreach($activeTests as $test)
                    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 hover:shadow-md transition-shadow overflow-hidden">
                        <div class="p-4 sm:p-6">
                            <div class="flex items-start justify-between mb-3 sm:mb-4">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base sm:text-lg font-semibold text-slate-900 mb-1">{{ $test->name }}</h3>
                                    <p class="text-xs sm:text-sm text-slate-500 line-clamp-2">{{ $test->description }}</p>
                                </div>
                                <span class="flex-shrink-0 ml-2 inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            </div>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-slate-600">
                                    <svg class="h-4 w-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $test->duration }} minutes</span>
                                </div>
                                <div class="flex items-center text-sm text-slate-600">
                                    <svg class="h-4 w-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                    </svg>
                                    <span>{{ $this->getTotalQuestions($test) }} questions</span>
                                </div>
                                <div class="flex items-center text-sm text-slate-600">
                                    <svg class="h-4 w-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                    <span>Ends {{ $test->end_date->format('M d, Y H:i') }}</span>
                                </div>
                            </div>

                            @php
                                $attempt = $this->getUserAttempt($test);
                            @endphp

                            @if($attempt && $attempt->status === 'paused')
                                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold text-red-800">Test Paused</p>
                                            <p class="text-xs text-red-700">This test has been paused by the administrator.</p>
                                        </div>
                                    </div>
                                </div>
                                <button class="w-full px-4 py-2 bg-red-100 text-red-700 font-medium rounded-lg cursor-not-allowed" disabled>
                                    <svg class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                                    </svg>
                                    Test Paused
                                </button>
                            @elseif($attempt && $attempt->isInProgress())
                                <a href="{{ route('student.test.take', $test) }}" wire:navigate class="block w-full">
                                    <button class="w-full px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors">
                                        Continue Test
                                    </button>
                                </a>
                            @elseif($attempt && $attempt->isCheating())
                                <button class="w-full px-4 py-2 bg-red-100 text-red-700 font-medium rounded-lg cursor-not-allowed" disabled>
                                    <svg class="h-4 w-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                    Cheating Detected
                                </button>
                            @elseif($attempt && $attempt->isSubmitted())
                                <button class="w-full px-4 py-2 bg-slate-100 text-slate-400 font-medium rounded-lg cursor-not-allowed">
                                    Already Submitted
                                </button>
                            @else
                                <a href="{{ route('student.test.detail', $test) }}" wire:navigate class="block w-full">
                                    <button class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                                        Start Test
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Upcoming Tests Section -->
    @if(count($upcomingTests) > 0)
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-4">
                <div class="h-8 w-1 bg-blue-600 rounded-full"></div>
                <h2 class="text-xl font-bold text-slate-900">Upcoming Tests</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach($upcomingTests as $test)
                    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 overflow-hidden opacity-75">
                        <div class="p-4 sm:p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-slate-900 mb-1">{{ $test->name }}</h3>
                                    <p class="text-sm text-slate-500 line-clamp-2">{{ $test->description }}</p>
                                </div>
                                <span class="flex-shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Upcoming
                                </span>
                            </div>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-slate-600">
                                    <svg class="h-4 w-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                    <span>Starts {{ $test->start_date->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="flex items-center text-sm text-slate-600">
                                    <svg class="h-4 w-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $test->duration }} minutes</span>
                                </div>
                                <div class="flex items-center text-sm text-slate-600">
                                    <svg class="h-4 w-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                    </svg>
                                    <span>{{ $this->getTotalQuestions($test) }} questions</span>
                                </div>
                            </div>

                            <button class="w-full px-4 py-2 bg-slate-100 text-slate-500 font-medium rounded-lg cursor-not-allowed">
                                Not Available Yet
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Completed Tests Section -->
    @if(count($completedTests) > 0)
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-4">
                <div class="h-8 w-1 bg-purple-600 rounded-full"></div>
                <h2 class="text-xl font-bold text-slate-900">Completed Tests</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach($completedTests as $test)
                    @php
                        $attempt = $this->getUserAttempt($test);
                    @endphp
                    <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 overflow-hidden">
                        <div class="p-4 sm:p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-slate-900 mb-1">{{ $test->name }}</h3>
                                    <p class="text-sm text-slate-500 line-clamp-2">{{ $test->description }}</p>
                                </div>
                                @if($attempt && $attempt->isCheating())
                                    <span class="flex-shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                        Cheating
                                    </span>
                                @else
                                    <span class="flex-shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Completed
                                    </span>
                                @endif
                            </div>

                            @if($attempt && $attempt->isCheating())
                                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <p class="text-sm font-semibold text-red-800 mb-1">⚠️ Cheating Detected</p>
                                    <p class="text-xs text-red-700">This test was terminated due to suspicious activity.</p>
                                </div>
                            @elseif($attempt && $attempt->score !== null)
                                @php
                                    // Global setting acts as gate - both global AND per-test must be true to show score
                                    $globalSetting = \App\Models\Setting::get('show_score_to_students', true);
                                    $showScore = $globalSetting && $test->show_score_to_students;
                                @endphp
                                @if($showScore)
                                    <div class="mb-4 p-4 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg">
                                        <p class="text-sm text-slate-600 mb-1">Your Score</p>
                                        <p class="text-3xl font-bold text-indigo-600">{{ number_format($attempt->score, 2) }}</p>
                                        <p class="text-xs text-slate-500 mt-1">out of {{ $test->max_score }}</p>
                                    </div>
                                @else
                                    <div class="mb-4 p-4 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg">
                                        <p class="text-sm text-slate-600 mb-1">Test Completed</p>
                                        <p class="text-base font-semibold text-indigo-600">Score details hidden by administrator</p>
                                    </div>
                                @endif
                            @else
                                <div class="mb-4 p-4 bg-yellow-50 rounded-lg">
                                    <p class="text-sm text-yellow-800">Awaiting grading...</p>
                                </div>
                            @endif

                            <div class="text-sm text-slate-600 mb-4">
                                <p>Submitted: {{ $attempt->submitted_at->format('M d, Y H:i') }}</p>
                            </div>

                            @if($attempt && $attempt->isCheating())
                                <button class="w-full px-4 py-2 bg-red-100 text-red-700 font-medium rounded-lg cursor-not-allowed" disabled>
                                    <svg class="h-4 w-4 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.965 4.904l9.131 9.131a6.5 6.5 0 00-9.131-9.131zm8.07 10.192L4.904 5.965a6.5 6.5 0 009.131 9.131zM4.343 4.343a8 8 0 1111.314 11.314A8 8 0 014.343 4.343z" clip-rule="evenodd" />
                                    </svg>
                                    Results Not Available
                                </button>
                            @elseif($test->show_results && $attempt && $attempt->score !== null)
                                <a href="{{ route('student.test.result', $test) }}" wire:navigate class="block w-full">
                                    <button class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                                        View Results
                                    </button>
                                </a>
                            @else
                                <button class="w-full px-4 py-2 bg-slate-100 text-slate-500 font-medium rounded-lg cursor-not-allowed">
                                    Results Not Available
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if(count($activeTests) === 0 && count($upcomingTests) === 0 && count($completedTests) === 0)
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
            <h3 class="mt-4 text-lg font-semibold text-slate-900">No tests available</h3>
            <p class="mt-2 text-sm text-slate-500">You don't have any tests assigned at the moment. Check back later!</p>
        </div>
    @endif
</div>
