<?php

namespace App\Filament\Resources\Data;

use App\Filament\Resources\Data\PerusahaanResource\Pages;
use App\Filament\Resources\Data\PerusahaanResource\RelationManagers;
use App\Models\Data\Perusahaan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PerusahaanResource extends Resource
{
    protected static ?string $model = Perusahaan::class;

    protected static ?string $slug = 'data/perusahaan';

    protected static ?string $navigationIcon = null;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationLabel = 'Perusahaan';

    protected static ?string $pluralModelLabel = 'Perusahaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('npwp')
                    ->label('NPWP')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make('nama_perusahaan')
                    ->label('Nama Perusahaan')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make('nama_pimpinan')
                    ->label('Nama Pimpinan')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make('jabatan')
                    ->label('Jabatan')
                    ->columnSpanFull()
                    ->required(),
                // Forms\Components\TextInput::make('telepon_perusahaan')
                //     ->label('Telepon Perusahaan')
                //     ->columnSpanFull()
                //     ->required(),
                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat Perusahaan')
                    ->columnSpanFull()
                    ->required()
                    ->autosize(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_perusahaan')
                    ->label('Perusahaan')
                    ->searchable()
                    ->formatStateUsing(function ($state, $record){
                        return <<<HTML
                            <div>$state</div>
                            <div class='text-xs text-gray-500 mb-1'>NPWP: $record->npwp</div>
                        HTML;
                    })->html(),
                Tables\Columns\TextColumn::make('nama_pimpinan')
                    ->label('Pimpinan')
                    ->searchable()
                    ->formatStateUsing(function ($state, $record){
                        return <<<HTML
                            <div>$state</div>
                            <div class='text-xs text-gray-500'>Jabatan: $record->jabatan</div>
                        HTML;
                    })->html(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah pada')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->modalWidth('lg')
                        ->modalHeading('Edit Perusahaan')
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
            'index' => Pages\ManagePerusahaan::route('/'),
        ];
    }
}
