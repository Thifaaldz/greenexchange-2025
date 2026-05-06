<div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-6 space-y-4">
    <h2 class="text-xl font-semibold mb-2">📦 Peminjaman Unit</h2>

    {{-- Scanner Kamera --}}
    <div id="reader" class="w-full border rounded-lg"></div>

    <div class="flex items-center justify-center text-gray-500 my-2">atau</div>

    {{-- Upload QR Code --}}
    <div>
        <input type="file" wire:model="qrFile" accept="image/*" class="border p-2 rounded w-full">
        @error('qrFile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Jika QR valid, tampilkan detail unit --}}
    @if ($unitData)
        <div class="bg-green-100 p-3 rounded">
            <p><strong>Unit ID:</strong> {{ $unitData->id }}</p>
            <p><strong>Nama Unit:</strong> {{ $unitData->name }}</p>
            <p><strong>Cabang:</strong> {{ $unitData->branch->name ?? '-' }}</p>
        </div>

        <div class="mt-3 space-y-3">
            <input type="text" wire:model="borrower_name" placeholder="Nama Peminjam"
                   class="border p-2 rounded w-full">
            <input type="text" wire:model="borrower_contact" placeholder="Kontak (HP / Email)"
                   class="border p-2 rounded w-full">
            <button wire:click="submitBorrow"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
                Simpan Peminjaman
            </button>
        </div>
    @endif

    {{-- Notifikasi --}}
    @if ($successMessage)
        <div class="p-3 bg-green-200 text-green-800 rounded mt-3">{{ $successMessage }}</div>
    @endif
</div>

{{-- Scanner QR pakai kamera --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const html5QrCode = new Html5Qrcode("reader");
    html5QrCode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        qrCodeMessage => {
            Livewire.emit('qrScanned', qrCodeMessage);
        },
        errorMessage => {}
    );
});
</script>
