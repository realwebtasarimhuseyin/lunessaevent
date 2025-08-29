<form id="yetkiForm" onsubmit="(return false)" class="row mb-4 layout-spacing layout-top-spacing">
    <div class="col-xxl-12">
        <div class="widget-content widget-content-area form-section">
            <div class="row mb-5">
                <div class="col-12 mb-4 lvvl">
                    <label for="">İsim</label>
                    <input type="text" class="form-control input" name="isim" id="isim"
                        value="{{ $yetki->name ?? '' }}" placeholder="İsim">
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Slider : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('slider-tumunugor') ? 'checked' : '' }}
                                    value="slider-tumunugor" id="slider-tumunugor">
                                <label class="form-check-label" for="slider-tumunugor">Tümünü Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('slider-gor') ? 'checked' : '' }}
                                    value="slider-gor" id="slider-gor">
                                <label class="form-check-label" for="slider-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('slider-ekle') ? 'checked' : '' }}
                                    value="slider-ekle" id="slider-ekle">
                                <label class="form-check-label" for="slider-ekle">Ekle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('slider-duzenle') ? 'checked' : '' }}
                                    value="slider-duzenle" id="slider-duzenle">
                                <label class="form-check-label" for="slider-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('slider-sil') ? 'checked' : '' }}
                                    value="slider-sil" id="slider-sil">
                                <label class="form-check-label" for="slider-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Blog : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('blog-tumunugor') ? 'checked' : '' }}
                                    value="blog-tumunugor" id="blog-tumunugor">
                                <label class="form-check-label" for="blog-tumunugor">Tümünü Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('blog-gor') ? 'checked' : '' }}
                                    value="blog-gor" id="blog-gor">
                                <label class="form-check-label" for="blog-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('blog-ekle') ? 'checked' : '' }}
                                    value="blog-ekle" id="blog-ekle">
                                <label class="form-check-label" for="blog-ekle">Ekle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('blog-duzenle') ? 'checked' : '' }}
                                    value="blog-duzenle" id="blog-duzenle">
                                <label class="form-check-label" for="blog-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('blog-sil') ? 'checked' : '' }}
                                    value="blog-sil" id="blog-sil">
                                <label class="form-check-label" for="blog-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Ürün Kategori : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-kategori-tumunugor') ? 'checked' : '' }}
                                    value="urun-kategori-tumunugor" id="urun-kategori-tumunugor">
                                <label class="form-check-label" for="urun-kategori-tumunugor">Tümünü Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-kategori-gor') ? 'checked' : '' }}
                                    value="urun-kategori-gor" id="urun-kategori-gor">
                                <label class="form-check-label" for="urun-kategori-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-kategori-ekle') ? 'checked' : '' }}
                                    value="urun-kategori-ekle" id="urun-kategori-ekle">
                                <label class="form-check-label" for="urun-kategori-ekle">Ekle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-kategori-duzenle') ? 'checked' : '' }}
                                    value="urun-kategori-duzenle" id="urun-kategori-duzenle">
                                <label class="form-check-label" for="urun-kategori-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-kategori-sil') ? 'checked' : '' }}
                                    value="urun-kategori-sil" id="urun-kategori-sil">
                                <label class="form-check-label" for="urun-kategori-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Ürün Alt Kategori : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-alt-kategori-tumunugor') ? 'checked' : '' }}
                                    value="urun-alt-kategori-tumunugor" id="urun-alt-kategori-tumunugor">
                                <label class="form-check-label" for="urun-alt-kategori-tumunugor">Tümünü
                                    Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-alt-kategori-gor') ? 'checked' : '' }}
                                    value="urun-alt-kategori-gor" id="urun-alt-kategori-gor">
                                <label class="form-check-label" for="urun-alt-kategori-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-alt-kategori-ekle') ? 'checked' : '' }}
                                    value="urun-alt-kategori-ekle" id="urun-alt-kategori-ekle">
                                <label class="form-check-label" for="urun-alt-kategori-ekle">Ekle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-alt-kategori-duzenle') ? 'checked' : '' }}
                                    value="urun-alt-kategori-duzenle" id="urun-alt-kategori-duzenle">
                                <label class="form-check-label" for="urun-alt-kategori-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-alt-kategori-sil') ? 'checked' : '' }}
                                    value="urun-alt-kategori-sil" id="urun-alt-kategori-sil">
                                <label class="form-check-label" for="urun-alt-kategori-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Ürün Varyant : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-varyant-tumunugor') ? 'checked' : '' }}
                                    value="urun-varyant-tumunugor" id="urun-varyant-tumunugor">
                                <label class="form-check-label" for="urun-varyant-tumunugor">Tümünü Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-varyant-gor') ? 'checked' : '' }}
                                    value="urun-varyant-gor" id="urun-varyant-gor">
                                <label class="form-check-label" for="urun-varyant-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-varyant-ekle') ? 'checked' : '' }}
                                    value="urun-varyant-ekle" id="urun-varyant-ekle">
                                <label class="form-check-label" for="urun-varyant-ekle">Ekle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-varyant-duzenle') ? 'checked' : '' }}
                                    value="urun-varyant-duzenle" id="urun-varyant-duzenle">
                                <label class="form-check-label" for="urun-varyant-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-varyant-sil') ? 'checked' : '' }}
                                    value="urun-varyant-sil" id="urun-varyant-sil">
                                <label class="form-check-label" for="urun-varyant-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Ürün Varyant Özellik : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-varyant-ozellik-tumunugor') ? 'checked' : '' }}
                                    value="urun-varyant-ozellik-tumunugor" id="urun-varyant-ozellik-tumunugor">
                                <label class="form-check-label" for="urun-varyant-ozellik-tumunugor">Tümünü
                                    Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-varyant-ozellik-gor') ? 'checked' : '' }}
                                    value="urun-varyant-ozellik-gor" id="urun-varyant-ozellik-gor">
                                <label class="form-check-label" for="urun-varyant-ozellik-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-varyant-ozellik-ekle') ? 'checked' : '' }}
                                    value="urun-varyant-ozellik-ekle" id="urun-varyant-ozellik-ekle">
                                <label class="form-check-label" for="urun-varyant-ozellik-ekle">Ekle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-varyant-ozellik-duzenle') ? 'checked' : '' }}
                                    value="urun-varyant-ozellik-duzenle" id="urun-varyant-ozellik-duzenle">
                                <label class="form-check-label" for="urun-varyant-ozellik-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-varyant-ozellik-sil') ? 'checked' : '' }}
                                    value="urun-varyant-ozellik-sil" id="urun-varyant-ozellik-sil">
                                <label class="form-check-label" for="urun-varyant-ozellik-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Ürün : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-tumunugor') ? 'checked' : '' }}
                                    value="urun-tumunugor" id="urun-tumunugor">
                                <label class="form-check-label" for="urun-tumunugor">Tümünü Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-gor') ? 'checked' : '' }}
                                    value="urun-gor" id="urun-gor">
                                <label class="form-check-label" for="urun-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-ekle') ? 'checked' : '' }}
                                    value="urun-ekle" id="urun-ekle">
                                <label class="form-check-label" for="urun-ekle">Ekle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-duzenle') ? 'checked' : '' }}
                                    value="urun-duzenle" id="urun-duzenle">
                                <label class="form-check-label" for="urun-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-sil') ? 'checked' : '' }}
                                    value="urun-sil" id="urun-sil">
                                <label class="form-check-label" for="urun-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Ürün Kdv : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-kdv-tumunugor') ? 'checked' : '' }}
                                    value="urun-kdv-tumunugor" id="urun-kdv-tumunugor">
                                <label class="form-check-label" for="urun-kdv-tumunugor">Tümünü Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-kdv-gor') ? 'checked' : '' }}
                                    value="urun-kdv-gor" id="urun-kdv-gor">
                                <label class="form-check-label" for="urun-kdv-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-kdv-ekle') ? 'checked' : '' }}
                                    value="urun-kdv-ekle" id="urun-kdv-ekle">
                                <label class="form-check-label" for="urun-kdv-ekle">Ekle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-kdv-duzenle') ? 'checked' : '' }}
                                    value="urun-kdv-duzenle" id="urun-kdv-duzenle">
                                <label class="form-check-label" for="urun-kdv-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('urun-kdv-sil') ? 'checked' : '' }}
                                    value="urun-kdv-sil" id="urun-kdv-sil">
                                <label class="form-check-label" for="urun-kdv-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Kupon : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('kupon-tumunugor') ? 'checked' : '' }}
                                    value="kupon-tumunugor" id="kupon-tumunugor">
                                <label class="form-check-label" for="kupon-tumunugor">Tümünü Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('kupon-gor') ? 'checked' : '' }}
                                    value="kupon-gor" id="kupon-gor">
                                <label class="form-check-label" for="kupon-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('kupon-ekle') ? 'checked' : '' }}
                                    value="kupon-ekle" id="kupon-ekle">
                                <label class="form-check-label" for="kupon-ekle">Ekle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('kupon-duzenle') ? 'checked' : '' }}
                                    value="kupon-duzenle" id="kupon-duzenle">
                                <label class="form-check-label" for="kupon-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('kupon-sil') ? 'checked' : '' }}
                                    value="kupon-sil" id="kupon-sil">
                                <label class="form-check-label" for="kupon-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Popup : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('popup-tumunugor') ? 'checked' : '' }}
                                    value="popup-tumunugor" id="popup-tumunugor">
                                <label class="form-check-label" for="popup-tumunugor">Tümünü Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('popup-gor') ? 'checked' : '' }}
                                    value="popup-gor" id="popup-gor">
                                <label class="form-check-label" for="popup-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('popup-ekle') ? 'checked' : '' }}
                                    value="popup-ekle" id="popup-ekle">
                                <label class="form-check-label" for="popup-ekle">Ekle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('popup-duzenle') ? 'checked' : '' }}
                                    value="popup-duzenle" id="popup-duzenle">
                                <label class="form-check-label" for="popup-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('popup-sil') ? 'checked' : '' }}
                                    value="popup-sil" id="popup-sil">
                                <label class="form-check-label" for="popup-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">S.s.s : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('sss-tumunugor') ? 'checked' : '' }}
                                    value="sss-tumunugor" id="sss-tumunugor">
                                <label class="form-check-label" for="sss-tumunugor">Tümünü Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('sss-gor') ? 'checked' : '' }}
                                    value="sss-gor" id="sss-gor">
                                <label class="form-check-label" for="sss-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('sss-ekle') ? 'checked' : '' }}
                                    value="sss-ekle" id="sss-ekle">
                                <label class="form-check-label" for="sss-ekle">Ekle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('sss-duzenle') ? 'checked' : '' }}
                                    value="sss-duzenle" id="sss-duzenle">
                                <label class="form-check-label" for="sss-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('sss-sil') ? 'checked' : '' }}
                                    value="sss-sil" id="sss-sil">
                                <label class="form-check-label" for="sss-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Sayfa Yönetim: </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('sayfayonetim-gor') ? 'checked' : '' }}
                                    value="sayfayonetim-gor" id="sayfayonetim-gor">
                                <label class="form-check-label" for="sayfayonetim-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('sayfayonetim-duzenle') ? 'checked' : '' }}
                                    value="sayfayonetim-duzenle" id="sayfayonetim-duzenle">
                                <label class="form-check-label" for="sayfayonetim-duzenle">Düzenle</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Sipariş: </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('siparis-gor') ? 'checked' : '' }}
                                    value="siparis-gor" id="siparis-gor">
                                <label class="form-check-label" for="siparis-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('siparis-duzenle') ? 'checked' : '' }}
                                    value="siparis-gor" id="siparis-gor">
                                <label class="form-check-label" for="siparis-gor">Düzenle</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">İletişim Form: </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('iletisimform-gor') ? 'checked' : '' }}
                                    value="iletisimform-gor" id="iletisimform-gor">
                                <label class="form-check-label" for="iletisimform-gor">Listele</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Bülten: </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('bulten-gor') ? 'checked' : '' }}
                                    value="bulten-gor" id="bulten-gor">
                                <label class="form-check-label" for="bulten-gor">Listele</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Kullanıcı : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('kullanici-gor') ? 'checked' : '' }}
                                    value="kullanici-gor" id="kullanici-gor">
                                <label class="form-check-label" for="kullanici-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('kullanici-duzenle') ? 'checked' : '' }}
                                    value="kullanici-duzenle" id="kullanici-duzenle">
                                <label class="form-check-label" for="kullanici-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('kullanici-sil') ? 'checked' : '' }}
                                    value="kullanici-sil" id="kullanici-sil">
                                <label class="form-check-label" for="kullanici-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Admin : </label>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('admin-tumunugor') ? 'checked' : '' }}
                                    value="admin-tumunugor" id="admin-tumunugor">
                                <label class="form-check-label" for="admin-tumunugor">Tümünü Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('admin-gor') ? 'checked' : '' }}
                                    value="admin-gor" id="admin-gor">
                                <label class="form-check-label" for="admin-gor">Listele</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('admin-ekle') ? 'checked' : '' }}
                                    value="admin-ekle" id="admin-ekle">
                                <label class="form-check-label" for="admin-ekle">Ekle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('admin-duzenle') ? 'checked' : '' }}
                                    value="admin-duzenle" id="admin-duzenle">
                                <label class="form-check-label" for="admin-duzenle">Düzenle</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('admin-sil') ? 'checked' : '' }}
                                    value="admin-sil" id="admin-sil">
                                <label class="form-check-label" for="admin-sil">Sil</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="row">
                        <label for="" class="col-12">Ayar : </label>

                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('ayar-gor') ? 'checked' : '' }}
                                    value="ayar-gor" id="ayar-gor">
                                <label class="form-check-label" for="ayar-gor">Listele</label>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-check form-switch form-check-inline">
                                <input class="form-check-input" type="checkbox" role="switch" name="yetkiler[]"
                                    {{ isset($yetki) && $yetki->hasPermissionTo('ayar-duzenle') ? 'checked' : '' }}
                                    value="ayar-duzenle" id="ayar-duzenle">
                                <label class="form-check-label" for="ayar-duzenle">Düzenle</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-xxl-12 col-sm-4 col-12 mx-auto" id="yetkiBtnCnt">
                    <button class="btn btn-success w-100" id="yetkiBtnSbt" type="button">
                        {{ $btnText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


@if (!empty($yetki))
    <script>
        var yetkiId = {{ $yetki->id }};
    </script>
@endif
