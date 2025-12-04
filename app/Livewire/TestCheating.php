<?php

namespace App\Livewire;

use App\Models\Test;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class TestCheating extends Component
{
    public Test $test;

    public function mount(Test $test)
    {
        $this->test = $test;
    }

    public function render()
    {
        return view('livewire.test-cheating');
    }
}
