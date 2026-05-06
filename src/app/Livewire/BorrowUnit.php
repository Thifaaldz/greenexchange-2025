<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Unit;
use App\Models\BorrowLog;
use Illuminate\Support\Carbon;

class BorrowUnit extends Component
{
    use WithFileUploads;

    public $qrFile;
    public $unitData;
    public $borrower_name;
    public $borrower_contact;
    public $successMessage;

    protected $listeners = ['qrScanned' => 'handleQrScanned'];

    /**
     * ✅ Saat QR di-scan lewat kamera (misalnya dari JS scanner)
     */
    public function handleQrScanned($qrMessage)
    {
        $decoded = json_decode($qrMessage, true);

        if (isset($decoded['unit_id'])) {
            $unit = Unit::find($decoded['unit_id']);

            if (!$unit) {
                $this->addError('qrFile', 'Unit tidak ditemukan di database.');
                return;
            }

            if ($unit->status === 'borrowed') {
                $this->addError('qrFile', '⚠️ Unit ini sedang dipinjam, tidak dapat di-scan lagi.');
                return;
            }

            $this->unitData = $unit;
        } else {
            $this->addError('qrFile', 'QR Code tidak valid.');
        }
    }

    /**
     * ✅ Saat QR di-upload sebagai file (bukan di-scan)
     */
    public function updatedQrFile()
    {
        if (!$this->qrFile) return;

        $path = $this->qrFile->store('temp', 'public');
        $fullPath = storage_path('app/public/' . $path);

        try {
            // Gunakan library ZXing
            $qrcode = new \Zxing\QrReader($fullPath);
            $text = $qrcode->text();

            if ($text) {
                $decoded = json_decode($text, true);

                if (isset($decoded['unit_id'])) {
                    $unit = Unit::find($decoded['unit_id']);

                    if (!$unit) {
                        $this->addError('qrFile', 'Unit tidak ditemukan di database.');
                        return;
                    }

                    if ($unit->status === 'borrowed') {
                        $this->addError('qrFile', '⚠️ Unit ini sedang dipinjam, tidak dapat di-scan lagi.');
                        return;
                    }

                    $this->unitData = $unit;
                } else {
                    $this->addError('qrFile', 'QR Code tidak valid.');
                }
            } else {
                $this->addError('qrFile', 'QR Code tidak terbaca.');
            }
        } catch (\Exception $e) {
            $this->addError('qrFile', 'QR tidak dapat dibaca: ' . $e->getMessage());
        }
    }

    /**
     * ✅ Simpan data peminjaman ke database
     */
    public function submitBorrow()
    {
        $this->validate([
            'borrower_name' => 'required|string|max:255',
            'borrower_contact' => 'required|string|max:255',
        ]);

        if (!$this->unitData) {
            $this->addError('unitData', 'QR Code belum dipindai.');
            return;
        }

        // Pastikan unit belum dipinjam
        if ($this->unitData->status === 'borrowed') {
            $this->addError('unitData', 'Unit ini sedang dipinjam dan tidak bisa dipinjam ulang.');
            return;
        }

        // Simpan log peminjaman
        BorrowLog::create([
            'unit_id' => $this->unitData->id,
            'borrower_name' => $this->borrower_name,
            'borrower_contact' => $this->borrower_contact,
            'borrowed_at' => Carbon::now(),
            'status' => 'borrowed',
        ]);

        // Update status unit
        $this->unitData->update(['status' => 'borrowed']);

        // Reset form
        $this->successMessage = "✅ Peminjaman unit '{$this->unitData->name}' berhasil disimpan.";
        $this->reset(['qrFile', 'unitData', 'borrower_name', 'borrower_contact']);
    }

    public function render()
    {
        return view('livewire.borrow-unit');
    }
}
