<?php

namespace App\Livewire;

use App\Models\Unit;
use Livewire\Component;

class QrScanner extends Component
{
protected $listeners = ['qrScanned' => 'handleScan'];

    public $unitData;

    public function handleScan($message)
    {
        $data = json_decode($message, true);
        $this->unitData = Unit::find($data['unit_id']);
    }

    public function render()
    {
        return view('livewire.qr-scanner');
    }
}
