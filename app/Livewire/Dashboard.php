<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\Question;
use App\Models\Subject;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        // Get statistics
        $totalStudents = User::where('role', 'student')->count();
        $totalTests = Test::count();
        $activeTests = Test::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->count();
        
        // Calculate completion rate
        $totalAttempts = TestAttempt::count();
        $completedAttempts = TestAttempt::where('status', 'submitted')->count();
        $completionRate = $totalAttempts > 0 ? round(($completedAttempts / $totalAttempts) * 100, 1) : 0;
        
        // Calculate average score
        $avgScore = TestAttempt::where('status', 'submitted')
            ->whereNotNull('score')
            ->avg('score');
        $avgScore = $avgScore ? round($avgScore, 1) : 0;
        
        // Get recent activities (last 10 test attempts)
        $recentActivities = TestAttempt::with(['user', 'test'])
            ->where('status', 'submitted')
            ->latest('submitted_at')
            ->take(10)
            ->get();
        
        // Additional stats
        $totalQuestions = Question::count();
        $totalSubjects = Subject::count();
        
        return view('livewire.dashboard', [
            'totalStudents' => $totalStudents,
            'totalTests' => $totalTests,
            'activeTests' => $activeTests,
            'completionRate' => $completionRate,
            'avgScore' => $avgScore,
            'recentActivities' => $recentActivities,
            'totalQuestions' => $totalQuestions,
            'totalSubjects' => $totalSubjects,
        ]);
    }
}
