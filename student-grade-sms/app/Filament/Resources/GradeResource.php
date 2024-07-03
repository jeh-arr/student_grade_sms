<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GradeResource\Pages;
use App\Filament\Resources\GradeResource\RelationManagers;
use App\Models\Grade;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?int $navigationSort = 4;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'student_id')
                    ->label('Student')
                    
                    ->required(),
                    
                Forms\Components\Select::make('subject_id')
                    ->relationship('subject', 'subject_name')
                    
                    ->required(),
                
                Forms\Components\TextInput::make('final_grade')
                    ->required()
                    ->numeric(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            
            ->columns([
                Tables\Columns\TextColumn::make('student.student_id')
                    ->label('Student Id')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('subject.subject_name')
                    ->label('Subject')
                    ->searchable()
                    ->sortable(),
                
                
                Tables\Columns\TextColumn::make('final_grade')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGrades::route('/'),
            'create' => Pages\CreateGrade::route('/create'),
            'view' => Pages\ViewGrade::route('/{record}'),
            'edit' => Pages\EditGrade::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }
}
