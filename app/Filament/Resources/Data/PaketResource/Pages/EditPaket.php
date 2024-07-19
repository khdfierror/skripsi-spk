<?php

namespace App\Filament\Resources\Data\PaketResource\Pages;

use App\Filament\Resources\Data\PaketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaket extends EditRecord
{
    protected static string $resource = PaketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    public function getBreadcrumb(): string
    {
        return "Ubah Paket";
    }

    public function getTitle(): string
    {
        return "Ubah Paket Tender";
    }
}
