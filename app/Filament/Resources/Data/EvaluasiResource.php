<?php

namespace App\Filament\Resources\Data;

use App\Filament\Resources\Data\EvaluasiResource\Pages;
use App\Filament\Resources\Data\EvaluasiResource\RelationManagers;
use App\Models\Data\Evaluasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EvaluasiResource extends Resource
{
    protected static ?string $model = Evaluasi::class;

    protected static ?string $slug = 'data/evaluasi';

    protected static ?string $navigationIcon = null;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Kriteria & Sub Kriteria';

    protected static ?string $navigationLabel = 'Evaluasi';

    protected static ?string $pluralModelLabel = 'Evaluasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('jenis_evaluasi_id')
                    ->label('Jenis Evaluasi')
                    ->columnSpanFull()
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->relationship(
                        name: 'jenis_evaluasi',
                            titleAttribute: 'nama_jenis',
                            modifyQueryUsing: fn (Builder $query) => $query->orderBy('no')
                    )
                    ->required(),
                Forms\Components\TextInput::make('no')
                    ->label('No Urut')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\Textarea::make('uraian')
                    ->label('Uraian')
                    ->columnSpanFull()
                    ->required()
                    ->autosize(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No Urut')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_evaluasi.nama_jenis')
                    ->label('Jenis Evaluasi'),
                Tables\Columns\TextColumn::make('uraian')
                    ->label('Uraian'),
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
                        ->modalHeading('Edit Evaluasi')
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
            'index' => Pages\ManageEvaluasi::route('/'),
        ];
    }
}
