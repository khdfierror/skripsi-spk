<?php

namespace App\Filament\Resources\Data;

use App\Filament\Forms\Components\MoneyInput;
use App\Filament\Resources\Data\PaketResource\Pages;
use App\Filament\Resources\Data\PaketResource\RelationManagers;
use App\Models\Data\Evaluasi;
use App\Models\Data\JenisEvaluasi;
use App\Models\Data\Paket;
use App\Models\PaketBobot;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;


class PaketResource extends Resource
{
    protected static ?string $model = Paket::class;

    protected static ?string $slug = 'data/paket';

    protected static ?string $navigationIcon = null;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationLabel = 'Paket Tender';

    protected static ?string $pluralModelLabel = 'Paket Tender';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(6)->schema([
                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\TextInput::make('tahun')
                            ->label('Tahun')
                            ->required(),
                        Forms\Components\Select::make('satker_id')
                            ->label('Satker')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->relationship('satker', 'nama_satker')
                            ->required(),
                        Forms\Components\Select::make('ppk_id')
                            ->label('PPK')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->relationship('ppk', 'nama_ppk')
                            ->required(),
                        Forms\Components\TextInput::make('kode_paket')
                            ->label('Kode Tender')
                            ->required(),
                        Forms\Components\TextInput::make('nama_paket')
                            ->label('Nama Paket')
                            ->required(),
                        MoneyInput::make('pagu')
                            ->label('Pagu')
                            ->required(),
                        MoneyInput::make('hps')
                            ->label('HPS')
                            ->required(),
                    ])->columnSpan(4),
                    Forms\Components\Fieldset::make()->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Dibuat pada')
                            ->content(fn (Model $record) => $record?->created_at?->locale('id')->isoFormat('dddd, DD MMMM Y H:mm z')),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Diubah pada')
                            ->content(fn (Model $record) => $record?->updated_at?->locale('id')->isoFormat('dddd, DD MMMM Y H:mm z')),
                    ])->columns(1)->columnSpan(2)->hiddenOn('create')->extraAttributes([
                        'class' => 'dark:bg-white/5',
                    ]),
                ])->columnSpanFull(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_paket')
                    ->label('Paket')
                    ->searchable()
                    ->formatStateUsing(function ($state, $record) {
                        return <<<HTML
                            <div>$state</div>
                            <div class='text-xs text-gray-500'>Kode: $record->kode_paket</div>
                        HTML;
                    })->html(),

                Tables\Columns\TextColumn::make('satker.nama_satker')
                    ->label('Satker')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ppk.nama_ppk')
                    ->label('PPK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pagu')
                    ->label('Pagu')
                    ->formatStateUsing(fn (?string $state) => number_format($state))
                    ->prefix('Rp '),
                Tables\Columns\TextColumn::make('hps')
                    ->label('HPS')
                    ->formatStateUsing(fn (?string $state) => number_format($state))
                    ->prefix('Rp '),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\Action::make('paket_bobot')
                //             ->hiddenLabel()
                //             ->icon('carbon-document')
                //             ->iconButton()
                //             // ->form(fn ($form) => static::getBobotForm($form))
                //             ->form(function ($record) {
                //                 $jenisEvaluasi = JenisEvaluasi::query()
                //                     ->orderBy('no')
                //                     ->get();
                //                 $data = [];
                //                 foreach ($jenisEvaluasi as $jenis) {
                //                     $evaluasi = Evaluasi::query()
                //                         ->where('jenis_evaluasi_id', $jenis->id)
                //                         ->orderBy('no')
                //                         ->get();
                //                     $data[] =
                //                         TableRepeater::make('paket_bobot' . $jenis->id)
                //                         ->streamlined()
                //                         ->relationship('paket_bobot')
                //                         ->headers([
                //                             Header::make('evaluasi')
                //                                 ->label('Uraian')
                //                                 ->markAsRequired(),
                //                             Header::make('nilai_bobot')
                //                                 ->label('Nilai Bobot')
                //                                 ->width('120px')
                //                                 ->markAsRequired(),
                //                         ])
                //                         ->schema([
                //                             Forms\Components\Hidden::make('evaluasi_id'),
                //                             Forms\Components\TextInput::make('uraian')
                //                                 ->disabled()
                //                                 ->label('Uraian'),
                //                             Forms\Components\TextInput::make('nilai_bobot')
                //                                 ->label('Nilai Bobot')
                //                                 // ->numeric()
                //                                 ->suffix('%')
                //                                 ->required(),
                //                         ])
                //                         ->columns(2)
                //                         ->addable(false)
                //                         ->deletable(false)
                //                         ->label($jenis->nama_jenis)
                //                         ->live(onBlur: true)
                //                         ->afterStateUpdated(function ($state, callable $set, $get) use ($evaluasi, $jenis, $record) {
                //                             $element = 'paket_bobot' . $jenis->id;

                //                             $jumlahBobot = 0;
                //                             $uraian = 'Jumlah Bobot';

                //                             foreach ($evaluasi as $index => $evaluasi) {
                //                                 $nilaiBobot = $get("$element.$index.nilai_bobot");
                //                                 $jumlahBobot += is_numeric($nilaiBobot) ? $nilaiBobot :   0;

                //                                 $uraian = ($jumlahBobot < 100 ? 'Jumlah Bobot tidak mencukupi' : 'Jumlah Bobot');
                //                             }
                //                             $set("$element.99.uraian", $uraian);
                //                             $set("$element.99.nilai_bobot", $jumlahBobot);
                //                         })
                //                         ->afterStateHydrated(function ($state, callable $set) use ($evaluasi, $jenis, $record) {
                //                             $element = 'paket_bobot' . $jenis->id;
                //                             $set("$element", []);

                //                             $jumlahBobot = 0;

                //                             foreach ($evaluasi as $index => $evaluasi) {
                //                                 $nilaiBobot =

                //                                     PaketBobot::query()
                //                                     ->where('paket_tender_id', $record->id)
                //                                     ->where('evaluasi_id', $evaluasi->id)
                //                                     ->first()
                //                                     ->nilai_bobot ?? '';
                //                                 $jumlahBobot += is_numeric($nilaiBobot) ? $nilaiBobot : 0;
                //                                 $set("$element.$index.evaluasi_id", $evaluasi->id);
                //                                 $set("$element.$index.uraian", $evaluasi->uraian);
                //                                 $set(
                //                                     "$element.$index.nilai_bobot",
                //                                     $nilaiBobot
                //                                 );
                //                             }
                //                             $set("$element.99.uraian", 'Jumlah Bobot');
                //                             $set("$element.99.nilai_bobot", $jumlahBobot);
                //                         });
                //                 }
                //                 // dd($data);
                //                 return $data;
                //             })
                //             ->action(function ($record, array $data) {
                //                 $jenisEvaluasi = JenisEvaluasi::query()
                //                     ->get();
                //                 foreach ($jenisEvaluasi as $jenis) {
                //                     foreach ($data['paket_bobot' . $jenis->id] ?? [] as $item) {
                //                         PaketBobot::query()
                //                             ->updateOrCreate(
                //                                 [
                //                                     'paket_tender_id' => $record->id,
                //                                     'evaluasi_id' => $item['evaluasi_id']
                //                                 ],
                //                                 [
                //                                     'nilai_bobot' => $item['nilai_bobot']
                //                                 ]
                //                             );
                //                     }
                //                 }

                //                 Notification::make()
                //                     ->title('Berhasil')
                //                     ->body('Data Bobot berhasil diperbarui.')
                //                     ->success()
                //                     ->color('success')
                //                     ->send();
                //             })
                //             ->slideOver()
                //             ->modalSubmitActionLabel('Tambah')
                //             ->modalCancelActionLabel('Batal')
                //             ->modalHeading('Tambah Realisasi')
                //             ->tooltip('Atur Bobot'),
                Tables\Actions\ActionGroup::make(
                    [
                        Tables\Actions\EditAction::make(),
                        Tables\Actions\DeleteAction::make()
                            ->label('Hapus'),
                    ]

                )
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
            'index' => Pages\ListPaket::route('/'),
            'create' => Pages\CreatePaket::route('/create'),
            'edit' => Pages\EditPaket::route('/{record}/edit'),
        ];
    }
}
