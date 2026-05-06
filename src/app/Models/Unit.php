<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'name',
        'code',
        'qr_path',
        'status',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    protected static function booted()
    {
        static::created(function ($unit) {
            // Buat URL tujuan saat QR di-scan
            $url = url('/units/' . $unit->id);

            // Path file QR
            $qrPath = 'qrcodes/qr_unit_' . $unit->id . '.png';

            // Generate QR Code dengan isi URL unit
            $qr = QrCode::format('png')->size(400)->generate($url);

            // Simpan QR ke storage
            Storage::disk('public')->put($qrPath, $qr);

            // Simpan path ke database
            $unit->updateQuietly(['qr_path' => $qrPath]);
        });

        // Jika di-update, regenerasi QR baru (optional)
        static::updated(function ($unit) {
            $url = url('/units/' . $unit->id);
            $qrPath = 'qrcodes/qr_unit_' . $unit->id . '.png';
            $qr = QrCode::format('png')->size(400)->generate($url);
            Storage::disk('public')->put($qrPath, $qr);
            $unit->updateQuietly(['qr_path' => $qrPath]);
        });
    }
}
