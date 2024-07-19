<?php

namespace App\Filament\Resources\PesertaTenderResource\Pages;

use App\Filament\Resources\PesertaTenderResource;
use Filament\Actions;
use Filament\Actions\StaticAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePesertaTender extends ManageRecords
{
    protected static string $resource = PesertaTenderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Peserta')
                ->modalWidth('lg')
                ->modalSubmitActionLabel('Tambah')
                ->modalCancelActionLabel("Batal")
                ->modalHeading('Tambah Peserta')
                ->extraModalFooterActions(function (StaticAction $action): array {
                    return $action->canCreateAnother() ? [
                        $action->makeModalSubmitAction('createAnother', arguments: ['another' => true])
                            ->label('Tambah dan Buat Lagi'),
                    ] : [];
                })
        ];
    }
}
