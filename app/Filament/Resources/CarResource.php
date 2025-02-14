<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Filament\Resources\CarResource\RelationManagers;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('license_plate')
                ->required()
                ->maxLength(10)
                ->live() // Memastikan perubahan langsung tervalidasi
                ->afterStateUpdated(function (Set $set, $state) {
                    // Cek apakah license_plate sudah ada di database
                    if (Car::where('license_plate', $state)->exists()) {
                        Notification::make()
                            ->title('License plate already taken')
                            ->danger()
                            ->send();
                            
                        $set('license_plate', null); // Reset input jika duplikat
                    }
                }),
            Forms\Components\TextInput::make('brand')
                ->required()
                ->maxLength(100),
            Forms\Components\Select::make('type')
                ->options([
                    'Truck' => 'Truck',
                    'Car' => 'Car',
                    'Bus' => 'Bus',
                    'Trailer' => 'Trailer',
                    'Pickup' => 'Pickup',
                    'Van' => 'Van',
                    'other' => 'Other'
                ])
                ->default('other')
                ->required(),
            Forms\Components\Select::make('customer_id')
                ->relationship('customer', 'name')
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\FileUpload::make('car_image')
                ->image(),
        ]);
}

// Tambahkan validasi saat menyimpan (CREATE)
public static function beforeCreate(Model $record): void
{
    if (Car::where('license_plate', $record->license_plate)->exists()) {
        Notification::make()
            ->title('License plate already taken')
            ->danger()
            ->send();
        
        throw new \Exception('License plate already taken');
    }
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('license_plate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                    Tables\Columns\ImageColumn::make('car_image')
                    ->disk('public')
                    ->getStateUsing(fn($record) => asset('storage/' . $record->car_image)),
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
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'view' => Pages\ViewCar::route('/{record}'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
