<?php

namespace App\Filament\Resources;

use App\Enums\TaskStateEnum;
use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required()
                    ->label(__('Project')),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label(__('Name')),
                Forms\Components\Textarea::make('description')
                    ->label(__('Description')),
                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->label(__('Start date')),
                Forms\Components\DatePicker::make('end_date')
                    ->label(__('End date')),
                Select::make('state')
                    ->options([
                        TaskStateEnum::DRAFT->value => TaskStateEnum::DRAFT->label(),
                        TaskStateEnum::BACKLOG->value => TaskStateEnum::BACKLOG->label(),
                        TaskStateEnum::IN_PROGRESS->value => TaskStateEnum::IN_PROGRESS->label(),
                    ])
                    ->label(__('Status'))
                    ->default(TaskStateEnum::DRAFT->value)
                    ->required(),
                Forms\Components\Select::make('assigned_user_id')
                    ->relationship('assignedUser', 'name')
                    ->searchable()
                    ->label(__('Assigned user')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name')->label(__('Project'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('state')->label(__('State'))->sortable(),
                Tables\Columns\TextColumn::make('start_date')->label(__('Start date'))->sortable(),
                Tables\Columns\TextColumn::make('end_date')->label(__('End date'))->sortable(),
                Tables\Columns\TextColumn::make('assignedUser.name')->label(__('Assigned user'))->searchable()->sortable(),
            ])
            ->filters([
                // Filtry np. statusu
                Tables\Filters\SelectFilter::make('state')
                    ->options([
                        TaskStateEnum::DRAFT->value => TaskStateEnum::DRAFT->label(),
                        TaskStateEnum::BACKLOG->value => TaskStateEnum::BACKLOG->label(),
                        TaskStateEnum::IN_PROGRESS->value => TaskStateEnum::IN_PROGRESS->label(),
                        TaskStateEnum::REVIEW->value => TaskStateEnum::REVIEW->label(),
                        TaskStateEnum::FINISHED->value => TaskStateEnum::FINISHED->label(),
                        TaskStateEnum::CANCELED->value => TaskStateEnum::CANCELED->label(),
                    ]),
            ])
            ->actions([
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
            'view' => Pages\ViewTask::route('/{record}'),
        ];
    }
}
