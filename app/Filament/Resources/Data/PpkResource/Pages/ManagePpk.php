<?php

namespace App\Filament\Resources\Data\PpkResource\Pages;

use App\Filament\Resources\Data\PpkResource;
use Filament\Actions;
use Filament\Actions\StaticAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePpk extends ManageRecords
{
    protected static string $resource = PpkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('lg')
                ->modalSubmitActionLabel('Tambah')
                ->modalCancelActionLabel("Batal")
                ->modalHeading('Tambah PPK')
                ->label('Tambah PPK')
                ->extraModalFooterActions(function (StaticAction $action): array {
                    return $action->canCreateAnother() ? [
                        $action->makeModalSubmitAction('createAnother', arguments: ['another' => true])
                            ->label('Tambah dan Buat Lagi'),
                    ] : [];
                }),
        ];
    }
}
