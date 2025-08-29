@foreach ($popuplar as $index => $popup)
    @php
        $popupDilVerisi = $popup->popupDiller->where('dil', $aktifDil)->first();
        $modalId = 'popupModal' . $index;
    @endphp

    <div class="modal theme-modal newsletter-modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered w-100" role="document">
            <div class="modal-content">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body p-0">
                    <div class="news-latter-box">
                        <div class="text-center">
                            @if ($popup->resim_url)
                                <img src="{{ Storage::url($popup->resim_url) }}"
                                    style="width: 100%;border-radius: 1rem;max-height: 300px;object-fit: contain;">
                            @endif
                        </div>
                        <h2 style="color:black !important">{{ $popupDilVerisi->baslik }}</h2>
                        <div>{{ $popupDilVerisi->icerik }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    window.onload = function() {
        // Tüm modalları seçip sırayla aç
        document.querySelectorAll('.modal').forEach(function(modalElement) {
            var modal = new bootstrap.Modal(modalElement);
            modal.show();
        });
    }
</script>
