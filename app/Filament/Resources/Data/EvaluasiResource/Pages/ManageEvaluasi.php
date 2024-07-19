<?php

namespace App\Filament\Resources\Data\EvaluasiResource\Pages;

use App\Filament\Resources\Data\EvaluasiResource;
use Filament\Actions;
use Filament\Actions\StaticAction;
use Filament\Resources\Pages\ManageRecords;

class ManageEvaluasi extends ManageRecords
{
    protected static string $resource = EvaluasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('lg')
                ->modalSubmitActionLabel('Tambah')
                ->modalCancelActionLabel("Batal")
                ->modalHeading('Tambah Evaluasi')
                ->label('Tambah Evaluasi')
                ->extraModalFooterActions(function (StaticAction $action): array {
                    return $action->canCreateAnother() ? [
                        $action->makeModalSubmitAction('createAnother', arguments: ['another' => true])
                            ->label('Tambah dan Buat Lagi'),
                    ] : [];
                }),
        ];
    }
}
