<div>
    <div class="sm:flex sm:items-center sm:justify-between">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold leading-6 text-slate-900">Questions</h1>
            <p class="mt-2 text-sm text-slate-500">Manage exam questions with multiple types, difficulty levels, and audio support.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none flex items-center gap-3">
            <x-secondary-button wire:click="$dispatch('open-modal', 'import-modal')" wire:loading.attr="disabled">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                </svg>
                Import Excel
            </x-secondary-button>
            <x-secondary-button wire:click="$dispatch('open-modal', 'import-word-modal')" wire:loading.attr="disabled">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Import Word
            </x-secondary-button>
            <x-primary-button wire:click="create" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="create">Add Question</span>
                <span wire:loading.flex wire:target="create" class="items-center">
                    <x-loading-spinner />
                    Loading...
                </span>
            </x-primary-button>
        </div>
    </div>

    <!-- Filters -->
    <div class="mt-6 flex flex-wrap items-center gap-4">
        @if(count($selected) > 0)
            <x-danger-button 
                @click="confirmAction('Delete Selected?', 'This will delete {{ count($selected) }} question(s). This action cannot be undone!', 'Yes, delete them!', () => $wire.deleteSelected())"
                wire:loading.attr="disabled"
            >
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                Delete ({{ count($selected) }})
            </x-danger-button>
        @endif

        <div class="w-48">
            <x-select wire:model.live="filterSubject">
                <option value="">All Subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </x-select>
        </div>

        <div class="w-48">
            <x-select wire:model.live="filterType">
                <option value="">All Types</option>
                @foreach($questionTypes as $type)
                    <option value="{{ $type->value }}">{{ $type->label() }}</option>
                @endforeach
            </x-select>
        </div>

        <div class="w-48">
            <x-select wire:model.live="filterDifficulty">
                <option value="">All Difficulties</option>
                @foreach($difficultyLevels as $level)
                    <option value="{{ $level->value }}">{{ $level->label() }}</option>
                @endforeach
            </x-select>
        </div>

        <div class="relative flex-1 min-w-[200px]">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg wire:loading.remove wire:target="search" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
                <div wire:loading wire:target="search">
                    <x-loading-spinner class="h-5 w-5 text-indigo-600 ml-0 mr-0" />
                </div>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full rounded-xl border-0 py-2.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm shadow-sm" placeholder="Search questions...">
        </div>
    </div>

    <!-- Table -->
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <x-table>
                    <x-slot name="header">
                        <x-table-th class="w-12">
                            <x-checkbox wire:click="toggleSelectAll" x-bind:checked="$wire.selected.length > 0" />
                        </x-table-th>
                        <x-table-th>Question</x-table-th>
                        <x-table-th>Subject</x-table-th>
                        <x-table-th>Type</x-table-th>
                        <x-table-th>Difficulty</x-table-th>
                        <x-table-th>Status</x-table-th>
                        <x-table-th class="text-right">Actions</x-table-th>
                    </x-slot>

                    @forelse ($questions as $question)
                        <x-table-row wire:dblclick="preview({{ $question->id }})" class="cursor-pointer">
                            <x-table-td>
                                <x-checkbox wire:model.live="selected" value="{{ $question->id }}" />
                            </x-table-td>
                            <x-table-td>
                                <div class="max-w-md">
                                    <p class="font-medium text-slate-900 line-clamp-2">{{ Str::limit($question->question, 100) }}</p>
                                    @if($question->audio_file)
                                        <span class="inline-flex items-center gap-1 mt-1 text-xs text-slate-500">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" />
                                            </svg>
                                            Audio
                                        </span>
                                    @endif
                                    @if($question->timer)
                                        <span class="inline-flex items-center gap-1 mt-1 ml-2 text-xs text-slate-500">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $question->timer }}s
                                        </span>
                                    @endif
                                </div>
                            </x-table-td>
                            <x-table-td>
                                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-700/10">
                                    {{ $question->subject->name }}
                                </span>
                            </x-table-td>
                            <x-table-td>
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                    {{ $question->question_type->label() }}
                                </span>
                            </x-table-td>
                            <x-table-td>
                                @php
                                    $color = $question->difficulty_level->color();
                                @endphp
                                <span class="inline-flex items-center rounded-md bg-{{ $color }}-50 px-2 py-1 text-xs font-medium text-{{ $color }}-700 ring-1 ring-inset ring-{{ $color }}-700/10">
                                    {{ $question->difficulty_level->label() }}
                                </span>
                            </x-table-td>
                            <x-table-td>
                                @if($question->status)
                                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10">Active</span>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-700/10">Inactive</span>
                                @endif
                            </x-table-td>
                            <x-table-td class="text-right">
                                <x-table-button wire:click="edit({{ $question->id }})" color="indigo" class="mr-4">Edit</x-table-button>
                                <x-table-button @click="confirmAction('Are you sure?', 'This action cannot be undone!', 'Yes, delete it!', () => $wire.delete({{ $question->id }}))" color="red">Delete</x-table-button>
                            </x-table-td>
                        </x-table-row>
                    @empty
                        <x-table-empty title="No questions found" description="Get started by creating a new question." />
                    @endforelse
                </x-table>

                @if ($questions->hasMorePages())
                    <div class="mt-8 text-center">
                        <x-secondary-button wire:click="loadMore" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="loadMore">Load More</span>
                            <span wire:loading.flex wire:target="loadMore" class="items-center">
                                <x-loading-spinner class="text-slate-600" />
                                Loading...
                            </span>
                        </x-secondary-button>
                    </div>
                @endif
                <div class="mt-4 text-xs text-slate-400 text-center">
                    Showing {{ $questions->count() }} of {{ $questions->total() }} questions
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="question-modal" maxWidth="4xl" focusable>
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-slate-900">
                    {{ $isEdit ? 'Edit Question' : 'Add New Question' }}
                </h2>
                <button x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-500 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="subject_id" value="Subject" />
                        <div class="mt-1.5">
                            <x-select wire:model="subject_id" id="subject_id">
                            <option value="">Select a Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </x-select>
                            <x-input-error :messages="$errors->get('subject_id')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="question_type" value="Question Type" />
                        <div class="mt-1.5">
                            <x-select wire:model.live="question_type" id="question_type">
                                @foreach($questionTypes as $type)
                                    <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                @endforeach
                            </x-select>
                            <x-input-error :messages="$errors->get('question_type')" />
                        </div>
                    </div>
                </div>

                <div>
                    <x-input-label for="question" value="Question" />
                    <div class="mt-1.5">
                        <div 
                            wire:ignore
                            x-data="{
                                initEditor() {
                                    setTimeout(() => {
                                        const editorElement = $refs.editorElement;
                                        
                                        if (typeof ClassicEditor !== 'undefined' && editorElement && !editorElement._ckEditor) {
                                            ClassicEditor
                                                .create(editorElement, {
                                                    toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'link', 'imageUpload', 'insertTable', '|', 'undo', 'redo'],
                                                    image: {
                                                        toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
                                                    },
                                                    table: {
                                                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                                                    }
                                                })
                                                .then(editor => {
                                                    editorElement._ckEditor = editor;
                                                    
                                                    // Get current value from Livewire
                                                    const initialContent = $wire.get('question') || '';
                                                    editor.setData(initialContent);
                                                    
                                                    let debounceTimer;
                                                    editor.model.document.on('change:data', () => {
                                                        clearTimeout(debounceTimer);
                                                        debounceTimer = setTimeout(() => {
                                                            $wire.set('question', editor.getData());
                                                        }, 500);
                                                    });
                                                    
                                                    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                                                        return {
                                                            upload: () => {
                                                                return loader.file.then(file => {
                                                                    return new Promise((resolve, reject) => {
                                                                        const formData = new FormData();
                                                                        formData.append('upload', file);
                                                                        const uploadUrl = '{{ route("upload.image") }}';
                                                                        const csrfToken = document.querySelector('meta[name=csrf-token]').content;
                                                                        
                                                                        fetch(uploadUrl, {
                                                                            method: 'POST',
                                                                            body: formData,
                                                                            headers: {
                                                                                'X-CSRF-TOKEN': csrfToken
                                                                            }
                                                                        })
                                                                        .then(response => response.json())
                                                                        .then(data => {
                                                                            if (data.url) {
                                                                                resolve({ default: data.url });
                                                                            } else {
                                                                                reject(data.error || 'Upload failed');
                                                                            }
                                                                        })
                                                                        .catch(error => {
                                                                            console.error('Upload error:', error);
                                                                            reject(error);
                                                                        });
                                                                    });
                                                                });
                                                            }
                                                        };
                                                    };
                                                })
                                                .catch(error => {
                                                    console.error('CKEditor error:', error);
                                                });
                                        } else if (editorElement && editorElement._ckEditor) {
                                            // If editor exists, just update data
                                            const content = $wire.get('question') || '';
                                            editorElement._ckEditor.setData(content);
                                        }
                                    }, 100);
                                }
                            }"
                            x-init="initEditor()"
                            @open-modal.window="if ($event.detail === 'question-modal') initEditor()"
                            @edit-question.window="
                                if ($refs.editorElement && $refs.editorElement._ckEditor) {
                                    $refs.editorElement._ckEditor.setData($event.detail.question);
                                }
                            "
                            @reset-question.window="
                                if ($refs.editorElement && $refs.editorElement._ckEditor) {
                                    $refs.editorElement._ckEditor.setData('');
                                }
                            "
                            @close-modal.window="
                                if ($event.detail === 'question-modal') {
                                    const editorElement = $refs.editorElement;
                                    if (editorElement && editorElement._ckEditor) {
                                        editorElement._ckEditor.destroy()
                                            .then(() => {
                                                editorElement._ckEditor = null;
                                            })
                                            .catch(err => console.error('Destroy error:', err));
                                    }
                                }
                            "
                        >
                            <div x-ref="editorElement"></div>
                        </div>
                        <x-input-error :messages="$errors->get('question')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="question_image" value="Question Image (Optional)" />
                    <div class="mt-1.5">
                        @if($currentQuestionImage && !$question_image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($currentQuestionImage) }}" alt="Current question image" class="h-32 rounded-lg border border-slate-200">
                            </div>
                        @endif
                        @if($question_image)
                            <div class="mb-2">
                                <img src="{{ $question_image->temporaryUrl() }}" alt="Preview" class="h-32 rounded-lg border border-slate-200">
                            </div>
                        @endif
                        <input wire:model="question_image" id="question_image" type="file" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors">
                        <x-input-error :messages="$errors->get('question_image')" />
                        <p class="mt-1 text-xs text-slate-500">JPG, PNG, GIF (max 2MB)</p>
                        <div wire:loading wire:target="question_image" class="mt-2 text-sm text-indigo-600">Uploading...</div>
                    </div>
                </div>

                @if($question_type == 1)
                    <div class="border-t border-slate-200 pt-4">
                        <div class="flex items-center justify-between mb-3">
                            <x-input-label value="Answer Options" />
                            <button wire:click="addOption" type="button" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">+ Add Option</button>
                        </div>
                        <div class="space-y-3">
                            @foreach($options as $index => $option)
                                <div class="border border-slate-200 rounded-xl p-3">
                                    <div class="flex items-start gap-2 mb-2">
                                        <x-checkbox wire:model="options.{{ $index }}.is_correct" class="mt-2.5" />
                                        <div class="flex-1 min-w-0">
                                            <div 
                                                wire:ignore
                                                x-data="{
                                                    initOptionEditor() {
                                                        setTimeout(() => {
                                                            const editorElement = $refs.optionEditor;
                                                            
                                                            if (typeof ClassicEditor !== 'undefined' && editorElement && !editorElement._ckEditor) {
                                                                ClassicEditor
                                                                    .create(editorElement, {
                                                                        toolbar: ['bold', 'italic', '|', 'link', 'imageUpload', '|', 'undo', 'redo'],
                                                                        image: {
                                                                            toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
                                                                        }
                                                                    })
                                                                    .then(editor => {
                                                                        editorElement._ckEditor = editor;
                                                                        
                                                                        // Initial data
                                                                        const initialContent = $wire.get('options.{{ $index }}.text') || '';
                                                                        editor.setData(initialContent);
                                                                        
                                                                        let debounceTimer;
                                                                        editor.model.document.on('change:data', () => {
                                                                            clearTimeout(debounceTimer);
                                                                            debounceTimer = setTimeout(() => {
                                                                                $wire.set('options.{{ $index }}.text', editor.getData());
                                                                            }, 500);
                                                                        });

                                                                        // Upload adapter
                                                                        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                                                                            return {
                                                                                upload: () => {
                                                                                    return loader.file.then(file => {
                                                                                        return new Promise((resolve, reject) => {
                                                                                            const formData = new FormData();
                                                                                            formData.append('upload', file);
                                                                                            const uploadUrl = '{{ route("upload.image") }}';
                                                                                            const csrfToken = document.querySelector('meta[name=csrf-token]').content;
                                                                                            
                                                                                            fetch(uploadUrl, {
                                                                                                method: 'POST',
                                                                                                body: formData,
                                                                                                headers: {
                                                                                                    'X-CSRF-TOKEN': csrfToken
                                                                                                }
                                                                                            })
                                                                                            .then(response => response.json())
                                                                                            .then(data => {
                                                                                                if (data.url) {
                                                                                                    resolve({ default: data.url });
                                                                                                } else {
                                                                                                    reject(data.error || 'Upload failed');
                                                                                                }
                                                                                            })
                                                                                            .catch(error => {
                                                                                                console.error('Upload error:', error);
                                                                                                reject(error);
                                                                                            });
                                                                                        });
                                                                                    });
                                                                                }
                                                                            };
                                                                        };
                                                                    })
                                                                    .catch(error => {
                                                                        console.error('CKEditor option error:', error);
                                                                    });
                                                            }
                                                        }, 100);
                                                    }
                                                }"
                                                x-init="initOptionEditor()"
                                                @edit-question.window="
                                                    if ($refs.optionEditor && $refs.optionEditor._ckEditor && $event.detail.options[{{ $index }}]) {
                                                        $refs.optionEditor._ckEditor.setData($event.detail.options[{{ $index }}].text || '');
                                                    }
                                                "
                                                @reset-question.window="
                                                    if ($refs.optionEditor && $refs.optionEditor._ckEditor) {
                                                        $refs.optionEditor._ckEditor.setData('');
                                                    }
                                                "
                                            >
                                                <div x-ref="optionEditor"></div>
                                            </div>
                                        </div>
                                        @if(count($options) > 2)
                                            <button wire:click="removeOption({{ $index }})" type="button" class="text-red-600 hover:text-red-500 mt-2">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="ml-7">
                                        @if(isset($option['current_image']) && $option['current_image'])
                                            <div class="mb-2">
                                                <img src="{{ Storage::url($option['current_image']) }}" alt="Current option image" class="h-20 rounded-lg border border-slate-200">
                                            </div>
                                        @endif
                                        @if(isset($optionImages[$index]) && $optionImages[$index])
                                            <div class="mb-2">
                                                <img src="{{ $optionImages[$index]->temporaryUrl() }}" alt="Preview" class="h-20 rounded-lg border border-slate-200">
                                            </div>
                                        @endif
                                        <input wire:model="optionImages.{{ $index }}" type="file" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100">
                                        <div wire:loading wire:target="optionImages.{{ $index }}" class="mt-1 text-xs text-indigo-600">Uploading...</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-2 text-xs text-slate-500">Check the box for the correct answer(s)</p>
                    </div>
                @endif

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="difficulty_level" value="Difficulty" />
                        <div class="mt-1.5">
                            <x-select wire:model="difficulty_level" id="difficulty_level">
                                @foreach($difficultyLevels as $level)
                                    <option value="{{ $level->value }}">{{ $level->label() }}</option>
                                @endforeach
                            </x-select>
                            <x-input-error :messages="$errors->get('difficulty_level')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="timer" value="Timer (seconds)" />
                        <div class="mt-1.5">
                            <x-text-input wire:model="timer" id="timer" type="number" min="0" max="3600" placeholder="Optional (max 3600s)" />
                            <x-input-error :messages="$errors->get('timer')" />
                            <p class="mt-1 text-xs text-slate-500">Leave empty for no timer. Max 60 minutes (3600s)</p>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="status" value="Status" />
                        <div class="mt-1.5">
                            <select wire:model="status" id="status" class="block w-full rounded-xl border-0 py-3 px-4 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <x-input-label for="audio_file" value="Audio File (Optional)" />
                    <div class="mt-1.5">
                        @if($currentAudioFile && !$audio_file)
                            <div class="mb-2 text-sm text-slate-600">
                                Current: {{ basename($currentAudioFile) }}
                            </div>
                        @endif
                        <input wire:model="audio_file" id="audio_file" type="file" accept="audio/mp3,audio/wav,audio/ogg" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors">
                        <x-input-error :messages="$errors->get('audio_file')" />
                        <p class="mt-1 text-xs text-slate-500">MP3, WAV, or OGG (max 10MB)</p>
                        <div wire:loading wire:target="audio_file" class="mt-2 text-sm text-indigo-600">Uploading...</div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-primary-button wire:click="store" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="store">Save Question</span>
                    <span wire:loading.flex wire:target="store" class="items-center">
                        <x-loading-spinner />
                        Saving...
                    </span>
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    <!-- Import Modal -->
    <x-modal name="import-modal" focusable>
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-slate-900">Import Questions</h2>
                <button x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-500 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mb-5">
                <div class="rounded-xl bg-blue-50 p-4 ring-1 ring-blue-100">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm text-blue-700">
                                Download the template file first, fill it with your questions data, then upload it here.
                                <button wire:click="downloadTemplate" class="font-semibold underline hover:text-blue-600">Download Template</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="space-y-4">
                <div>
                    <x-input-label for="import-excel-subject" value="Select Subject" />
                    <div class="mt-1.5">
                        <x-select wire:model="importExcelSubjectId" id="import-excel-subject">
                            <option value="">Select a subject...</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <x-input-error :messages="$errors->get('importExcelSubjectId')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="importFile" value="Excel/CSV File" />
                    <div class="mt-1.5">
                        <input wire:model="importFile" id="importFile" type="file" accept=".xlsx,.xls,.csv" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors">
                        <x-input-error :messages="$errors->get('importFile')" />
                        <p class="mt-1 text-xs text-slate-500">Supported formats: XLSX, XLS, CSV (max 5MB)</p>
                        <div wire:loading wire:target="importFile" class="mt-2 text-sm text-indigo-600">Uploading...</div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-4">
                    <h3 class="text-sm font-semibold text-slate-900 mb-2">Format Guide:</h3>
                    <ul class="text-xs text-slate-600 space-y-1">
                        <li>• <strong>no</strong>: Nomor soal (sama untuk baris soal dan jawaban)</li>
                        <li>• <strong>jenis</strong>: SOAL atau JAWABAN</li>
                        <li>• <strong>kode</strong>: Q (untuk soal) atau A (untuk jawaban)</li>
                        <li>• <strong>isi</strong>: 
                            <ul class="ml-4 mt-1">
                                <li>- Jika Q: Pertanyaan|Timer (contoh: 2+2=?|60)</li>
                                <li>- Jika A: Teks jawaban</li>
                            </ul>
                        </li>
                        <li>• <strong>status jawaban</strong>: 1 (untuk jawaban benar), 0 (untuk jawaban salah)</li>
                        <li>• <strong>tingkat kesulitan soal</strong>: 1=Easy, 2=Medium, 3=Hard (hanya untuk row Q)</li>
                        <li class="mt-2 pt-2 border-t border-slate-200 text-blue-600">
                            <strong>Note:</strong> Subject dipilih dari dropdown di atas. Tipe soal otomatis Pilihan Ganda. Template sudah support sampai opsi E (5 jawaban).
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-primary-button wire:click="import" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="import">Import Questions</span>
                    <span wire:loading.flex wire:target="import" class="items-center">
                        <x-loading-spinner />
                        Importing...
                    </span>
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    <!-- Preview Modal -->
    <x-modal name="preview-modal" maxWidth="4xl" focusable x-on:close="$wire.closePreview()">
        @if($previewQuestion)
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Question Preview</h2>
                        <p class="text-sm text-slate-500 mt-1">This is how students will see this question</p>
                    </div>
                    <button x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-500 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Question Info -->
                <div class="mb-6 flex items-center gap-3 flex-wrap">
                    <span class="inline-flex items-center rounded-md bg-emerald-50 px-3 py-1 text-sm font-medium text-emerald-700 ring-1 ring-inset ring-emerald-700/10">
                        {{ $previewQuestion->subject->name }}
                    </span>
                    <span class="inline-flex items-center rounded-md bg-blue-50 px-3 py-1 text-sm font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                        {{ $previewQuestion->question_type->label() }}
                    </span>
                    @php
                        $color = $previewQuestion->difficulty_level->color();
                    @endphp
                    <span class="inline-flex items-center rounded-md bg-{{ $color }}-50 px-3 py-1 text-sm font-medium text-{{ $color }}-700 ring-1 ring-inset ring-{{ $color }}-700/10">
                        {{ $previewQuestion->difficulty_level->label() }}
                    </span>
                    @if($previewQuestion->timer)
                        <span class="inline-flex items-center gap-1.5 rounded-md bg-slate-50 px-3 py-1 text-sm font-medium text-slate-700 ring-1 ring-inset ring-slate-700/10">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $previewQuestion->timer }}s
                        </span>
                    @endif
                </div>

                <!-- Question Content -->
                <div class="bg-slate-50 rounded-2xl p-6 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Question:</h3>
                    <div class="text-slate-700 prose prose-sm max-w-none mb-4">
                        {!! $previewQuestion->question !!}
                    </div>
                    
                    @if($previewQuestion->image)
                        <div class="mt-4">
                            <img src="{{ Storage::url($previewQuestion->image) }}" alt="Question image" class="max-w-full h-auto rounded-lg border border-slate-200 shadow-sm">
                        </div>
                    @endif

                    @if($previewQuestion->audio_file)
                        <div class="mt-4">
                            <audio controls class="w-full">
                                <source src="{{ Storage::url($previewQuestion->audio_file) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    @endif
                </div>

                <!-- Answer Options (for Multiple Choice) -->
                @if($previewQuestion->question_type->value == 1 && $previewQuestion->options->count() > 0)
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Answer Options:</h3>
                        <div class="space-y-3">
                            @foreach($previewQuestion->options as $index => $option)
                                <div class="flex items-start gap-3 p-4 rounded-xl border-2 {{ $option->is_correct ? 'border-green-500 bg-green-50' : 'border-slate-200 bg-white' }} transition-colors">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $option->is_correct ? 'bg-green-500 text-white' : 'bg-slate-200 text-slate-700' }} flex items-center justify-center font-semibold">
                                        {{ chr(65 + $index) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-slate-900 prose prose-sm max-w-none">{!! $option->option_text !!}</div>
                                        @if($option->image)
                                            <div class="mt-3">
                                                <img src="{{ Storage::url($option->image) }}" alt="Option image" class="max-w-sm h-auto rounded-lg border border-slate-200 shadow-sm">
                                            </div>
                                        @endif
                                    </div>
                                    @if($option->is_correct)
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($previewQuestion->question_type->value == 2)
                    <div class="bg-white rounded-xl border-2 border-dashed border-slate-300 p-6">
                        <p class="text-slate-500 text-center italic">Students will write their essay answer here</p>
                    </div>
                @endif

                @if($previewQuestion->question_type->value == 3)
                    <div class="bg-white rounded-xl border-2 border-slate-300 p-4">
                        <input type="text" disabled placeholder="Students will type their short answer here..." class="w-full border-0 bg-transparent text-slate-500 placeholder:text-slate-400">
                    </div>
                @endif

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">Close Preview</x-secondary-button>
                </div>
            </div>
        @endif
    </x-modal>

    <!-- Import Word Modal -->
    <x-modal name="import-word-modal" maxWidth="4xl" focusable>
        <div class="p-6">
            <h2 class="text-xl font-semibold text-slate-900 mb-4">Import Questions from Word</h2>
            <p class="text-sm text-slate-600 mb-6">
                Paste your questions from Word document below. The system will automatically parse tables to extract questions and options.
            </p>

            <div class="mb-6">
                <x-input-label for="import-subject" value="Select Subject" />
                <select wire:model="importSubjectId" id="import-subject" class="mt-1.5 block w-full rounded-xl border-0 py-2.5 pl-4 pr-10 text-slate-900 ring-1 ring-inset ring-slate-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm shadow-sm bg-white">
                    <option value="">Select a subject...</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('importSubjectId')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-input-label value="Paste Content from Word" />
                <div 
                    wire:ignore
                    x-data="{}"
                    x-init="
                        setTimeout(() => {
                            const editorElement = $refs.importEditorElement;
                            
                            if (typeof ClassicEditor !== 'undefined' && editorElement && !editorElement._ckImportEditor) {
                                ClassicEditor
                                    .create(editorElement, {
                                        toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'link', 'imageUpload', 'insertTable', '|', 'undo', 'redo'],
                                        image: {
                                            toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
                                        },
                                        table: {
                                            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                                        }
                                    })
                                    .then(editor => {
                                        editorElement._ckImportEditor = editor;
                                        
                                        editor.model.document.on('change:data', () => {
                                            $wire.set('importHtmlContent', editor.getData());
                                        });
                                        
                                        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                                            return {
                                                upload: () => {
                                                    return loader.file.then(file => {
                                                        return new Promise((resolve, reject) => {
                                                            const formData = new FormData();
                                                            formData.append('upload', file);
                                                            const uploadUrl = '{{ route("upload.image") }}';
                                                            const csrfToken = document.querySelector('meta[name=csrf-token]').content;
                                                            
                                                            fetch(uploadUrl, {
                                                                method: 'POST',
                                                                body: formData,
                                                                headers: {
                                                                    'X-CSRF-TOKEN': csrfToken
                                                                }
                                                            })
                                                            .then(response => response.json())
                                                            .then(data => {
                                                                if (data.url) {
                                                                    resolve({ default: data.url });
                                                                } else {
                                                                    reject(data.error || 'Upload failed');
                                                                }
                                                            })
                                                            .catch(error => {
                                                                console.error('Upload error:', error);
                                                                reject(error);
                                                            });
                                                        });
                                                    });
                                                }
                                            };
                                        };
                                    })
                                    .catch(error => {
                                        console.error('CKEditor error:', error);
                                    });
                            }
                        }, 300);
                    "
                    @close-modal.window="
                        if ($event.detail === 'import-word-modal') {
                            const editorElement = $refs.importEditorElement;
                            if (editorElement && editorElement._ckImportEditor) {
                                editorElement._ckImportEditor.destroy()
                                    .then(() => {
                                        editorElement._ckImportEditor = null;
                                    })
                                    .catch(err => console.error('Destroy error:', err));
                            }
                        }
                    "
                    class="mt-1.5"
                >
                    <div x-ref="importEditorElement" style="min-height: 300px;"></div>
                </div>
                <p class="mt-2 text-xs text-slate-500">
                    Copy and paste your questions from Word. The system expects tables with question and option columns.
                </p>
                <x-input-error :messages="$errors->get('importHtmlContent')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>
                <x-primary-button wire:click="importFromWord" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="importFromWord">Import Questions</span>
                    <span wire:loading.flex wire:target="importFromWord" class="items-center">
                        <x-loading-spinner />
                        Importing...
                    </span>
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</div>
