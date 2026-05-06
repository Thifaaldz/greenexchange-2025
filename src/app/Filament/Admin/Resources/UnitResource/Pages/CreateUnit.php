<?php

namespace App\Filament\Admin\Resources\UnitResource\Pages;

use App\Filament\Admin\Resources\UnitResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CreateUnit extends CreateRecord
{
    protected static string $resource = UnitResource::class;

    /**
     * Setelah data unit disimpan, otomatis buat QR code-nya.
     */
    protected function afterCreate(): void
    {
        $record = $this->record;

        // Tentukan path QR Code
        $qrPath = 'qrcodes/unit-' . $record->id . '.png';

        // Data yang akan dimasukkan ke dalam QR code
        $data = json_encode([
            'unit_id' => $record->id,
            'name' => $record->name,
            'url' => url('/unit/' . $record->id), // Opsional: arahkan ke halaman unit
        ]);

        // Generate QR code (format PNG, ukuran 300px)
        $qr = QrCode::format('png')->size(300)->generate($data);

        // Simpan QR code ke storage publik
        Storage::disk('public')->put($qrPath, $qr);

        // Update kolom qr_path di database agar bisa ditampilkan di tabel
        $record->update([
            'qr_path' => 'storage/' . $qrPath,
        ]);
    }
}
