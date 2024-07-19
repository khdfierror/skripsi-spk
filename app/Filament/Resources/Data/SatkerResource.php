<?php

namespace App\Filament\Resources\Data;

use App\Filament\Resources\Data\SatkerResource\Pages;
use App\Filament\Resources\Data\SatkerResource\RelationManagers;
use App\Models\Data\Satker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SatkerResource extends Resource
{
    protected static ?string $model = Satker::class;

    protected static ?string $slug = 'data/satker';

    protected static ?string $navigationIcon = null;

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationLabel = 'Satker';

    protected static ?string $pluralModelLabel = 'Satker';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_satker')
                    ->label('Kode Satker')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make('nama_satker')
                    ->label('Nama Satker')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_satker')
                    ->label('Kode Satker')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_satker')
                    ->label('Satker')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah pada')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->modalWidth('sm')
                        ->modalHeading('Edit Satker')
                        ->modalSubmitActionLabel('Simpan')
                        ->modalCancelActionLabel("Batal"),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus'),
                ])
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
            'index' => Pages\ManageSatker::route('/'),
        ];
    }
}
