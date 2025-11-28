<?php

namespace App\Livewire\Tests;

use App\Models\Group;
use App\Models\Subject;
use App\Models\Test;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Edit extends Component
{
    public Test $test;

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('nullable|string')]
    public $description = '';

    #[Rule('required|date')]
    public $start_date = '';

    #[Rule('required|date|after:start_date')]
    public $end_date = '';

    #[Rule('required|integer|min:1')]
    public $duration = 60;

    #[Rule('boolean')]
    public $show_results = true;

    #[Rule('boolean')]
    public $show_result_details = true;

    #[Rule('required|numeric|min:0')]
    public $correct_score = 1.00;

    #[Rule('required|numeric')]
    public $wrong_score = 0.00;

    #[Rule('required|numeric')]
    public $unanswered_score = 0.00;

    #[Rule('nullable|numeric|min:0')]
    public $max_score = null;

    public $subject_configs = [];
    public $selected_groups = [];

    public function mount(Test $test)
    {
        // Load relationships if not already loaded
        $test->load(['subjects', 'groups']);
        
        $this->test = $test;
        $this->name = $test->name;
        $this->description = $test->description;
        $this->start_date = $test->start_date->format('Y-m-d\TH:i');
        $this->end_date = $test->end_date->format('Y-m-d\TH:i');
        $this->duration = $test->duration;
        $this->show_results = $test->show_results;
        $this->show_result_details = $test->show_result_details;
        $this->correct_score = $test->correct_score;
        $this->wrong_score = $test->wrong_score;
        $this->unanswered_score = $test->unanswered_score;
        $this->max_score = $test->max_score;
        $this->selected_groups = $test->groups->pluck('id')->toArray();
        
        // Load subject configurations from pivot data
        $this->subject_configs = $test->subjects->map(function ($subject) {
            return [
                'module_id' => $subject->module_id,
                'subject_id' => $subject->id,
                'question_type' => $subject->pivot->question_type,
                'difficulty_level' => $subject->pivot->difficulty_level,
                'question_count' => $subject->pivot->question_count,
                'options_count' => $subject->pivot->options_count,
                'randomize_questions' => (bool) $subject->pivot->randomize_questions,
                'randomize_answers' => (bool) $subject->pivot->randomize_answers,
            ];
        })->toArray();
    }

    public function addSubject()
    {
        $this->subject_configs[] = [
            'module_id' => '',
            'subject_id' => '',
            'question_type' => null,
            'difficulty_level' => null,
            'question_count' => 10,
            'options_count' => null,
            'randomize_questions' => false,
            'randomize_answers' => false,
        ];
    }

    public function removeSubject($index)
    {
        unset($this->subject_configs[$index]);
        $this->subject_configs = array_values($this->subject_configs);
    }

    public function getSubjectsForModule($moduleId)
    {
        if (!$moduleId) {
            return [];
        }
        return Subject::where('module_id', $moduleId)->get();
    }

    public function getQuestionCount($subjectId, $questionType = null, $difficultyLevel = null)
    {
        if (!$subjectId) {
            return 0;
        }

        $query = \App\Models\Question::where('subject_id', $subjectId)
            ->where('status', 1); // Only active questions

        if ($questionType) {
            $query->where('question_type', $questionType);
        }

        if ($difficultyLevel) {
            $query->where('difficulty_level', $difficultyLevel);
        }

        return $query->count();
    }

    public function getTotalQuestions()
    {
        $total = 0;
        foreach ($this->subject_configs as $config) {
            if (!empty($config['subject_id']) && !empty($config['question_count'])) {
                $total += (int) $config['question_count'];
            }
        }
        return $total;
    }

    public function getCalculatedCorrectScore()
    {
        $totalQuestions = $this->getTotalQuestions();
        if ($totalQuestions === 0) {
            return 0;
        }
        return round(100 / $totalQuestions, 2);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'duration' => 'required|integer|min:1',
            'show_results' => 'boolean',
            'show_result_details' => 'boolean',
            'correct_score' => 'required|numeric|min:0',
            'wrong_score' => 'required|numeric',
            'unanswered_score' => 'required|numeric',
            'max_score' => 'nullable|numeric|min:0',
            'selected_groups' => 'required|array|min:1',
            'subject_configs' => 'required|array|min:1',
            'subject_configs.*.subject_id' => 'required|exists:subjects,id',
            'subject_configs.*.question_type' => 'nullable|in:1,2,3',
            'subject_configs.*.difficulty_level' => 'nullable|in:1,2,3',
            'subject_configs.*.question_count' => 'required|integer|min:1',
            'subject_configs.*.options_count' => 'nullable|integer|min:2|max:10',
            'subject_configs.*.randomize_questions' => 'boolean',
            'subject_configs.*.randomize_answers' => 'boolean',
        ]);

        $updateData = [
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'duration' => $this->duration,
            'show_results' => $this->show_results,
            'show_result_details' => $this->show_result_details,
            'correct_score' => $this->getCalculatedCorrectScore(),
            'wrong_score' => $this->wrong_score,
            'unanswered_score' => $this->unanswered_score,
            'max_score' => 100, // Always 100
        ];

        $this->test->update($updateData);

        // Sync groups
        $this->test->groups()->sync($this->selected_groups);

        // Sync subjects with configurations
        $syncData = [];
        foreach ($this->subject_configs as $config) {
            $syncData[$config['subject_id']] = [
                'question_type' => $config['question_type'],
                'difficulty_level' => $config['difficulty_level'],
                'question_count' => $config['question_count'],
                'options_count' => $config['options_count'],
                'randomize_questions' => $config['randomize_questions'],
                'randomize_answers' => $config['randomize_answers'],
            ];
        }
        $this->test->subjects()->sync($syncData);

        session()->flash('message', 'Test updated successfully.');
        return $this->redirect(route('tests.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.tests.edit', [
            'groups' => Group::all(),
            'modules' => \App\Models\Module::all(),
        ]);
    }
}
