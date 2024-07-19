<?php

namespace App\Filament\Resources\Data\PaketResource\Pages;

use App\Filament\Resources\Data\PaketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaket extends ListRecords
{
    protected static string $resource = PaketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Paket Tender'),
        ];
    }

    public function getBreadcrumb(): string
    {
        return "List Paket";
    }

    public function getTitle(): string
    {
        return "Daftar Paket Tender";
    }
}
