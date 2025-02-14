<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('car_id')
                ->label('Car')
                ->searchable()
                ->preload()
                ->getSearchResultsUsing(fn(string $search) => \App\Models\Car::where('license_plate', 'like', "%{$search}%")->pluck('license_plate', 'license_plate'))
                ->getOptionLabelUsing(fn($value): ?string => \App\Models\Car::where('license_plate', $value)->value('license_plate'))
                ->required(),
                Forms\Components\DatePicker::make('entry_date')
                    ->required(),
                Forms\Components\DatePicker::make('exit_date'),
                Forms\Components\Textarea::make('complaint')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('Rp'),
                    Forms\Components\Select::make('location')
                    ->options([
                        'on bengkel' => 'on bengkel',
                        'outside bengkel' => 'outside bengkel',
                    ])
                    ->default('on bengkel')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('car_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('entry_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('exit_date')
                    ->dateTime()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                
                Tables\Columns\TextColumn::make('location'),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'view' => Pages\ViewService::route('/{record}'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
