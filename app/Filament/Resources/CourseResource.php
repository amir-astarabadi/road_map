<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use Modules\RoadMap\Models\Course;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\RoadMap\Enums\CourseCategory;
use Modules\RoadMap\Enums\CourseLevel;
use Modules\RoadMap\Enums\CourseType;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('general information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)->columnSpanFull(),

                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('¢'),
                        Select::make('skills')
                            ->options(CourseCategory::class)
                            ->multiple(),
                        Textarea::make('description')
                            ->required()
                            ->columnSpan(2),
                        FileUpload::make('cover')
                            ->label('cover image')
                            ->image(),

                    ])->columns(3),
                Section::make('type')
                    ->schema([
                        Select::make('type')
                            ->reactive()
                            ->options(CourseType::class),
                        Section::make('Video Information')
                            ->hidden(fn (callable $get) => $get('type') != CourseType::Video->value)
                            ->schema([
                                TextInput::make('duration')
                                    ->numeric(),
                                TextInput::make('channel')
                                    ->maxLength(25),
                                TextInput::make('url')
                                    ->required()
                                    ->maxLength(255),
                            ])->columns(2),
                        Section::make('Book Information')
                            ->hidden(fn (callable $get) => $get('type') != CourseType::Book->value) 
                            ->schema([
                                TextInput::make('number_of_pages')
                                    ->label('number of pages')
                                    ->numeric(),
                                TextInput::make('instructors')
                                    ->label('authors')->columnSpan(2),
                            ])->columns(3),

                            Section::make('University Information')
                            ->hidden(fn (callable $get) => $get('type') != CourseType::University->value)
                            ->schema([
                                TextInput::make('institute')
                                    ->label('University')
                                    ->columnSpan(2),
                            ])->columns(3),
                        Section::make('Atricle Information')
                            ->hidden(fn (callable $get) => $get('type') != CourseType::Article->value)
                            ->schema([
                                TextInput::make('url')
                                    ->label('url')
                                    ->numeric(),
                            ])->columns(1)
                    ]),

                Section::make('Level')
                    ->schema([
                        Select::make('level')
                            ->label('course level')
                            ->options(CourseLevel::class),
                        Select::make('level_up_from')
                            ->label('level up from')
                            ->options(CourseLevel::class),
                        Select::make('level_up_to')
                            ->label('level up to')
                            ->options(CourseLevel::class),
                    ])->columns(3),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(15),
                Tables\Columns\TextColumn::make('price_in_dolar')
                    ->label('Price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('level')
                    ->sortable(),
                Tables\Columns\TextColumn::make('level_up'),
                Tables\Columns\TextColumn::make('url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('channel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_pages')
                    ->hidden()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->hidden()
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'view' => Pages\ViewCourse::route('/{record}'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
