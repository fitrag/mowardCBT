<div class="w-full px-2 sm:px-6 lg:px-8 py-3 sm:py-8">
    <!-- Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $test->name }}</h1>
                <p class="mt-1 sm:mt-2 text-sm text-slate-600">Test Results</p>
            </div>
            <a href="{{ route('student.dashboard') }}" wire:navigate class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors shadow-sm text-sm sm:text-base w-full sm:w-auto">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    @if(!$test->show_results)
        <!-- Results Hidden State -->
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 p-8 sm:p-12 text-center">
            <div class="mx-auto h-12 w-12 sm:h-16 sm:w-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                <svg class="h-6 w-6 sm:h-8 sm:w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-slate-900 mb-2">Results Not Available</h3>
            <p class="text-sm sm:text-base text-slate-600 mb-1">The results for this test are not available to students.</p>
            <p class="text-xs sm:text-sm text-slate-500">Please contact your instructor for more information.</p>
        </div>
    @else
        <!-- Score Card - Clean & Simple -->
        <div class="bg-gradient-to-br from-indigo-500 to-violet-600 rounded-2xl shadow-lg p-6 sm:p-8 mb-8 text-white">
            @php
                // Global setting acts as gate - both global AND per-test must be true to show score
                $globalSetting = \App\Models\Setting::get('show_score_to_students', true);
                $showScore = $globalSetting && $test->show_score_to_students;
            @endphp
            
            @if($showScore)
                <!-- Score Display -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <!-- Score Section -->
                    <div class="flex-1 text-center md:text-left">
                        <p class="text-sm font-medium text-white/80 mb-2">Your Score</p>
                        <div class="flex items-baseline gap-3 justify-center md:justify-start mb-1">
                            <span class="text-5xl sm:text-6xl font-bold">{{ number_format($attempt->score, 0) }}</span>
                            <span class="text-2xl sm:text-3xl text-white/70">/ {{ $test->max_score }}</span>
                        </div>
                        <p class="text-lg text-white/80">{{ $this->getScorePercentage() }}%</p>
                    </div>

                    <!-- Pass/Fail Badge -->
                    <div class="flex-shrink-0">
                        @if($this->isPassed())
                            <div class="inline-flex items-center gap-3 px-8 py-4 bg-white/20 backdrop-blur-sm rounded-xl border border-white/30">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-2xl font-bold">PASSED</span>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-3 px-8 py-4 bg-white/20 backdrop-blur-sm rounded-xl border border-white/30">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span class="text-2xl font-bold">NOT PASSED</span>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <!-- Score Hidden State -->
                <div class="text-center py-6">
                    <!-- Icon -->
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/20 mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    
                    <h3 class="text-2xl sm:text-3xl font-bold mb-2">Test Completed</h3>
                    <p class="text-lg text-white/90 mb-6">You have successfully submitted your answers</p>
                    
                    <!-- Pass/Fail Status -->
                    @if($this->isPassed())
                        <div class="inline-flex items-center gap-3 px-8 py-4 bg-white/20 backdrop-blur-sm rounded-xl border border-white/30 mb-4">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-2xl font-bold">PASSED</span>
                        </div>
                    @else
                        <div class="inline-flex items-center gap-3 px-8 py-4 bg-white/20 backdrop-blur-sm rounded-xl border border-white/30 mb-4">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="text-2xl font-bold">NOT PASSED</span>
                        </div>
                    @endif
                    
                    <!-- Info Message -->
                    <p class="text-sm text-white/80">
                        <svg class="inline w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        Score details are hidden by the administrator
                    </p>
                </div>
            @endif
        </div>

        @if($test->show_result_details && count($questions) > 0)
            <!-- Summary Stats -->
            <div class="grid grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 p-4 sm:p-6 text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-emerald-600">{{ $this->getCorrectCount() }}</div>
                    <div class="text-xs sm:text-sm text-slate-500 mt-1">Correct</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 p-4 sm:p-6 text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-red-600">{{ $this->getWrongCount() }}</div>
                    <div class="text-xs sm:text-sm text-slate-500 mt-1">Wrong</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-900/5 p-4 sm:p-6 text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-slate-600">{{ $this->getUnansweredCount() }}</div>
                    <div class="text-xs sm:text-sm text-slate-500 mt-1">Unanswered</div>
                </div>
            </div>
        @endif

        @if($test->show_result_details && count($questions) > 0)
            <!-- Detailed Results -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 overflow-hidden">
                <div class="px-3 sm:px-6 py-3 sm:py-5 border-b border-slate-200 bg-slate-50">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-900">Question Breakdown</h3>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($questions as $index => $question)
                        @php
                            $userAnswer = $this->getUserAnswer($question['id']);
                            $correctAnswer = $question['correct_answer'];
                            $isCorrect = $this->isCorrect($question['id'], $correctAnswer);
                            $isUnanswered = !$userAnswer;
                        @endphp

                        <div class="p-3 sm:p-6 lg:p-8 hover:bg-slate-50/50 transition-colors">
                            <!-- Question Header -->
                            <div class="flex items-start gap-3 sm:gap-4 mb-4">
                                <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 sm:h-8 sm:w-8 rounded-full {{ $isUnanswered ? 'bg-slate-100 text-slate-600' : ($isCorrect ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }} font-bold text-xs sm:text-sm mt-1">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-medium {{ $isUnanswered ? 'bg-slate-100 text-slate-800' : ($isCorrect ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                            @if($isUnanswered) Unanswered @elseif($isCorrect) Correct @else Wrong @endif
                                        </span>
                                    </div>
                                    <div class="prose prose-slate max-w-none text-slate-900 font-medium text-base sm:text-lg break-words">
                                        {!! $question['question'] !!}
                                    </div>
                                </div>
                            </div>

                            <!-- Options List -->
                            <div class="ml-0 sm:ml-12 space-y-2 sm:space-y-3 mt-4">
                                @php
                                    // Get options from question data (shuffled or limited or original)
                                    $options = $question['shuffled_options'] 
                                            ?? $question['limited_options'] 
                                            ?? $question['options'] 
                                            ?? [];
                                @endphp

                                @foreach($options as $option)
                                    @php
                                        $optionText = $option['option_text'];
                                        $isUserSelected = ($userAnswer == $optionText);
                                        $isCorrectOption = ($correctAnswer == $optionText);
                                        
                                        // Determine styling classes
                                        $containerClass = 'bg-white border-slate-200';
                                        $iconClass = 'border-slate-300 text-slate-400';
                                        $textClass = 'text-slate-600';
                                        
                                        if ($isCorrectOption) {
                                            // Correct Answer Style (Green)
                                            $containerClass = 'bg-green-50 border-green-200 ring-1 ring-green-200';
                                            $iconClass = 'border-green-500 bg-green-500 text-white';
                                            $textClass = 'text-green-900 font-medium';
                                        } elseif ($isUserSelected && !$isCorrectOption) {
                                            // Wrong User Answer Style (Red)
                                            $containerClass = 'bg-red-50 border-red-200 ring-1 ring-red-200';
                                            $iconClass = 'border-red-500 bg-red-500 text-white';
                                            $textClass = 'text-red-900 font-medium';
                                        } elseif ($isUserSelected && $isCorrectOption) {
                                            // Correct User Answer Style (Green)
                                            $containerClass = 'bg-green-50 border-green-200 ring-1 ring-green-200';
                                            $iconClass = 'border-green-500 bg-green-500 text-white';
                                            $textClass = 'text-green-900 font-medium';
                                        }
                                    @endphp

                                    <div class="relative flex flex-col sm:flex-row sm:items-center p-3 border rounded-lg {{ $containerClass }} gap-2 sm:gap-0">
                                        <div class="flex items-start sm:items-center gap-3 flex-1">
                                            <div class="flex items-center h-5 mt-0.5 sm:mt-0">
                                                @if($isCorrectOption)
                                                    <span class="flex items-center justify-center h-5 w-5 rounded-full {{ $iconClass }}">
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                        </svg>
                                                    </span>
                                                @elseif($isUserSelected)
                                                    <span class="flex items-center justify-center h-5 w-5 rounded-full {{ $iconClass }}">
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </span>
                                                @else
                                                    <span class="flex items-center justify-center h-5 w-5 rounded-full border {{ $iconClass }}"></span>
                                                @endif
                                            </div>
                                            <span class="{{ $textClass }} text-sm break-words">{{ $optionText }}</span>
                                        </div>
                                        
                                        <div class="flex items-center gap-2 ml-8 sm:ml-3">
                                            @if($isUserSelected)
                                                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider {{ $isCorrectOption ? 'text-green-700' : 'text-red-700' }} whitespace-nowrap">
                                                    Your Answer
                                                </span>
                                            @endif
                                            @if($isCorrectOption && !$isUserSelected)
                                                <span class="text-[10px] sm:text-xs font-bold text-green-700 uppercase tracking-wider whitespace-nowrap">
                                                    Correct Answer
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    @endif
    @endif
</div>
