<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceRequirementResource\Pages;
use App\Filament\Resources\ServiceRequirementResource\RelationManagers;
use App\Models\ServiceRequirement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceRequirementResource extends Resource
{
    protected static ?string $model = ServiceRequirement::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('spare_part_id')
                    ->relationship('spare_part', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('service_id')
                    ->options(function () {
                        return \App\Models\Service::with('car') // Pastikan eager load car
                            ->get()
                            ->mapWithKeys(function ($service) {
                                return [
                                    $service->id => "{$service->id} - License Plate :  " .
                                        ($service->car->license_plate ?? 'Unknown') .
                                        " | Entry Date :  " . ($service->entry_date ?? 'No Date')
                                ];
                            });
                    })
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(function (callable $get) {
                        $sparePart = \App\Models\SparePart::find($get('spare_part_id'));
                        return $sparePart ? max(1, $sparePart->stock) : 1; // Pastikan max >= 1
                    })
                    ->validationMessages([
                        'max' => 'Not enough stock available.',
                    ]),


                Forms\Components\TextInput::make('total_price')
                    ->numeric()
                    ->disabled() // Tidak bisa diedit manual
                    ->dehydrated() // Akan tetap dikirim ke database
                    ->required()
                    ->default(fn(callable $get) => \App\Models\SparePart::find($get('spare_part_id'))?->price * $get('quantity') ?? 0),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('service_id')
                    ->label('Service Group (ID | License Plate | Entry Date)')
                    ->collapsible(), // Tambahkan fitur collapsible agar bisa ditutup/buka
            ])
            ->columns([
                Tables\Columns\TextColumn::make('service_id')
                    ->label('Service Info')
                    ->formatStateUsing(function ($record) {
                        return "{$record->service_id} - " .
                            ($record->service->car->license_plate ?? 'Unknown') .
                            " - " . ($record->service->entry_date ?? 'No Date');
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('spare_part.name')
                    ->label('Spare Part')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Price')
                    ->sortable()
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
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
            'index' => Pages\ListServiceRequirements::route('/'),
            'create' => Pages\CreateServiceRequirement::route('/create'),
            'view' => Pages\ViewServiceRequirement::route('/{record}'),
            'edit' => Pages\EditServiceRequirement::route('/{record}/edit'),
        ];
    }
}
