<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use App\Models\Student;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Contracts\HasInfolists;

class StudentInformation extends Page implements HasInfolists
{
    
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $view = 'filament.pages.student-information';
    protected static ?int $navigationSort = 1;
    public static function infolist(Infolist $infolist): Infolist
    {
        return  $infolist
            ->record(auth()->user()->student)
            ->schema([
                Section::make('Student Information')
                ->schema([
                    TextEntry::make('student_id')->label('Student ID'),
                    TextEntry::make('course.course_name')->label('Course'),
                    TextEntry::make('year_level')->label('Year Level'),
                    
                ])->columns(3),
                Section::make('Personal Information')
                ->schema([ 
                    TextEntry::make('first_name')->label('First Name'),
                    TextEntry::make('middle_name')->label('Middle Name'),
                    TextEntry::make('last_name')->label('Last Name'),
                    TextEntry::make('date_of_birth')->label('Date of Birth')->date('F j, Y'),
                    TextEntry::make('gender')->label('Gender'),
                ])->columns(3),
                
                Section::make('Contact Information')
                ->schema([
                    TextEntry::make('contact_number')->label('Contact Number'),
                    TextEntry::make('address')->label('Address'),
                ])->columns(2),
                Section::make('Account Information')
                ->schema([
                    TextEntry::make('user.name')->label('Account Name'),
                    TextEntry::make('user.email')->label('Account Email'),
                    
                ])->columns(2),
            ])->columns(1);
            
        
        
    }
    public static function shouldRegisterNavigation(): bool
    {
        
        return auth()->check() && !auth()->user()->is_admin;
    }
    

}
