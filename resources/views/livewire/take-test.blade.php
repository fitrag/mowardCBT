<div x-data="{ 
    timeRemaining: @entangle('timeRemaining'),
    formatTime(seconds) {
        seconds = Math.floor(seconds);
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const secs = seconds % 60;
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }
}" x-init="
    setInterval(() => {
        if (timeRemaining > 0) {
            timeRemaining--;
        } else {
            $wire.submitTest();
        }
    }, 1000);

    // Save elapsed time to backend every 15 seconds (optimized)
    // This ensures timer persists across page refreshes
    setInterval(() => {
        $wire.updateElapsedTime();
    }, 15000);

    // Check for pause status every 10 seconds (optimized)
    setInterval(() => {
        $wire.checkPauseStatus();
    }, 10000);

    // Listen for test paused event
    window.addEventListener('test-paused', () => {
        Swal.fire({
            title: 'Test Paused',
            text: 'Your test has been paused by the administrator. Please contact your instructor.',
            icon: 'warning',
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'OK',
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'px-6 py-3 rounded-xl font-bold'
            }
        }).then(() => {
            window.location.href = '{{ route('student.dashboard') }}';
        });
    });

    // Anti-Cheating Measures
    @if($test->enable_safe_browser)
        document.addEventListener('contextmenu', event => event.preventDefault());
        document.addEventListener('keydown', function(e) {
            if (
                e.keyCode === 123 ||
                (e.ctrlKey && e.shiftKey && e.keyCode === 73) ||
                (e.ctrlKey && e.shiftKey && e.keyCode === 74) ||
                (e.ctrlKey && e.keyCode === 85)
            ) {
                e.preventDefault();
                return false;
            }
        });

        const handleViolation = () => {
            $wire.handleCheating();
        };

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                handleViolation();
            }
        });

        window.addEventListener('blur', () => {
            handleViolation();
        });
    @endif
">
    <!-- Mobile-First Header - Compact & Fixed -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 sticky top-0 z-30 shadow-lg">
        <div class="px-3 sm:px-6 lg:px-12">
            <div class="flex items-center justify-between py-2.5 sm:py-3">
                <!-- Test Info -->
                <div class="flex-1 min-w-0">
                    <h1 class="text-sm sm:text-base font-semibold text-white truncate">{{ $test->name }}</h1>
                    <p class="text-xs text-indigo-100">Q {{ $currentQuestionIndex + 1 }}/{{ count($questions) }}</p>
                </div>
                
                <!-- Timer & Progress -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <!-- Timer -->
                    <div class="flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-lg text-xs sm:text-sm font-mono font-bold" 
                         :class="timeRemaining < 300 ? 'bg-red-500 text-white animate-pulse' : 'bg-white/20 text-white'">
                        <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span x-text="formatTime(timeRemaining)"></span>
                    </div>
                    
                    <!-- Progress Badge - Hidden on small mobile -->
                    <div class="hidden xs:flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-lg bg-white/20 text-white text-xs sm:text-sm font-semibold">
                        <span>{{ $this->getAnsweredCount() }}</span>
                        <span class="text-indigo-200">/</span>
                        <span>{{ count($questions) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content - Mobile Optimized -->
    <div class="min-h-screen bg-slate-50 pb-32 sm:pb-24">
        <div class="px-0 sm:px-4 lg:px-12 py-0 sm:py-4">
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-0 sm:gap-6">
                <!-- Question Card - Full Width Mobile -->
                <div class="xl:col-span-9">
                    @php
                        $currentQuestion = $this->getCurrentQuestion();
                    @endphp

                    @if($currentQuestion)
                        <div wire:key="question-{{ $currentQuestion['id'] }}" 
                             class="bg-white sm:rounded-2xl sm:shadow-sm sm:ring-1 sm:ring-slate-900/5 p-4 sm:p-6 mb-0 sm:mb-6"
                             x-data="{
                                 questionId: {{ $currentQuestion['id'] }},
                                 timerSeconds: {{ $currentQuestion['timer'] ?? 0 }},
                                 startTime: {{ $question_start_times[$currentQuestion['id']] ?? 'null' }},
                                 remainingTime: 0,
                                 lockedQuestions: @js($locked_questions),
                                 timerInterval: null,
                                 
                                 get isLocked() {
                                     return this.lockedQuestions.includes(this.questionId);
                                 },
                                 
                                 init() {
                                     if (this.timerSeconds > 0 && this.startTime && !this.isLocked) {
                                         this.updateTimer();
                                         this.timerInterval = setInterval(() => this.updateTimer(), 1000);
                                     }
                                 },
                                 
                                 updateTimer() {
                                     const now = Math.floor(Date.now() / 1000);
                                     const elapsed = now - this.startTime;
                                     this.remainingTime = Math.max(0, this.timerSeconds - elapsed);
                                     
                                     if (this.remainingTime === 0 && !this.isLocked) {
                                         this.lockedQuestions.push(this.questionId);
                                         $wire.locked_questions.push(this.questionId);
                                         $wire.call('saveTimerState');
                                         $wire.dispatch('toast', {type: 'warning', message: 'Time is up! Moving to next question...'});
                                         if (this.timerInterval) {
                                             clearInterval(this.timerInterval);
                                         }
                                         setTimeout(() => {
                                             $wire.call('nextQuestion');
                                         }, 1000);
                                     }
                                 },
                                 
                                 formatTime(seconds) {
                                     const mins = Math.floor(seconds / 60);
                                     const secs = seconds % 60;
                                     return `${mins}:${secs.toString().padStart(2, '0')}`;
                                 },
                                 
                                 getTimerColor() {
                                     if (this.isLocked) return 'bg-gray-100 text-gray-700';
                                     if (this.remainingTime <= 5) return 'bg-red-100 text-red-700 animate-pulse';
                                     if (this.remainingTime <= 10) return 'bg-orange-100 text-orange-700';
                                     return 'bg-green-100 text-green-700';
                                 }
                             }"
                        >
                            <!-- Question Header - Mobile Optimized -->
                            <div class="flex items-start justify-between mb-4 gap-3">
                                <div class="flex items-center gap-2 flex-1 min-w-0">
                                    <span class="inline-flex items-center justify-center h-8 w-8 sm:h-9 sm:w-9 rounded-full bg-indigo-100 text-indigo-700 font-bold text-sm sm:text-base flex-shrink-0">
                                        {{ $currentQuestionIndex + 1 }}
                                    </span>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-xs sm:text-sm text-slate-500 truncate">
                                            @if($currentQuestion['question_type'] == 1)
                                                Multiple Choice
                                            @elseif($currentQuestion['question_type'] == 2)
                                                Essay
                                            @else
                                                Short Answer
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Per-Question Timer - Compact Mobile -->
                                @if($currentQuestion['timer'] ?? false)
                                    <div x-show="timerSeconds > 0" class="flex-shrink-0">
                                        <div class="flex flex-col items-end gap-1">
                                            <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs sm:text-sm font-semibold" :class="getTimerColor()">
                                                <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span x-show="!isLocked" x-text="formatTime(remainingTime)"></span>
                                                <span x-show="isLocked" class="flex items-center gap-1">
                                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                                    </svg>
                                                    Locked
                                                </span>
                                            </div>
                                            <!-- Progress Bar - Mobile Compact -->
                                            <div x-show="!isLocked" class="w-24 sm:w-32 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                                <div 
                                                    class="h-full transition-all duration-1000 ease-linear"
                                                    :class="remainingTime <= 5 ? 'bg-red-500' : (remainingTime <= 10 ? 'bg-orange-500' : 'bg-green-500')"
                                                    :style="`width: ${Math.max(0, Math.min(100, (remainingTime / timerSeconds) * 100))}%`"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Question Text - Mobile Optimized -->
                            <div class="prose prose-slate max-w-none mb-5 sm:mb-6">
                                <div class="text-base sm:text-lg text-slate-900 leading-relaxed">
                                    {!! $currentQuestion['question'] !!}
                                </div>
                            </div>

                            <!-- Answer Options - Mobile Touch-Friendly -->
                            @if($currentQuestion['question_type'] == 1)
                                <!-- Multiple Choice - Large Touch Targets -->
                                <div class="space-y-2.5 sm:space-y-3">
                                    @php
                                        $options = $currentQuestion['shuffled_options'] 
                                                ?? $currentQuestion['limited_options'] 
                                                ?? $currentQuestion['options'] 
                                                ?? [];
                                        $letters = ['A', 'B', 'C', 'D', 'E'];
                                    @endphp

                                    @foreach($options as $index => $option)
                                        @php
                                            $letter = $letters[$index] ?? $index;
                                            $optionText = is_array($option) ? ($option['option_text'] ?? '') : $option;
                                            $isSelected = isset($answers[$currentQuestion['id']]) && $answers[$currentQuestion['id']] == $optionText;
                                        @endphp
                                        
                                        @if($optionText)
                                            <label wire:key="q-{{ $currentQuestion['id'] }}-opt-{{ $index }}" 
                                                   class="flex items-start gap-3 p-3.5 sm:p-4 rounded-xl border-2 transition-all active:scale-[0.98]"
                                                   :class="isLocked ? 'border-slate-200 bg-slate-50 cursor-not-allowed opacity-60' : '{{ $isSelected ? 'border-indigo-500 bg-indigo-50 shadow-md shadow-indigo-100' : 'border-slate-200 hover:border-indigo-200 active:border-indigo-300' }}'">
                                                <input 
                                                    type="radio" 
                                                    name="question_{{ $currentQuestion['id'] }}" 
                                                    value="{{ $optionText }}"
                                                    wire:click="saveAnswer({{ $currentQuestion['id'] }}, '{{ addslashes($optionText) }}')"
                                                    @if($isSelected) checked @endif
                                                    x-bind:disabled="isLocked"
                                                    class="hidden"
                                                >
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start gap-2.5">
                                                        <span class="inline-flex items-center justify-center h-7 w-7 sm:h-8 sm:w-8 rounded-full flex-shrink-0 {{ $isSelected ? 'bg-indigo-600 text-white ring-2 ring-indigo-600 ring-offset-2' : 'bg-slate-100 text-slate-600' }} font-bold text-sm transition-all">
                                                            {{ $letter }}
                                                        </span>
                                                        <span class="text-slate-700 text-sm sm:text-base prose prose-sm max-w-none flex-1 pt-0.5">{!! $optionText !!}</span>
                                                    </div>
                                                </div>
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            @elseif($currentQuestion['question_type'] == 2)
                                <!-- Essay - Mobile Optimized -->
                                <div>
                                    <textarea 
                                        wire:model.blur="answers.{{ $currentQuestion['id'] }}"
                                        wire:change="saveAnswer({{ $currentQuestion['id'] }}, $event.target.value)"
                                        x-bind:disabled="isLocked"
                                        rows="8"
                                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm sm:text-base disabled:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60"
                                        placeholder="Type your answer here..."
                                    ></textarea>
                                </div>
                            @else
                                <!-- Short Answer - Mobile Optimized -->
                                <div>
                                    <input 
                                        type="text"
                                        wire:model.blur="answers.{{ $currentQuestion['id'] }}"
                                        wire:change="saveAnswer({{ $currentQuestion['id'] }}, $event.target.value)"
                                        x-bind:disabled="isLocked"
                                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm sm:text-base disabled:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60"
                                        placeholder="Type your answer here..."
                                    >
                                </div>
                            @endif

                            <!-- Desktop Navigation Buttons (Hidden on Mobile) -->
                            <div class="hidden sm:flex items-center justify-between mt-6 pt-6 border-t border-slate-200">
                                <button 
                                    wire:click="previousQuestion"
                                    wire:loading.attr="disabled"
                                    @if($currentQuestionIndex === 0) disabled @endif
                                    class="px-5 py-2.5 bg-white border-2 border-slate-300 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                    <span wire:loading.remove wire:target="previousQuestion">Previous</span>
                                    <span wire:loading wire:target="previousQuestion">Loading...</span>
                                </button>

                                @if($currentQuestionIndex === count($questions) - 1)
                                    <button 
                                        onclick="confirmSubmit()"
                                        class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold rounded-xl transition-all shadow-lg shadow-green-500/30"
                                    >
                                        Submit Test
                                    </button>
                                @else
                                    <button 
                                        wire:click="nextQuestion"
                                        wire:loading.attr="disabled"
                                        class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold rounded-xl transition-all flex items-center gap-2 shadow-lg shadow-indigo-500/30"
                                    >
                                        <span wire:loading.remove wire:target="nextQuestion">Next</span>
                                        <span wire:loading wire:target="nextQuestion">Loading...</span>
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Desktop Question Navigator (Hidden on Mobile) -->
                <div class="hidden xl:block xl:col-span-3">
                    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 p-5 sticky top-24">
                        <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>
                            Question Navigator
                        </h3>
                        
                        <div class="grid grid-cols-5 gap-2 mb-5">
                            @foreach($questions as $index => $question)
                                @php
                                    $isCurrent = $index === $currentQuestionIndex;
                                    $isAnswered = isset($answers[$question['id']]);
                                    $isLocked = in_array($question['id'], $locked_questions);
                                @endphp
                                <button 
                                    wire:click="goToQuestion({{ $index }})"
                                    wire:loading.class="opacity-50 cursor-wait"
                                    class="h-11 w-full rounded-lg text-sm font-bold transition-all relative
                                        {{ $isCurrent ? 'bg-indigo-600 text-white ring-2 ring-indigo-600 ring-offset-2 scale-110' : 
                                           ($isAnswered ? 'bg-green-100 text-green-700 hover:bg-green-200 border-2 border-green-300' : 
                                           ($isLocked ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-white text-slate-600 hover:bg-slate-50 border-2 border-slate-200')) }}"
                                    @if($isLocked) disabled @endif
                                >
                                    {{ $index + 1 }}
                                    @if($isLocked)
                                        <span class="absolute -top-1 -right-1">
                                            <svg class="h-3.5 w-3.5 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                                        </span>
                                    @endif
                                </button>
                            @endforeach
                        </div>

                        <div class="pt-5 border-t border-slate-200 space-y-2.5 text-xs mb-5">
                            <div class="flex items-center gap-2">
                                <div class="h-4 w-4 rounded bg-indigo-600"></div>
                                <span class="text-slate-600 font-medium">Current</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="h-4 w-4 rounded bg-green-100 ring-2 ring-green-300"></div>
                                <span class="text-slate-600 font-medium">Answered</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="h-4 w-4 rounded bg-slate-100 ring-2 ring-slate-200"></div>
                                <span class="text-slate-600 font-medium">Not answered</span>
                            </div>
                        </div>

                        <button 
                            onclick="confirmSubmit()"
                            class="w-full px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold rounded-xl transition-all shadow-lg shadow-green-500/30"
                        >
                            Submit Test
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Navigation Bar - App-Like -->
    <div class="sm:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-slate-200 shadow-2xl">
        <div class="safe-area-inset-bottom">
            <!-- Navigation Buttons -->
            <div class="flex items-center justify-between px-3 py-3 gap-2">
                <!-- Previous Button -->
                <button 
                    wire:click="previousQuestion"
                    wire:loading.attr="disabled"
                    @if($currentQuestionIndex === 0) disabled @endif
                    class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-slate-100 text-slate-700 font-semibold rounded-xl transition-all active:scale-95 disabled:opacity-40 disabled:cursor-not-allowed"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    <span class="text-sm">Prev</span>
                </button>

                <!-- Question Grid Button -->
                <button 
                    @click="$dispatch('open-modal', 'question-grid')"
                    class="flex items-center justify-center gap-1.5 px-4 py-3 bg-indigo-100 text-indigo-700 font-semibold rounded-xl transition-all active:scale-95"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    <span class="text-xs font-bold">{{ $this->getAnsweredCount() }}/{{ count($questions) }}</span>
                </button>

                <!-- Next/Submit Button -->
                @if($currentQuestionIndex === count($questions) - 1)
                    <button 
                        onclick="confirmSubmit()"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold rounded-xl transition-all active:scale-95 shadow-lg shadow-green-500/30"
                    >
                        <span class="text-sm">Submit</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                @else
                    <button 
                        wire:click="nextQuestion"
                        wire:loading.attr="disabled"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-bold rounded-xl transition-all active:scale-95 shadow-lg shadow-indigo-500/30"
                    >
                        <span class="text-sm">Next</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Mobile Question Grid Modal -->
    <x-modal name="question-grid" maxWidth="full">
        <div class="p-5">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-slate-900">All Questions</h3>
                <button @click="$dispatch('close-modal', 'question-grid')" class="text-slate-400 hover:text-slate-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-5 gap-2.5 mb-5">
                @foreach($questions as $index => $question)
                    @php
                        $isCurrent = $index === $currentQuestionIndex;
                        $isAnswered = isset($answers[$question['id']]);
                        $isLocked = in_array($question['id'], $locked_questions);
                    @endphp
                    <button 
                        wire:click="goToQuestion({{ $index }})"
                        @click="$dispatch('close-modal', 'question-grid')"
                        class="h-14 w-full rounded-xl text-base font-bold transition-all
                            {{ $isCurrent ? 'bg-indigo-600 text-white ring-2 ring-indigo-600 ring-offset-2' : 
                               ($isAnswered ? 'bg-green-100 text-green-700 border-2 border-green-300' : 
                               ($isLocked ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-white text-slate-600 border-2 border-slate-200')) }}"
                        @if($isLocked) disabled @endif
                    >
                        {{ $index + 1 }}
                    </button>
                @endforeach
            </div>

            <div class="pt-4 border-t border-slate-200 space-y-3 text-sm">
                <div class="flex items-center gap-3">
                    <div class="h-5 w-5 rounded-lg bg-indigo-600"></div>
                    <span class="text-slate-700 font-medium">Current Question</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="h-5 w-5 rounded-lg bg-green-100 ring-2 ring-green-300"></div>
                    <span class="text-slate-700 font-medium">Answered</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="h-5 w-5 rounded-lg bg-slate-100 ring-2 ring-slate-200"></div>
                    <span class="text-slate-700 font-medium">Not Answered</span>
                </div>
            </div>
        </div>
    </x-modal>

    <!-- Loading Indicators -->
    <div wire:loading wire:target="nextQuestion, previousQuestion, submitTest, goToQuestion">
        <div class="fixed inset-0 z-[49] bg-black/20 backdrop-blur-sm"></div>
        <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50">
            <div class="bg-white rounded-2xl shadow-2xl p-6 flex flex-col items-center gap-3">
                <svg class="animate-spin h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-base font-semibold text-slate-900">Loading...</span>
            </div>
        </div>
    </div>

    <div wire:loading wire:target="saveAnswer" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50">
        <div class="bg-slate-900/95 backdrop-blur text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3">
            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-semibold">Saving...</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmSubmit() {
    Swal.fire({
        title: 'Submit Test?',
        html: '<p class="text-slate-600 text-base">Are you sure you want to submit your test?</p><p class="text-sm text-slate-500 mt-2">You cannot change your answers after submission.</p>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, Submit!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'px-6 py-3 rounded-xl font-bold',
            cancelButton: 'px-6 py-3 rounded-xl font-semibold'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            @this.call('submitTest');
        }
    });
}
</script>
@endpush
