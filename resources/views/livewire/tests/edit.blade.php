<div>
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('tests.index') }}" wire:navigate class="text-slate-400 hover:text-slate-500 transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold leading-6 text-slate-900">Edit Test</h1>
                <p class="mt-1 text-sm text-slate-500">Update test details and configuration</p>
            </div>
        </div>
    </div>

    <form wire:submit="update" class="space-y-8">
        <!-- Basic Information -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5 p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-5">Basic Information</h2>
            
            <div class="space-y-5">
                <div>
                    <x-input-label for="name" value="Test Name" />
                    <div class="mt-1.5">
                        <x-text-input wire:model="name" id="name" type="text" required placeholder="e.g., Mathematics Final Exam" class="w-full" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="description" value="Description (Optional)" />
                    <div class="mt-1.5">
                        <x-textarea wire:model="description" id="description" rows="3" placeholder="Describe the test purpose and content..." class="w-full" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule & Duration -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5 p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-5">Schedule & Duration</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <x-input-label for="start_date" value="Start Date & Time" />
                    <div class="mt-1.5">
                        <x-text-input wire:model="start_date" id="start_date" type="datetime-local" required class="w-full" />
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="end_date" value="End Date & Time" />
                    <div class="mt-1.5">
                        <x-text-input wire:model="end_date" id="end_date" type="datetime-local" required class="w-full" />
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="duration" value="Duration (minutes)" />
                    <div class="mt-1.5">
                        <x-text-input wire:model="duration" id="duration" type="number" min="1" required placeholder="60" class="w-full" />
                        <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Groups -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5 p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-5">Select Groups</h2>
            
            <div>
                <x-input-label for="selected_groups" value="Groups" />
                <div class="mt-1.5">
                    <select wire:model="selected_groups" id="selected_groups" multiple size="6" class="block w-full rounded-xl border-0 py-2 px-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-500">Hold Ctrl/Cmd to select multiple groups</p>
                    <x-input-error :messages="$errors->get('selected_groups')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Subject Configurations -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5 p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-slate-900">Subject Configurations</h2>
                <x-secondary-button wire:click.prevent="addSubject" type="button">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Subject
                </x-secondary-button>
            </div>


            @if(empty($subject_configs))
                <div class="text-center py-8 text-slate-500">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <p class="mt-2">No subjects added yet. Click "Add Subject" to configure test subjects.</p>
                </div>
            @endif


            <div class="space-y-4">
                @foreach($subject_configs as $index => $config)
                    <div class="border border-slate-200 rounded-xl p-5 bg-slate-50">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-medium text-slate-900">Subject {{ $index + 1 }}</h3>
                            <button wire:click.prevent="removeSubject({{ $index }})" type="button" class="text-red-600 hover:text-red-700 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Module Selection -->
                            <div class="md:col-span-2">
                                <x-input-label for="module_{{ $index }}" value="Module *" />
                                <div class="mt-1.5">
                                    <x-select wire:model.live="subject_configs.{{ $index }}.module_id" id="module_{{ $index }}" required>
                                        <option value="">Select a module...</option>
                                        @foreach($modules as $module)
                                            <option value="{{ $module->id }}">{{ $module->name }}</option>
                                        @endforeach
                                    </x-select>
                                    <x-input-error :messages="$errors->get('subject_configs.' . $index . '.module_id')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Subject Selection (appears after module is selected) -->
                            @if(!empty($config['module_id']))
                                @php
                                    $availableSubjects = $this->getSubjectsForModule($config['module_id']);
                                @endphp
                                
                                <div class="md:col-span-2">
                                    <x-input-label for="subject_{{ $index }}" value="Subject/Topic *" />
                                    <div class="mt-1.5">
                                        <x-select wire:model.live="subject_configs.{{ $index }}.subject_id" id="subject_{{ $index }}" required>
                                            <option value="">Select a subject...</option>
                                            @foreach($availableSubjects as $subject)
                                                @php
                                                    $totalQuestions = $this->getQuestionCount($subject->id);
                                                @endphp
                                                <option value="{{ $subject->id }}">
                                                    {{ $subject->name }} ({{ $totalQuestions }} questions available)
                                                </option>
                                            @endforeach
                                        </x-select>
                                        <x-input-error :messages="$errors->get('subject_configs.' . $index . '.subject_id')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Show filtered question count -->
                                @if(!empty($config['subject_id']))
                                    @php
                                        $filteredCount = $this->getQuestionCount(
                                            $config['subject_id'],
                                            $config['question_type'],
                                            $config['difficulty_level']
                                        );
                                    @endphp
                                    <div class="md:col-span-2">
                                        <div class="rounded-lg bg-blue-50 p-3 ring-1 ring-blue-100">
                                            <p class="text-sm text-blue-700">
                                                <span class="font-semibold">{{ $filteredCount }}</span> questions available with current filters
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                <!-- Question Type Filter -->
                                <div>
                                    <x-input-label for="question_type_{{ $index }}" value="Question Type (Filter)" />
                                    <div class="mt-1.5">
                                        <x-select wire:model.live="subject_configs.{{ $index }}.question_type" id="question_type_{{ $index }}">
                                            <option value="">All Types</option>
                                            <option value="1">Multiple Choice</option>
                                            <option value="2">Essay</option>
                                            <option value="3">Short Answer</option>
                                        </x-select>
                                        <x-input-error :messages="$errors->get('subject_configs.' . $index . '.question_type')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Difficulty Level Filter -->
                                <div>
                                    <x-input-label for="difficulty_{{ $index }}" value="Difficulty Level (Filter)" />
                                    <div class="mt-1.5">
                                        <x-select wire:model.live="subject_configs.{{ $index }}.difficulty_level" id="difficulty_{{ $index }}">
                                            <option value="">All Levels</option>
                                            <option value="1">Easy</option>
                                            <option value="2">Medium</option>
                                            <option value="3">Hard</option>
                                        </x-select>
                                        <x-input-error :messages="$errors->get('subject_configs.' . $index . '.difficulty_level')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Question Count -->
                                <div>
                                    <x-input-label for="question_count_{{ $index }}" value="Question Count *" />
                                    <div class="mt-1.5">
                                        <x-text-input wire:model="subject_configs.{{ $index }}.question_count" id="question_count_{{ $index }}" type="number" min="1" required class="w-full" />
                                        <x-input-error :messages="$errors->get('subject_configs.' . $index . '.question_count')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Options Count -->
                                <div>
                                    <x-input-label for="options_count_{{ $index }}" value="Options Count (Optional)" />
                                    <div class="mt-1.5">
                                        <x-text-input wire:model="subject_configs.{{ $index }}.options_count" id="options_count_{{ $index }}" type="number" min="2" max="10" placeholder="Auto" class="w-full" />
                                        <x-input-error :messages="$errors->get('subject_configs.' . $index . '.options_count')" class="mt-2" />
                                        <p class="mt-1 text-xs text-slate-500">For multiple choice questions</p>
                                    </div>
                                </div>

                                <!-- Randomization Options -->
                                <div class="md:col-span-2 flex items-center gap-6 pt-2">
                                    <div class="flex items-center gap-2">
                                        <x-checkbox wire:model="subject_configs.{{ $index }}.randomize_questions" id="randomize_q_{{ $index }}" />
                                        <label for="randomize_q_{{ $index }}" class="text-sm font-medium text-slate-700">
                                            Randomize Questions
                                        </label>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <x-checkbox wire:model="subject_configs.{{ $index }}.randomize_answers" id="randomize_a_{{ $index }}" />
                                        <label for="randomize_a_{{ $index }}" class="text-sm font-medium text-slate-700">
                                            Randomize Answers
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            @error('subject_configs')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Scoring Configuration -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5 p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-5">Scoring Configuration</h2>
            
            @php
                $totalQuestions = $this->getTotalQuestions();
                $scorePerQuestion = $totalQuestions > 0 ? $this->getCalculatedCorrectScore() : 0;
            @endphp

            <!-- Auto-calculated Scoring Info -->
            <div class="rounded-lg bg-gradient-to-r from-indigo-50 to-blue-50 p-6 ring-1 ring-indigo-100 mb-6">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-indigo-900 mb-2">Auto-Calculated Scoring</h3>
                        <p class="text-sm text-indigo-700 mb-4">
                            Scores are automatically calculated to ensure the maximum achievable score is always <span class="font-bold">100 points</span>.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white rounded-lg p-4 ring-1 ring-indigo-100">
                                <p class="text-xs font-medium text-slate-500 mb-1">Total Questions</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $totalQuestions }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 ring-1 ring-indigo-100">
                                <p class="text-xs font-medium text-slate-500 mb-1">Score per Correct Answer</p>
                                <p class="text-2xl font-bold text-indigo-600">{{ number_format($scorePerQuestion, 2) }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 ring-1 ring-indigo-100">
                                <p class="text-xs font-medium text-slate-500 mb-1">Maximum Score</p>
                                <p class="text-2xl font-bold text-green-600">100</p>
                            </div>
                        </div>
                        @if($totalQuestions === 0)
                            <div class="mt-4 rounded-lg bg-yellow-50 p-3 ring-1 ring-yellow-200">
                                <p class="text-sm text-yellow-800">
                                    <span class="font-semibold">Note:</span> Add subjects and set question counts to see calculated scores.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Manual Penalty Scores -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="wrong_score" value="Wrong Answer Score (Penalty)" />
                    <div class="mt-1.5">
                        <x-text-input wire:model="wrong_score" id="wrong_score" type="number" step="0.01" required class="w-full" />
                        <x-input-error :messages="$errors->get('wrong_score')" class="mt-2" />
                        <p class="mt-1 text-xs text-slate-500">Use negative values for penalties (e.g., -0.25)</p>
                    </div>
                </div>

                <div>
                    <x-input-label for="unanswered_score" value="Unanswered Score" />
                    <div class="mt-1.5">
                        <x-text-input wire:model="unanswered_score" id="unanswered_score" type="number" step="0.01" required class="w-full" />
                        <x-input-error :messages="$errors->get('unanswered_score')" class="mt-2" />
                        <p class="mt-1 text-xs text-slate-500">Usually 0 (no points for unanswered)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display & Security Settings -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] ring-1 ring-slate-900/5 p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-5">Display & Security Settings</h2>
            
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <x-checkbox wire:model="show_results" id="show_results" />
                    <label for="show_results" class="text-sm font-medium text-slate-700">
                        Show results to students after completion
                    </label>
                </div>

                <div class="flex items-center gap-3">
                    <x-checkbox wire:model="show_result_details" id="show_result_details" />
                    <label for="show_result_details" class="text-sm font-medium text-slate-700">
                        Show detailed results (correct/wrong answers)
                    </label>
                </div>

                <div class="flex items-center gap-3">
                    <x-checkbox wire:model="show_score_to_students" id="show_score_to_students" />
                    <label for="show_score_to_students" class="text-sm font-medium text-slate-700">
                        Show numeric score to students
                    </label>
                </div>

                <div class="flex items-center gap-3">
                    <x-checkbox wire:model="enable_safe_browser" id="enable_safe_browser" />
                    <label for="enable_safe_browser" class="text-sm font-medium text-slate-700">
                        Enable Safe Browser (Anti-Cheating)
                        <span class="block text-xs text-slate-500 mt-0.5">Detects tab switching, blocks context menu & dev tools</span>
                    </label>
                </div>


            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('tests.index') }}" wire:navigate>
                <x-secondary-button>Cancel</x-secondary-button>
            </a>
            <x-primary-button type="submit" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="update">Update Test</span>
                <span wire:loading.flex wire:target="update" class="items-center gap-2">
                    <x-loading-spinner class="h-4 w-4" />
                    Updating...
                </span>
            </x-primary-button>
        </div>
    </form>
</div>
