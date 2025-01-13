<?php

namespace App\Filament\Resources;

use App\Enums\ProjectStateEnum;
use App\Enums\TaskStateEnum;
use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label(__('Name')),
                Forms\Components\Textarea::make('description')
                    ->label(__('Description')),
                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->label(__('Start date')),
                Select::make('state')
                    ->options([
                        ProjectStateEnum::DRAFT->value => ProjectStateEnum::DRAFT->label(),
                        ProjectStateEnum::IN_PROGRESS->value => ProjectStateEnum::IN_PROGRESS->label(),
                        ProjectStateEnum::FINISHED->value => ProjectStateEnum::FINISHED->label(),
                        ProjectStateEnum::CANCELED->value => ProjectStateEnum::CANCELED->label(),
                    ])
                    ->label(__('Status'))
                    ->default(TaskStateEnum::DRAFT->value)
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label(__('End date')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('start_date')->label(__('Start date'))->sortable(),
                Tables\Columns\TextColumn::make('end_date')->label(__('End date'))->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('Created at'))->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Action::make('kanban')
                    ->url(fn (Project $project): string => route('filament.admin.resources.projects.kanban', $project)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
            'kanban' => Pages\KanbanBoard::route('/{project}/kanban'),
        ];
    }
}
