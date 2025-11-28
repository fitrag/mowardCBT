<div x-data="{ 
    timeRemaining: @entangle('timeRemaining'),
    formatTime(seconds) {
        // Ensure seconds is an integer
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
">
    <!-- Header with Timer -->
    <div class="bg-white border-b border-slate-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div>
                    <h1 class="text-lg font-semibold text-slate-900">{{ $test->name }}</h1>
                    <p class="text-sm text-slate-500">Question {{ $currentQuestionIndex + 1 }} of {{ count($questions) }}</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Timer -->
                    <div class="flex items-center gap-2 px-4 py-2 rounded-lg" 
                         :class="timeRemaining < 300 ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700'">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-mono font-semibold" x-text="formatTime(timeRemaining)"></span>
                    </div>

                    <!-- Progress -->
                    <div class="text-sm text-slate-600">
                        <span class="font-semibold">{{ $this->getAnsweredCount() }}</span> / {{ count($questions) }} answered
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Question Display -->
            <div class="lg:col-span-3">
                @php
                    $currentQuestion = $this->getCurrentQuestion();
                @endphp

                @if($currentQuestion)
                    <div wire:key="question-{{ $currentQuestion['id'] }}" 
                         class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 p-6 mb-6"
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
                                 console.log('Timer Init:', {
                                     questionId: this.questionId,
                                     timerSeconds: this.timerSeconds,
                                     startTime: this.startTime,
                                     isLocked: this.isLocked,
                                     lockedQuestions: this.lockedQuestions
                                 });
                                 
                                 if (this.timerSeconds > 0 && this.startTime && !this.isLocked) {
                                     this.updateTimer();
                                     this.timerInterval = setInterval(() => this.updateTimer(), 1000);
                                 }
                             },
                             
                             updateTimer() {
                                 const now = Math.floor(Date.now() / 1000);
                                 const elapsed = now - this.startTime;
                                 this.remainingTime = Math.max(0, this.timerSeconds - elapsed);
                                 
                                 console.log('Timer Update:', {
                                     questionId: this.questionId,
                                     now: now,
                                     elapsed: elapsed,
                                     remaining: this.remainingTime
                                 });
                                 
                                 if (this.remainingTime === 0 && !this.isLocked) {
                                     this.lockedQuestions.push(this.questionId);
                                     $wire.locked_questions.push(this.questionId);
                                     $wire.call('saveTimerState');
                                     $wire.dispatch('toast', {type: 'warning', message: 'Time is up for this question!'});
                                     if (this.timerInterval) {
                                         clearInterval(this.timerInterval);
                                     }
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
                        <!-- Question Number and Timer -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100 text-indigo-700 font-semibold text-sm">
                                    {{ $currentQuestionIndex + 1 }}
                                </span>
                                <span class="text-sm text-slate-500">
                                    @if($currentQuestion['question_type'] == 1)
                                        Multiple Choice
                                    @elseif($currentQuestion['question_type'] == 2)
                                        Essay
                                    @else
                                        Short Answer
                                    @endif
                                </span>
                            </div>
                            
                            <!-- Per-Question Timer Progress Bar -->
                            @if($currentQuestion['timer'] ?? false)
                                <div x-show="timerSeconds > 0" class="w-full max-w-xs">
                                    <!-- Timer Header -->
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2 text-sm font-medium" :class="isLocked ? 'text-gray-600' : (remainingTime <= 5 ? 'text-red-600' : (remainingTime <= 10 ? 'text-orange-600' : 'text-green-600'))">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span x-show="!isLocked" x-text="formatTime(remainingTime)"></span>
                                            <span x-show="isLocked" class="flex items-center gap-1">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                                </svg>
                                                Locked
                                            </span>
                                        </div>
                                        <span x-show="!isLocked" class="text-xs font-medium" :class="remainingTime <= 5 ? 'text-red-600 animate-pulse' : (remainingTime <= 10 ? 'text-orange-600' : 'text-gray-500')">
                                            <span x-text="Math.round((remainingTime / timerSeconds) * 100)"></span>%
                                        </span>
                                    </div>
                                    
                                    <!-- Progress Bar Container -->
                                    <div class="relative h-3 bg-gray-200 rounded-full overflow-hidden shadow-inner">
                                        <!-- Progress Bar Fill -->
                                        <div 
                                            class="h-full transition-all duration-1000 ease-linear rounded-full"
                                            :class="isLocked ? 'bg-gray-400' : (remainingTime <= 5 ? 'bg-red-500 animate-pulse' : (remainingTime <= 10 ? 'bg-orange-500' : 'bg-green-500'))"
                                            :style="`width: ${Math.max(0, Math.min(100, (remainingTime / timerSeconds) * 100))}%`"
                                        >
                                            <!-- Shine effect -->
                                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-30 animate-shimmer"></div>
                                        </div>
                                        
                                        <!-- Pulse effect when time is running out -->
                                        <div 
                                            x-show="remainingTime <= 5 && remainingTime > 0 && !isLocked"
                                            class="absolute inset-0 bg-red-500 opacity-20 animate-ping"
                                        ></div>
                                    </div>
                                    
                                    <!-- Warning Text -->
                                    <div x-show="remainingTime <= 10 && remainingTime > 0 && !isLocked" class="mt-1 text-xs font-semibold text-center" :class="remainingTime <= 5 ? 'text-red-600 animate-pulse' : 'text-orange-600'">
                                        <span x-show="remainingTime <= 5">⚠️ TIME'S ALMOST UP!</span>
                                        <span x-show="remainingTime > 5 && remainingTime <= 10">⏰ Hurry up!</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Question Text -->
                        <div class="prose prose-slate max-w-none mb-6">
                            <div class="text-lg text-slate-900">
                                {!! $currentQuestion['question'] !!}
                            </div>
                        </div>

                        <!-- Answer Options -->
                        @if($currentQuestion['question_type'] == 1)
                            <!-- Multiple Choice -->
                            <div class="space-y-3">
                                @php
                                    // Use shuffled/limited options if available, otherwise use all options
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
                                               class="flex items-start gap-3 p-4 rounded-lg border-2 transition-all"
                                               :class="isLocked ? 'border-slate-200 bg-slate-50 cursor-not-allowed opacity-60' : '{{ $isSelected ? 'border-indigo-500 bg-indigo-50 cursor-pointer' : 'border-slate-200 hover:border-slate-300 cursor-pointer' }}'">
                                            <input 
                                                type="radio" 
                                                name="question_{{ $currentQuestion['id'] }}" 
                                                value="{{ $optionText }}"
                                                wire:click="saveAnswer({{ $currentQuestion['id'] }}, '{{ $optionText }}')"
                                                @if($isSelected) checked @endif
                                                x-bind:disabled="isLocked"
                                                class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                                            >
                                            <div class="flex-1">
                                                <span class="inline-flex items-center justify-center h-6 w-6 rounded-full {{ $isSelected ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600' }} font-semibold text-sm mr-2">
                                                    {{ $letter }}
                                                </span>
                                                <span class="text-slate-700">{{ $optionText }}</span>
                                            </div>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        @elseif($currentQuestion['question_type'] == 2)
                            <!-- Essay -->
                            <div>
                                <textarea 
                                    wire:model.blur="answers.{{ $currentQuestion['id'] }}"
                                    wire:change="saveAnswer({{ $currentQuestion['id'] }}, $event.target.value)"
                                    x-bind:disabled="isLocked"
                                    rows="10"
                                    class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60"
                                    placeholder="Type your answer here..."
                                ></textarea>
                            </div>
                        @else
                            <!-- Short Answer -->
                            <div>
                                <input 
                                    type="text"
                                    wire:model.blur="answers.{{ $currentQuestion['id'] }}"
                                    wire:change="saveAnswer({{ $currentQuestion['id'] }}, $event.target.value)"
                                    x-bind:disabled="isLocked"
                                    class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60"
                                    placeholder="Type your answer here..."
                                >
                            </div>
                        @endif
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center justify-between">
                        <button 
                            wire:click="previousQuestion"
                            @if($currentQuestionIndex === 0) disabled @endif
                            class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            ← Previous
                        </button>

                        @if($currentQuestionIndex === count($questions) - 1)
                            <button 
                                onclick="confirmSubmit()"
                                class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors"
                            >
                                Submit Test
                            </button>
                        @else
                            <button 
                                wire:click="nextQuestion"
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors"
                            >
                                Next →
                            </button>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Question Navigation Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-900/5 p-6 sticky top-24">
                    <h3 class="text-sm font-semibold text-slate-900 mb-4">Question Navigator</h3>
                    
                    <div class="grid grid-cols-5 gap-2">
                        @foreach($questions as $index => $question)
                            <button 
                                wire:click="goToQuestion({{ $index }})"
                                class="h-10 w-10 rounded-lg font-medium text-sm transition-all
                                    {{ $index === $currentQuestionIndex ? 'bg-indigo-600 text-white' : '' }}
                                    {{ $index !== $currentQuestionIndex && isset($answers[$question['id']]) ? 'bg-green-100 text-green-700 ring-1 ring-green-200' : '' }}
                                    {{ $index !== $currentQuestionIndex && !isset($answers[$question['id']]) ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : '' }}
                                "
                            >
                                {{ $index + 1 }}
                            </button>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t border-slate-200">
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center gap-2">
                                <div class="h-4 w-4 rounded bg-indigo-600"></div>
                                <span class="text-slate-600">Current</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="h-4 w-4 rounded bg-green-100 ring-1 ring-green-200"></div>
                                <span class="text-slate-600">Answered</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="h-4 w-4 rounded bg-slate-100"></div>
                                <span class="text-slate-600">Not answered</span>
                            </div>
                        </div>
                    </div>

                    <button 
                        onclick="confirmSubmit()"
                        class="w-full mt-6 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors"
                    >
                        Submit Test
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmSubmit() {
    Swal.fire({
        title: 'Submit Test?',
        html: '<p class="text-slate-600">Are you sure you want to submit your test?</p><p class="text-sm text-slate-500 mt-2">You cannot change your answers after submission.</p>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, Submit!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'px-6 py-2.5 rounded-lg font-semibold',
            cancelButton: 'px-6 py-2.5 rounded-lg font-semibold'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            @this.call('submitTest');
        }
    });
}
</script>
@endpush
