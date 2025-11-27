<?php

namespace App\Imports;

use App\Enums\UserRole;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $group = null;
        if (!empty($row['group'])) {
            $group = Group::firstOrCreate(['name' => $row['group']]);
        }

        return new User([
            'name'        => $row['name'],
            'username'    => $row['username'],
            'email'       => $row['email'],
            'password'    => Hash::make($row['password'] ?? 'password'), // Default password if missing
            'role'        => UserRole::PESERTA,
            'description' => $row['description'] ?? null,
            'group_id'    => $group ? $group->id : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name'     => 'required',
            'username' => 'required|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'group'    => 'nullable|string',
        ];
    }
}
