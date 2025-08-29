<div class="widget widget-table-three">
    <div class="widget-heading">
        <h5 class="">{{ $title }}</h5>
    </div>

    <div class="widget-content">
        <div class="table-responsive">
            <table class="table table-scroll">
                <thead>
                    <tr>
                        <th>
                            <div class="th-content">Sayfa URL</div>
                        </th>
                        <th>
                            <div class="th-content th-heading text-center w-100 p-1 m-0">Ziyaret Sayısı</div>
                        </th>
                        <th>
                            <div class="th-content th-heading text-center w-100 p-1 m-0">En Popüler Tarayıcı</div>
                        </th>
                        <th>
                            <div class="th-content th-heading text-center w-100 p-1 m-0">En Popüler Cihaz Tipi</div>
                        </th>
                        <th>
                            <div class="th-content th-heading text-center w-100 p-1 m-0">En Popüler Şehir</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($populerSayfalar as $sayfa)
                        <tr>
                            <td>
                                <div class="td-content">
                                    <a href="{{ env('APP_URL') . '/' . $sayfa->url }}"
                                        target="_blank">{{ $sayfa->url }}</a>
                                </div>
                            </td>
                            <td>
                                <div class="td-content text-center p-0 m-0 w-100">
                                    <span>{{ number_format($sayfa->ziyaret_sayisi) }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="td-content text-center p-0 m-0 w-100">
                                    <span>{{ $sayfa->en_populer_tarayici }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="td-content text-center p-0 m-0 w-100">
                                    <span>{{ $sayfa->en_populer_cihaiz_tip }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="td-content text-center p-0 m-0 w-100">
                                    <span>{{ $sayfa->en_populer_il }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
