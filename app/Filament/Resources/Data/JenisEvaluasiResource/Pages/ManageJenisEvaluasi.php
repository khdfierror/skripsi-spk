<?php

namespace App\Filament\Resources\Data\JenisEvaluasiResource\Pages;

use App\Filament\Resources\Data\JenisEvaluasiResource;
use Filament\Actions;
use Filament\Actions\StaticAction;
use Filament\Resources\Pages\ManageRecords;

class ManageJenisEvaluasi extends ManageRecords
{
    protected static string $resource = JenisEvaluasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('sm')
                ->modalSubmitActionLabel('Tambah')
                ->modalCancelActionLabel("Batal")
                ->modalHeading('Tambah Jenis')
                ->label('Tambah Jenis')
                ->extraModalFooterActions(function (StaticAction $action): array {
                    return $action->canCreateAnother() ? [
                        $action->makeModalSubmitAction('createAnother', arguments: ['another' => true])
                            ->label('Tambah dan Buat Lagi'),
                    ] : [];
                }),
        ];
    }
}
