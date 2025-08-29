<div class="widget-four">
    <div class="widget-heading">
        <h5 class="">{{ $title }}</h5>
    </div>
    <div class="widget-content">
        <div class="vistorsBrowser">
            @foreach ($populerTarayicilar as $tarayici)
                @php
$cumle = $tarayici['tarayici_isim'];

                    $resimYolu = '';
                    if (stripos($cumle, 'Chrome') !== false) {
                        $resimYolu = Vite::asset('resources/images/chrome.png');
                    } elseif (stripos($cumle, 'Firefox') !== false) {
                        $resimYolu = Vite::asset('resources/images/firefox.png');
                    } elseif (stripos($cumle, 'Safari') !== false) {
                        $resimYolu = Vite::asset('resources/images/safari.png');
                    } elseif (stripos($cumle, 'Opera') !== false) {
                        $resimYolu = Vite::asset('resources/images/opera.png');
                    } elseif (stripos($cumle, 'Edge') !== false) {
                        $resimYolu = Vite::asset('resources/images/edge.png');
                    } else {
                        $resimYolu = '';
                    }
                @endphp
                <div class="browser-list">
                    <div class="">
                        <img src="{{ $resimYolu }}" alt="{{ $tarayici['tarayici_isim'] }}"
                            style="height: 40px; padding-right:1rem">
                    </div>
                    <div class="w-browser-details">
                        <div class="w-browser-info">
                            <h6> {{ $tarayici['tarayici_isim'] }}
                                ({{ $tarayici['ziyaret_sayisi'] }})
                            </h6>
                            <p class="browser-count">
                                {{ $tarayici['ziyaret_yuzdesi'] }}%
                            </p>
                        </div>
                        <div class="w-browser-stats">
                            <div class="progress">
                                <div class="progress-bar bg-gradient-primary" role="progressbar"
                                    style="width: {{ $tarayici['ziyaret_yuzdesi'] < 0 ? 1 : $tarayici['ziyaret_yuzdesi'] }}%"
                                    aria-valuenow="{{ $tarayici['ziyaret_yuzdesi'] < 0 ? 1 : $tarayici['ziyaret_yuzdesi'] }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
