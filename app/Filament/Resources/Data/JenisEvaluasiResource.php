<?php

namespace App\Filament\Resources\Data;

use App\Filament\Resources\Data\JenisEvaluasiResource\Pages;
use App\Filament\Resources\Data\JenisEvaluasiResource\RelationManagers;
use App\Models\Data\JenisEvaluasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JenisEvaluasiResource extends Resource
{
    protected static ?string $model = JenisEvaluasi::class;

    protected static ?string $slug = 'data/jenis-evaluasi';

    protected static ?string $navigationIcon = null;

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationGroup = 'Kriteria & Sub Kriteria';

    protected static ?string $navigationLabel = 'Jenis Evaluasi';

    protected static ?string $pluralModelLabel = 'Jenis Evaluasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('no')
                    ->label('No Urut')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make('nama_jenis')
                    ->label('Nama Jenis')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No Urut')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_jenis')
                    ->label('Nama Jenis'),
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
                        ->modalHeading('Edit Jenis Evaluasi')
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
            'index' => Pages\ManageJenisEvaluasi::route('/'),
        ];
    }
}
