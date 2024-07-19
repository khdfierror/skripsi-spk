<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\MoneyInput;
use App\Filament\Resources\PesertaTenderResource\Pages;
use App\Filament\Resources\PesertaTenderResource\RelationManagers;
use App\Models\Data\Paket;
use App\Models\Data\Perusahaan;
use App\Models\PesertaTender;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PesertaTenderResource extends Resource
{
    protected static ?string $model = PesertaTender::class;

    protected static ?string $navigationIcon = null;

    protected static ?string $navigationLabel = 'Peserta Tender';

    protected static ?string $pluralModelLabel = 'Peserta Tender';

    protected static ?string $navigationGroup = 'Data';

    protected static ?int $navigationSort = 4;

    protected static ?string $slug = 'peserta-tender';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('perusahaan_id')
                    ->label('Perusahaan')
                    ->required()
                    ->relationship('perusahaan', 'nama_perusahaan')
                    // ->getOptionLabelFromRecordUsing(fn (Paket $record) => "{$record->nama_paket} - {$record->kode_paket}")
                    ->searchable()
                    ->preload()
                    ->native(false),
                Forms\Components\Select::make('paket_tender_id')
                    ->label('Paket')
                    // ->required()
                    ->relationship('paket_tender', 'nama_paket')
                    ->getOptionLabelFromRecordUsing(fn (Paket $record) => "{$record->nama_paket} - {$record->kode_paket}")
                    ->searchable()
                    ->preload()
                    ->native(false),
                MoneyInput::make('harga_penawaran')
                    ->label('Harga Penawaran')
                    ->required(),
                MoneyInput::make('harga_terkoreksi')
                    ->label('Harga Terkoreksi')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $hps = $get('paket_tender.hps');

                        if ($hps > 0) {
                            $persentase = round(($state / $hps) * 100, 2);
                        } else {
                            $persentase = 0;
                        }

                        $set('persentase', $persentase);
                    }),
                Forms\Components\TextInput::make('persentase')
                    ->label('Persentase')
                    ->required()
                    ->disabled(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('perusahaan.nama_perusahaan')
                    ->label('Perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('paket_tender.nama_paket')
                    ->label('Paket')
                    ->placeholder('Tidak ada Data Paket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga_penawaran')
                    ->label('Harga Penawaran')
                    ->formatStateUsing(fn (?string $state) => number_format($state))
                    ->prefix('Rp '),
                Tables\Columns\TextColumn::make('harga_terkoreksi')
                    ->label('Harga Terkoreksi')
                    ->formatStateUsing(fn (?string $state) => number_format($state))
                    ->prefix('Rp '),
                Tables\Columns\TextColumn::make('persentase')
                    ->label('Persentase')
                    ->formatStateUsing(function ($state, $record){
                        return <<<HTML
                            <div>$state % dari HPS</div>
                        HTML;
                    })->html(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->modalWidth('lg')
                        ->modalHeading('Edit Peserta')
                        ->modalSubmitActionLabel('Simpan')
                        ->modalCancelActionLabel("Batal"),
                    Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManagePesertaTender::route('/'),
        ];
    }
}
