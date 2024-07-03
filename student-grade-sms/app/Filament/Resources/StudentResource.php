<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Forms\Components\DatePicker;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        $is_admin = auth()->user()->is_admin;
        return $form
            
                
            ->schema([
                Forms\Components\Section::make('Student Information')
                ->hidden(!$is_admin)
                ->schema([
                Forms\Components\TextInput::make('student_id')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->disabled(!$is_admin),
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'course_name')
                    ->required(),
                Forms\Components\TextInput::make('year_level')
                    ->required()
                    ->maxLength(255),
                ])->columns(3), 
                Forms\Components\Section::make('Personal Information')
                ->schema([
                
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middle_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->required(),
                Forms\Components\Select::make('gender')
                    ->required()
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ]),
                ])->columns(3),    
                Forms\Components\Section::make('Contact Information')
                ->schema([
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255), 
                Forms\Components\TextInput::make('contact_number')
                    ->required()
                    ->maxLength(255),     
                ])->columns(2),    
                Forms\Components\Section::make('Account Information')
                ->schema([
                Forms\Components\TextInput::make('user.name')
                    ->label('User Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user.email')
                    ->label('User Email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user.password')
                    ->label('User Password')
                    ->password()
                    ->required()
                    ->revealable()
                    ->maxLength(255) 
                ])->columns(2),    
                
                
                //     //->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student_id')
                    ->searchable(),
                
                
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.course_name')
                    ->label('Course')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('User Email')
                    ->sortable(),
                
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            //'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    // public static function canViewAny(): bool
    // {
    //     return auth()->check() && auth()->user()->is_admin;
    // }
    public static function canViewAny(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }
}
