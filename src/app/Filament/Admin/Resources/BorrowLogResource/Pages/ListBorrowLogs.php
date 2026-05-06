<?php

namespace App\Filament\Admin\Resources\BorrowLogResource\Pages;

use App\Filament\Admin\Resources\BorrowLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBorrowLogs extends ListRecords
{
    protected static string $resource = BorrowLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
