<?php

namespace App\Filament\Resources\Data;

use App\Filament\Resources\Data\PpkResource\Pages;
use App\Filament\Resources\Data\PpkResource\RelationManagers;
use App\Models\Data\Ppk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PpkResource extends Resource
{
    protected static ?string $model = Ppk::class;

    protected static ?string $slug = 'data/ppk';

    protected static ?string $navigationIcon = null;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationLabel = 'PPK';

    protected static ?string $pluralModelLabel = 'PPK';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nip')
                    ->label('NIP')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('nama_ppk')
                    ->label('Nama PPK')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('satker_id')
                    ->label('Satker')
                    ->relationship('satker', 'nama_satker')
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->nama_satker} - {$record->kode_satker}")
                    ->preload()
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_ppk')
                    ->label('PPK')
                    ->searchable()
                    ->formatStateUsing(function ($state, $record){
                        return <<<HTML
                            <div>$state</div>
                            <div class='text-xs text-gray-500'>NIP: $record->nip</div>
                        HTML;
                    })->html(),
                Tables\Columns\TextColumn::make('satker.nama_satker')
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
                        ->modalWidth('lg')
                        ->modalHeading('Edit PPK')
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
            'index' => Pages\ManagePpk::route('/'),
        ];
    }
}
