<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function handleRecordCreation(array $data): Student
    {
        // Create User 
        $userData = $data['user'];
        $userData['is_admin'] = false;
        $userData['password'] = Hash::make($userData['password']);
        $userData['name'] = $data['first_name'] . ' ' . $data['last_name'];
        $user = User::create($userData);

        // Create Student
        $studentData = array_merge($data, ['user_id' => $user->id]);
        unset($studentData['user']);
        return Student::create($studentData);
    }
}
