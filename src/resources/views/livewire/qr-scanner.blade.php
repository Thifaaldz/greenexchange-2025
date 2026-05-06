<div>
    <div id="reader" style="width: 300px;"></div>

    @if ($unitData)
        <div class="mt-4 p-3 bg-green-100 rounded">
            <p><strong>Unit ID:</strong> {{ $unitData->id }}</p>
            <p><strong>Nama Unit:</strong> {{ $unitData->name }}</p>
            <p><strong>Cabang:</strong> {{ $unitData->branch->name ?? '-' }}</p>
        </div>
    @endif
</div>

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

