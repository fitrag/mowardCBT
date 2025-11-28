<div class="w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">{{ $test->name }}</h1>
                <p class="mt-2 text-sm text-slate-600">Test Results</p>
            </div>
            <a href="{{ route('student.dashboard') }}" wire:navigate class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors shadow-sm">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    @if(!$test->show_results)
        <!-- Results Hidden State -->
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 p-12 text-center">
            <div class="mx-auto h-16 w-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                <svg class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-slate-900 mb-2">Results Not Available</h3>
            <p class="text-slate-600 mb-1">The results for this test are not available to students.</p>
            <p class="text-sm text-slate-500">Please contact your instructor for more information.</p>
        </div>
    @else
        <!-- Score Card -->
        <div class="bg-gradient-to-br from-indigo-500 to-violet-600 rounded-2xl shadow-xl p-8 mb-10 text-white">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="text-center md:text-left">
                    <h2 class="text-lg font-medium mb-1 opacity-90">Total Score</h2>
                    <div class="flex items-baseline gap-2 justify-center md:justify-start">
                        <span class="text-5xl font-bold">{{ number_format($attempt->score, 0) }}</span>
                        <span class="text-2xl opacity-75">/ {{ $test->max_score }}</span>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-white/20 backdrop-blur-sm mb-2">
                        <span class="text-2xl font-bold">{{ $this->getScorePercentage() }}%</span>
                    </div>
                    <p class="text-sm font-medium opacity-90">Percentage</p>
                </div>

                @if($test->show_result_details && count($questions) > 0)
                    <div class="flex gap-6 text-center">
                        <div>
                            <div class="text-2xl font-bold">{{ $this->getCorrectCount() }}</div>
                            <div class="text-xs uppercase tracking-wider opacity-75 mt-1">Correct</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $this->getWrongCount() }}</div>
                            <div class="text-xs uppercase tracking-wider opacity-75 mt-1">Wrong</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold">{{ $this->getUnansweredCount() }}</div>
                            <div class="text-xs uppercase tracking-wider opacity-75 mt-1">Unanswered</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($test->show_result_details && count($questions) > 0)
            <!-- Detailed Results -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                    <h3 class="text-lg font-semibold text-slate-900">Question Breakdown</h3>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($questions as $index => $question)
                        @php
                            $userAnswer = $this->getUserAnswer($question['id']);
                            $correctAnswer = $question['correct_answer'];
                            $isCorrect = $this->isCorrect($question['id'], $correctAnswer);
                            $isUnanswered = !$userAnswer;
                        @endphp

                        <div class="p-6 sm:p-8 hover:bg-slate-50/50 transition-colors">
                            <!-- Question Header -->
                            <div class="flex items-start gap-4 mb-4">
                                <span class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full {{ $isUnanswered ? 'bg-slate-100 text-slate-600' : ($isCorrect ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }} font-bold text-sm">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isUnanswered ? 'bg-slate-100 text-slate-800' : ($isCorrect ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                            @if($isUnanswered) Unanswered @elseif($isCorrect) Correct @else Wrong @endif
                                        </span>
                                    </div>
                                    <div class="prose prose-slate max-w-none text-slate-900 font-medium text-lg">
                                        {!! $question['question'] !!}
                                    </div>
                                </div>
                            </div>

                            <!-- Options List -->
                            <div class="ml-12 space-y-3">
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

                                    <div class="relative flex items-center p-3 border rounded-lg {{ $containerClass }}">
                                        <div class="flex items-center h-5">
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
                                        <div class="ml-3 text-sm flex-1 flex items-center justify-between">
                                            <span class="{{ $textClass }}">{{ $optionText }}</span>
                                            
                                            <div class="flex items-center gap-2">
                                                @if($isUserSelected)
                                                    <span class="text-xs font-bold uppercase tracking-wider {{ $isCorrectOption ? 'text-green-700' : 'text-red-700' }}">
                                                        Your Answer
                                                    </span>
                                                @endif
                                                @if($isCorrectOption && !$isUserSelected)
                                                    <span class="text-xs font-bold text-green-700 uppercase tracking-wider">
                                                        Correct Answer
                                                    </span>
                                                @endif
                                            </div>
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
