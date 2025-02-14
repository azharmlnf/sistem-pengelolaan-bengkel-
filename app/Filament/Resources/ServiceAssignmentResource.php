<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceAssignmentResource\Pages;
use App\Filament\Resources\ServiceAssignmentResource\RelationManagers;
use App\Models\ServiceAssignment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;

class ServiceAssignmentResource extends Resource
{
    protected static ?string $model = ServiceAssignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('service_id')
                ->options(function () {
                    return \App\Models\Service::with('car')
                        ->get()
                        ->mapWithKeys(fn($service) => [
                            $service->id => $service->car->license_plate . ' - ' . $service->entry_date
                        ]);
                })
                ->searchable()
                ->required(),

                Forms\Components\Select::make('mechanic_id')
                ->relationship('mechanic', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->reactive()
                ->rules([
                    function (callable $get) {
                        return Rule::prohibitedIf(function () use ($get) {
                            return \App\Models\ServiceAssignment::where('service_id', $get('service_id'))
                                ->where('mechanic_id', $get('mechanic_id'))
                                ->exists();
                        });
                    }
                ])
                ->validationMessages([
                    'prohibited' => 'This mechanic is already assigned to the selected service.',
                ]),
            
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('service_id')
                    ->label('ID | license plate | Date')
                    ->collapsible(), // Tambahkan fitur collapsible
            ])
            ->columns([
                Tables\Columns\TextColumn::make('service_id')
                    ->label('Service Info')
                    ->formatStateUsing(
                        fn($record) =>
                        "{$record->service_id} - " .
                            $record->service->car->license_plate .
                            " - " . $record->service->entry_date
                    )
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('mechanic_id')
                    ->label('Mechanic Name')
                    ->formatStateUsing(fn($record) => $record->mechanic->name)
                    ->sortable()
                    ->searchable(),
                    
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
            'index' => Pages\ListServiceAssignments::route('/'),
            'create' => Pages\CreateServiceAssignment::route('/create'),
            'view' => Pages\ViewServiceAssignment::route('/{record}'),
            'edit' => Pages\EditServiceAssignment::route('/{record}/edit'),
        ];
    }
}
