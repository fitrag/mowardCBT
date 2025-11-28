<?php

namespace App\Livewire\Tokens;

use App\Models\Test;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    public $perPage = 10;
    public $selected = [];

    public $testId;
    public $use_token = false;
    
    #[Rule('nullable|string|max:255')]
    public $token = '';
    
    #[Rule('required|integer|in:1,5,10,15,30,60,1440')]
    public $token_duration = 15;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function toggleSelectAll()
    {
        if (count($this->selected) === Test::where('name', 'like', '%' . $this->search . '%')
                ->limit($this->perPage)
                ->count()) {
            $this->selected = [];
        } else {
            $this->selected = Test::where('name', 'like', '%' . $this->search . '%')
                ->limit($this->perPage)
                ->pluck('id')
                ->toArray();
        }
    }

    public function clearSelectedTokens()
    {
        if (empty($this->selected)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'No tests selected.']);
            return;
        }

        Test::whereIn('id', $this->selected)->update([
            'use_token' => false,
            'token' => null,
            'token_expires_at' => null,
        ]);

        $count = count($this->selected);
        $this->selected = [];
        $this->dispatch('toast', ['type' => 'success', 'message' => $count . ' token(s) cleared successfully.']);
    }

    public function openTokenModal($id)
    {
        $test = Test::findOrFail($id);
        $this->testId = $id;
        $this->use_token = $test->use_token;
        $this->token = $test->token ?? '';
        $this->token_duration = 15; // Default
        $this->dispatch('open-modal', 'token-modal');
    }

    public function generateRandomToken()
    {
        $this->token = strtoupper(\Illuminate\Support\Str::random(6));
    }

    public function saveToken()
    {
        $this->validate();

        $test = Test::findOrFail($this->testId);
        
        $updateData = [
            'use_token' => $this->use_token,
            'token' => $this->use_token ? $this->token : null,
        ];

        if ($this->use_token && $this->token_duration) {
            $updateData['token_expires_at'] = now()->addMinutes((int) $this->token_duration);
        } else {
            $updateData['token_expires_at'] = null;
        }

        $test->update($updateData);

        $this->dispatch('close-modal', 'token-modal');
        $this->reset(['testId', 'use_token', 'token', 'token_duration']);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Token updated successfully.']);
    }

    public function clearToken($id)
    {
        Test::findOrFail($id)->update([
            'use_token' => false,
            'token' => null,
            'token_expires_at' => null,
        ]);

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Token cleared successfully.']);
    }

    public function regenerateToken($id)
    {
        $test = Test::findOrFail($id);
        
        $newToken = strtoupper(\Illuminate\Support\Str::random(6));
        
        $test->update([
            'use_token' => true,
            'token' => $newToken,
            'token_expires_at' => now()->addMinutes(15), // Default 15 minutes
        ]);

        $this->dispatch('toast', ['type' => 'success', 'message' => 'New token generated: ' . $newToken]);
    }

    public function render()
    {
        return view('livewire.tokens.index', [
            'tests' => Test::where('name', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate($this->perPage),
        ]);
    }
}
