<?php

namespace App\Filament\Resources\Data\PerusahaanResource\Pages;

use App\Filament\Resources\Data\PerusahaanResource;
use Filament\Actions;
use Filament\Actions\StaticAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePerusahaan extends ManageRecords
{
    protected static string $resource = PerusahaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('lg')
                ->successNotificationTitle('Data Perusahaan berhasil Ditambahkan')
                ->modalSubmitActionLabel('Tambah')
                ->modalCancelActionLabel("Batal")
                ->modalHeading('Tambah Perusahaan')
                ->label('Tambah Perusahaan')
                ->extraModalFooterActions(function (StaticAction $action): array {
                    return $action->canCreateAnother() ? [
                        $action->makeModalSubmitAction('createAnother', arguments: ['another' => true])
                            ->label('Tambah dan Buat Lagi'),
                    ] : [];
                }),
        ];
    }
}
