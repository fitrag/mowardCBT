<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Test;
use App\Models\TestAttempt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TestResultsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    protected $tests;
    protected $testHeaders;

    public function __construct()
    {
        // Get all tests
        $this->tests = Test::orderBy('name')->get();
        $this->testHeaders = $this->tests->pluck('name')->toArray();
    }

    public function collection()
    {
        // Get all students with their group and attempts
        // Use 'peserta' role instead of 'student'
        return User::where('role', 'peserta')
            ->with(['group', 'attempts' => function($query) {
                $query->whereIn('status', ['graded', 'submitted'])
                    ->with('test');
            }])
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        // First row: Main headers with "Daftar Nama Test" colspan
        $firstRow = ['No', 'Nama', 'Grup', 'Rata-rata'];
        
        if (count($this->testHeaders) > 0) {
            $firstRow[] = 'Daftar Nama Test';
            // Add empty cells for colspan
            for ($i = 1; $i < count($this->testHeaders); $i++) {
                $firstRow[] = '';
            }
        }
        
        // Second row: Individual test names
        $secondRow = ['', '', '', ''];
        foreach ($this->testHeaders as $testName) {
            $secondRow[] = $testName;
        }
        
        return [$firstRow, $secondRow];
    }

    public function map($student): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $row = [
            $rowNumber,
            $student->name,
            $student->group?->name ?? '-',
        ];

        // Calculate average and collect test scores
        $scores = [];
        $totalScore = 0;
        $completedTests = 0;

        foreach ($this->tests as $test) {
            // Find attempt for this specific test
            $attempt = $student->attempts->first(function($attempt) use ($test) {
                return $attempt->test_id == $test->id;
            });

            if ($attempt && $attempt->score !== null) {
                $scores[] = number_format($attempt->score, 2);
                $totalScore += $attempt->score;
                $completedTests++;
            } else {
                $scores[] = '-';
            }
        }

        // Calculate average
        $average = $completedTests > 0 ? $totalScore / $completedTests : 0;
        $row[] = $completedTests > 0 ? number_format($average, 2) : '-';

        // Add test scores
        foreach ($scores as $score) {
            $row[] = $score;
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        $testCount = count($this->testHeaders);
        
        return [
            // Style the first header row
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ],
            // Style the second header row
            2 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '6366F1']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $testCount = count($this->testHeaders);
                
                if ($testCount > 0) {
                    // Merge cells for "Daftar Nama Test" header (colspan)
                    $startColumn = 'E'; // Column E (after No, Nama, Grup, Rata-rata)
                    $endColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(4 + $testCount);
                    $event->sheet->mergeCells($startColumn . '1:' . $endColumn . '1');
                    
                    // Center align the merged cell
                    $event->sheet->getStyle($startColumn . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                
                // Merge cells for No, Nama, Grup, Rata-rata (rowspan)
                $event->sheet->mergeCells('A1:A2'); // No
                $event->sheet->mergeCells('B1:B2'); // Nama
                $event->sheet->mergeCells('C1:C2'); // Grup
                $event->sheet->mergeCells('D1:D2'); // Rata-rata
                
                // Center align the merged cells vertically
                $event->sheet->getStyle('A1:D2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getStyle('A1:D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                
                // Set row height for headers
                $event->sheet->getRowDimension(1)->setRowHeight(25);
                $event->sheet->getRowDimension(2)->setRowHeight(25);
                
                // Add borders to all data cells
                $lastRow = $event->sheet->getHighestRow();
                $lastColumn = $event->sheet->getHighestColumn();
                $event->sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000']
                        ]
                    ]
                ]);
            },
        ];
    }
}

