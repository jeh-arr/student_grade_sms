<?php

namespace App\Filament\Pages;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Grade;
use Filament\Pages\Page;

use Filament\Tables;

use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Tables\Concerns\InteractsWithTable;
class StudentGrade extends Page implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static string $view = 'filament.pages.student-grade';
    protected static ?int $navigationSort = 2;
    public function table(Table $table):Table { 
        $grades = Grade::where('student_id', auth()->user()->student->id)->get();
        //dd($grades);
        return $table
            //->records($grades)
            ->query(Grade::where('student_id', auth()->user()->student->id))
            ->columns([
                Tables\Columns\TextColumn ::make('subject.subject_name')
                    ->label('Subject')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('final_grade')
                    ->numeric(),
                    
            ]);
    }
    
    //     public static function canViewAny(): bool
    // {
    //     dd('check');
    //     return auth()->check() && !auth()->user()->is_admin;
    // }
    public static function shouldRegisterNavigation(): bool
    {
        
        return auth()->check() && !auth()->user()->is_admin;
    }
    
}
