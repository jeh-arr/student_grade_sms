<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?int $navigationSort = 1;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('course_code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('course_name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Textarea::make('course_description')
                    ->columnSpan(2)
                    ->required()
                    ->maxLength(255), 
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
        
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Course Id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('course_code')
                    
                    ->searchable(),
                Tables\Columns\TextColumn::make('course_name')
                    ->searchable(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return  $infolist
            ->schema([
                Section::make('Course Information')
                ->schema([
                    TextEntry::make('id')->label('Course ID'),
                    TextEntry::make('course_code')->label('Course Code'),
                    TextEntry::make('course_name')->label('Course Name'),
                    
                ])->columns(3),
                Section::make('Course Description')
                ->schema([
                    TextEntry::make('course_description')->label('Course Description'),
                    
                ])->columns(1),
                
                
            ])->columns(1);
            
        
        
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            //'view' => Pages\ViewCourse::route('/{record}'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
    {
        
        return auth()->check() && auth()->user()->is_admin;
    }
    
}
