<?php

namespace App\Livewire\Students;

use App\Models\User;
use App\Models\Group;
use App\Models\Setting;
use App\Enums\UserRole;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule as ValidationRule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination, WithFileUploads;

        #[Url(history: true)]
    public $search = '';

    public $perPage;
    public $importFile;
    public $selected = [];
    public $filterGroup = '';

    public $name = '';
    public $username = '';
    public $email = '';
    public $password = '';
    public $description = '';
    public $group_id = '';

        public $userId;
    public $isEdit = false;

    public function mount()
    {
        $this->perPage = Setting::get('items_per_page', 10);
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'username' => ['required', 'min:3', ValidationRule::unique('users', 'username')->ignore($this->userId)],
            'email' => ['required', 'email', ValidationRule::unique('users', 'email')->ignore($this->userId)],
            'password' => $this->isEdit ? 'nullable|min:6' : 'required|min:6',
            'group_id' => 'required|exists:groups,id',
            'description' => 'nullable',
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function toggleSelectAll()
    {
        if (count($this->selected) === User::where('role', UserRole::PESERTA)
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->limit($this->perPage)
                ->count()) {
            $this->selected = [];
        } else {
            $this->selected = User::where('role', UserRole::PESERTA)
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->limit($this->perPage)
                ->pluck('id')
                ->toArray();
        }
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function create()
    {
        $this->reset(['name', 'username', 'email', 'password', 'description', 'group_id', 'userId']);
        $this->isEdit = false;
        $this->dispatch('open-modal', 'student-modal');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->description = $user->description;
        $this->group_id = $user->group_id;
        $this->password = ''; // Don't fill password on edit
        $this->isEdit = true;
        $this->dispatch('open-modal', 'student-modal');
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'description' => $this->description,
            'group_id' => $this->group_id,
            'role' => UserRole::PESERTA,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        User::updateOrCreate(
            ['id' => $this->userId],
            $data
        );

        $this->dispatch('close-modal', 'student-modal');
        $this->reset(['name', 'username', 'email', 'password', 'description', 'group_id', 'userId']);
        $this->dispatch('toast', ['type' => 'success', 'message' => $this->userId ? 'Student updated successfully.' : 'Student created successfully.']);
    }

    public function delete($id)
    {
        User::find($id)->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Student deleted successfully.']);
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'No students selected.']);
            return;
        }

        User::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->dispatch('toast', ['type' => 'success', 'message' => count($this->selected) . ' students deleted successfully.']);
    }

    public function import()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new StudentsImport, $this->importFile);
            $this->dispatch('close-modal', 'import-modal');
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Students imported successfully.']);
            $this->reset('importFile');
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Error importing file: ' . $e->getMessage()]);
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="students_template.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['name', 'username', 'email', 'password', 'group', 'description']);
            fputcsv($file, ['John Doe', 'johndoe', 'john@example.com', 'password123', 'Class 10A', 'Optional description']);
            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function render()
    {
        $query = User::where('role', UserRole::PESERTA)
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });

        if ($this->filterGroup) {
            $query->where('group_id', $this->filterGroup);
        }

        return view('livewire.students.index', [
            'students' => $query->latest()->paginate($this->perPage),
            'groups' => Group::all(),
        ]);
    }
}
