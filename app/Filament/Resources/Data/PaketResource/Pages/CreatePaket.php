<?php

namespace App\Filament\Resources\Data\PaketResource\Pages;

use App\Filament\Resources\Data\PaketResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Js;

class CreatePaket extends CreateRecord
{
    protected static string $resource = PaketResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getCreateFormAction(): Action
    {
        return Action::make('create')
            ->label("Buat")
            ->submit('create')
            ->keyBindings(['mod+s']);
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return Action::make('createAnother')
            ->label("Buat & Tambah Paket Baru")
            ->action('createAnother')
            ->keyBindings(['mod+shift+s'])
            ->color('gray');
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label("Batalkan")
            ->alpineClickHandler('document.referrer ? window.history.back() : (window.location.href = ' . Js::from($this->previousUrl ?? static::getResource()::getUrl()) . ')')
            ->color('gray');
    }

    public function getBreadcrumb(): string
    {
        return "Buat Paket";
    }

    public function getTitle(): string
    {
        return "Buat Paket Tender";
    }
}
