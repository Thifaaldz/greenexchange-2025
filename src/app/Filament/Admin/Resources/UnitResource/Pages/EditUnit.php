<?php

namespace App\Filament\Admin\Resources\UnitResource\Pages;

use App\Filament\Admin\Resources\UnitResource;
use App\Models\Unit;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\On;

class EditUnit extends EditRecord
{
    protected static string $resource = UnitResource::class;

    public ?Unit $unitData = null;

    #[On('qrScanned')]
    public function onQrScanned($qrMessage)
    {
        // Parsing isi QR
        $data = json_decode($qrMessage, true);

        if (!$data || !isset($data['unit_id'])) {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'QR Code tidak valid!',
            ]);
            return;
        }

        // Cek unit di database
        $unit = Unit::find($data['unit_id']);
        if ($unit) {
            $this->unitData = $unit;

            // Jika mau redirect langsung ke halaman edit unit itu:
            $this->redirect(UnitResource::getUrl('edit', ['record' => $unit]));
        } else {
            $this->dispatchBrowserEvent('notify', [
                'type' => 'error',
                'message' => 'Unit tidak ditemukan.',
            ]);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            // Tambahkan tombol lain kalau perlu
        ];
    }
}
