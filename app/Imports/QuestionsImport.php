<?php

namespace App\Imports;

use App\Enums\DifficultyLevel;
use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class QuestionsImport implements ToCollection, WithHeadingRow
{
    private $currentQuestion = null;
    private $optionOrder = 0;
    private $subjectId;

    public function __construct($subjectId)
    {
        $this->subjectId = $subjectId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $kode = strtoupper(trim($row['kode'] ?? ''));

            if ($kode === 'Q') {
                // Process Question
                $this->processQuestion($row);
            } elseif ($kode === 'A') {
                // Process Answer (Option)
                $this->processAnswer($row);
            }
        }
    }

    private function processQuestion($row)
    {
        // Extract data from row
        $isi = $row['isi'] ?? '';
        $tingkatKesulitan = $row['tingkat_kesulitan_soal'] ?? 1;
        
        // Parse question data from 'isi' column
        // Format expected: question|timer (type is always 1 for Excel import)
        $parts = explode('|', $isi);
        
        if (count($parts) < 1) {
            return; // Skip if invalid format
        }

        $questionText = trim($parts[0]);
        $timer = isset($parts[1]) ? (int)trim($parts[1]) : null;

        // Create question using subject from dropdown, type is always Multiple Choice (1)
        $this->currentQuestion = Question::create([
            'subject_id' => $this->subjectId,
            'question' => $questionText,
            'question_type' => 1, // Always Multiple Choice for Excel import
            'difficulty_level' => $tingkatKesulitan,
            'status' => true,
            'timer' => $timer,
        ]);

        // Reset option order for new question
        $this->optionOrder = 0;
    }

    private function processAnswer($row)
    {
        if (!$this->currentQuestion) {
            return; // Skip if no current question
        }

        $isi = $row['isi'] ?? '';
        $statusJawaban = trim($row['status_jawaban'] ?? '');
        $isCorrect = $statusJawaban === '1';

        if (empty($isi)) {
            return; // Skip empty answers
        }

        // Create question option
        QuestionOption::create([
            'question_id' => $this->currentQuestion->id,
            'option_text' => $isi,
            'is_correct' => $isCorrect,
            'order' => $this->optionOrder++,
        ]);
    }
}
