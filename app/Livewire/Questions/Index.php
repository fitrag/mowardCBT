<?php

namespace App\Livewire\Questions;

use App\Enums\DifficultyLevel;
use App\Enums\QuestionType;
use App\Imports\QuestionsImport;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Subject;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination, WithFileUploads;

    #[Url(history: true)]
    public $search = '';

    public $perPage = 10;
    public $selected = [];
    public $filterSubject = '';
    public $filterType = '';
    public $filterDifficulty = '';
    public $importFile;
    public $importExcelSubjectId = '';
    public $importSubjectId = '';
    public $importHtmlContent = '';

    #[Rule('required|exists:subjects,id')]
    public $subject_id = '';

    #[Rule('required')]
    public $question = '';

    #[Rule('required|in:1,2,3')]
    public $question_type = 1;

    #[Rule('required|in:1,2,3')]
    public $difficulty_level = 1;

    #[Rule('boolean')]
    public $status = true;

    #[Rule('nullable|file|mimes:mp3,wav,ogg|max:10240')]
    public $audio_file;

    #[Rule('nullable|image|max:2048')]
    public $question_image;

    #[Rule('nullable|integer|min:0|max:3600')]
    public $timer;

    public $questionId;
    public $isEdit = false;
    public $currentAudioFile;
    public $currentQuestionImage;
    public $previewQuestion = null;

    // For multiple choice options
    public $options = [];
    public $optionImages = [];

    public function mount()
    {
        $this->resetOptions();
    }

    public function uploadImage($imageData)
    {
        try {
            // Remove data:image/...;base64, prefix
            $image = str_replace('data:image/png;base64,', '', $imageData);
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace('data:image/jpg;base64,', '', $image);
            $image = str_replace('data:image/gif;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            
            $imageName = 'question_' . time() . '_' . uniqid() . '.png';
            $path = 'questions/' . $imageName;
            
            Storage::disk('public')->put($path, base64_decode($image));
            $url = asset('public/storage/' . $path);
            
            return [
                'url' => $url
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public function preview($id)
    {
        $this->previewQuestion = Question::with('options', 'subject')->findOrFail($id);
        $this->dispatch('open-modal', 'preview-modal');
    }

    public function closePreview()
    {
        $this->previewQuestion = null;
    }

    public function resetOptions()
    {
        $this->options = [
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
        ];
        $this->optionImages = [null, null, null, null, null];
    }

    public function addOption()
    {
        $this->options[] = ['text' => '', 'is_correct' => false];
        $this->optionImages[] = null;
    }

    public function removeOption($index)
    {
        if (count($this->options) > 2) {
            unset($this->options[$index]);
            unset($this->optionImages[$index]);
            $this->options = array_values($this->options);
            $this->optionImages = array_values($this->optionImages);
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function toggleSelectAll()
    {
        $query = Question::where('question', 'like', '%' . $this->search . '%');

        if ($this->filterSubject) {
            $query->where('subject_id', $this->filterSubject);
        }
        if ($this->filterType) {
            $query->where('question_type', $this->filterType);
        }
        if ($this->filterDifficulty) {
            $query->where('difficulty_level', $this->filterDifficulty);
        }

        if (count($this->selected) === $query->limit($this->perPage)->count()) {
            $this->selected = [];
        } else {
            $this->selected = $query->limit($this->perPage)->pluck('id')->toArray();
        }
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'No questions selected.']);
            return;
        }

        Question::whereIn('id', $this->selected)->delete();
        $count = count($this->selected);
        $this->selected = [];
        $this->dispatch('toast', ['type' => 'success', 'message' => $count . ' questions deleted successfully.']);
    }

    public function create()
    {
        $this->reset(['subject_id', 'question', 'question_type', 'difficulty_level', 'status', 'audio_file', 'question_image', 'timer', 'questionId', 'currentAudioFile', 'currentQuestionImage']);
        $this->status = true;
        $this->question_type = 1;
        $this->difficulty_level = 1;
        $this->resetOptions();
        $this->isEdit = false;
        $this->dispatch('open-modal', 'question-modal');
        $this->dispatch('reset-question');
    }

    public function edit($id)
    {
        $question = Question::with('options')->findOrFail($id);
        $this->questionId = $id;
        $this->subject_id = $question->subject_id;
        $this->question = $question->question;
        $this->question_type = $question->question_type->value;
        $this->difficulty_level = $question->difficulty_level->value;
        $this->status = $question->status;
        $this->timer = $question->timer;
        $this->currentAudioFile = $question->audio_file;
        $this->currentQuestionImage = $question->image;

        if ($this->question_type == 1 && $question->options->count() > 0) {
            $this->options = $question->options->map(fn($opt) => [
                'text' => $opt->option_text,
                'is_correct' => $opt->is_correct,
                'current_image' => $opt->image,
            ])->toArray();
            $this->optionImages = array_fill(0, count($this->options), null);
        } else {
            $this->resetOptions();
        }

        $this->isEdit = true;
        $this->dispatch('open-modal', 'question-modal');
        $this->dispatch('edit-question', question: $this->question, options: $this->options);
    }

    public function store()
    {
        $this->validate();

        $audioPath = $this->currentAudioFile;
        if ($this->audio_file) {
            $audioPath = $this->audio_file->store('questions/audio', 'public');
        }

        $imagePath = $this->currentQuestionImage;
        if ($this->question_image) {
            $imagePath = $this->question_image->store('questions/images', 'public');
        }

        $question = Question::updateOrCreate(
            ['id' => $this->questionId],
            [
                'subject_id' => $this->subject_id,
                'question' => $this->question,
                'image' => $imagePath,
                'question_type' => $this->question_type,
                'difficulty_level' => $this->difficulty_level,
                'status' => $this->status,
                'audio_file' => $audioPath,
                'timer' => $this->timer,
            ]
        );

        // Save options for multiple choice
        if ($this->question_type == 1) {
            $question->options()->delete();
            foreach ($this->options as $index => $option) {
                if (!empty($option['text'])) {
                    $optionImagePath = $option['current_image'] ?? null;
                    
                    // Check if new image uploaded for this option
                    if (isset($this->optionImages[$index]) && $this->optionImages[$index] !== null && is_object($this->optionImages[$index])) {
                        $optionImagePath = $this->optionImages[$index]->store('questions/options', 'public');
                    }

                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $option['text'],
                        'image' => $optionImagePath,
                        'is_correct' => $option['is_correct'] ?? false,
                        'order' => $index,
                    ]);
                }
            }
        }

        $this->dispatch('close-modal', 'question-modal');
        $this->reset(['subject_id', 'question', 'question_type', 'difficulty_level', 'status', 'audio_file', 'question_image', 'timer', 'questionId', 'currentAudioFile', 'currentQuestionImage']);
        $this->resetOptions();
        $this->dispatch('toast', ['type' => 'success', 'message' => $this->questionId ? 'Question updated successfully.' : 'Question created successfully.']);
    }

    public function delete($id)
    {
        Question::find($id)->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Question deleted successfully.']);
    }

    public function import()
    {
        $this->validate([
            'importExcelSubjectId' => 'required|exists:subjects,id',
            'importFile' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            Excel::import(new QuestionsImport($this->importExcelSubjectId), $this->importFile);
            $this->dispatch('close-modal', 'import-modal');
            $this->reset(['importFile', 'importExcelSubjectId']);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Questions imported successfully.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Import failed: ' . $e->getMessage()]);
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'status',
            'audio_file',
            'timer',
            'isi',
            'status jawaban',
            'tingkat kesulitan soal',
        ];

        $sampleData = [
            // Question 1 - Multiple Choice
            ['1', 'SOAL', 'Q', 'Apa ibu kota Indonesia?|60', '', '1'],
            ['1', 'JAWABAN', 'A', 'Jakarta', '1', ''],
            ['1', 'JAWABAN', 'A', 'Bandung', '0', ''],
            ['1', 'JAWABAN', 'A', 'Surabaya', '0', ''],
            ['1', 'JAWABAN', 'A', 'Medan', '0', ''],
            ['1', 'JAWABAN', 'A', 'Makassar', '0', ''],
            
            // Question 2 - Multiple Choice
            ['2', 'SOAL', 'Q', 'What is the capital of France?|45', '', '1'],
            ['2', 'JAWABAN', 'A', 'Paris', '1', ''],
            ['2', 'JAWABAN', 'A', 'London', '0', ''],
            ['2', 'JAWABAN', 'A', 'Berlin', '0', ''],
            ['2', 'JAWABAN', 'A', 'Madrid', '0', ''],
            ['2', 'JAWABAN', 'A', 'Rome', '0', ''],
            
            // Question 3 - Multiple Choice
            ['3', 'SOAL', 'Q', 'Berapa hasil dari 2 + 2?|30', '', '2'],
            ['3', 'JAWABAN', 'A', '4', '1', ''],
            ['3', 'JAWABAN', 'A', '3', '0', ''],
            ['3', 'JAWABAN', 'A', '5', '0', ''],
            ['3', 'JAWABAN', 'A', '6', '0', ''],
            ['3', 'JAWABAN', 'A', '7', '0', ''],
        ];

        $callback = function() use ($headers, $sampleData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            foreach ($sampleData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="questions_template.csv"',
        ]);
    }

    public function importFromWord()
    {
        $this->validate([
            'importSubjectId' => 'required|exists:subjects,id',
            'importHtmlContent' => 'required|string',
        ]);

        try {
            $dom = new \DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($this->importHtmlContent, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            
            $tables = $dom->getElementsByTagName('table');
            $importedCount = 0;
            $currentQuestion = null;

            foreach ($tables as $table) {
                $rows = $table->getElementsByTagName('tr');
                
                // Skip header row
                $isFirstRow = true;
                foreach ($rows as $row) {
                    if ($isFirstRow) {
                        $isFirstRow = false;
                        continue;
                    }

                    $cells = $row->getElementsByTagName('td');
                    if ($cells->length < 4) continue;

                    // Extract data from columns: No, Jenis, Isi, Jawaban
                    $no = trim(strip_tags($this->getInnerHTML($cells->item(0))));
                    $jenis = trim(strip_tags($this->getInnerHTML($cells->item(1))));
                    $isi = $this->getInnerHTML($cells->item(2));
                    $jawaban = trim(strip_tags($this->getInnerHTML($cells->item(3))));

                    if (strtoupper($jenis) === 'SOAL') {
                        // Create new question
                        $currentQuestion = Question::create([
                            'subject_id' => $this->importSubjectId,
                            'question' => $isi,
                            'question_type' => QuestionType::MULTIPLE_CHOICE,
                            'difficulty_level' => DifficultyLevel::MEDIUM,
                            'status' => true,
                        ]);
                        $importedCount++;
                    } elseif (strtoupper($jenis) === 'JAWABAN' && $currentQuestion) {
                        // Create option for current question
                        $isCorrect = ($jawaban === '1' || strtolower($jawaban) === 'true' || strtolower($jawaban) === 'benar');
                        
                        QuestionOption::create([
                            'question_id' => $currentQuestion->id,
                            'option_text' => $isi,
                            'is_correct' => $isCorrect,
                        ]);
                    }
                }
            }

            $this->dispatch('close-modal', 'import-word-modal');
            $this->reset(['importSubjectId', 'importHtmlContent']);
            session()->flash('message', "Successfully imported {$importedCount} question(s) from Word.");
            
        } catch (\Exception $e) {
            $this->addError('importHtmlContent', 'Failed to parse HTML content: ' . $e->getMessage());
        }
    }

    private function getInnerHTML(\DOMNode $node)
    {
        $innerHTML = '';
        $children = $node->childNodes;
        
        foreach ($children as $child) {
            $innerHTML .= $node->ownerDocument->saveHTML($child);
        }
        
        return trim($innerHTML);
    }

    public function render()
    {
        $query = Question::where('question', 'like', '%' . $this->search . '%');

        if ($this->filterSubject) {
            $query->where('subject_id', $this->filterSubject);
        }
        if ($this->filterType) {
            $query->where('question_type', $this->filterType);
        }
        if ($this->filterDifficulty) {
            $query->where('difficulty_level', $this->filterDifficulty);
        }

        return view('livewire.questions.index', [
            'questions' => $query->with('subject')->latest()->paginate($this->perPage),
            'subjects' => Subject::all(),
            'questionTypes' => QuestionType::cases(),
            'difficultyLevels' => DifficultyLevel::cases(),
        ]);
    }
}
