<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Kategori Transferi İşlemi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <h4 class="modal-heading mb-4 mt-2">Bu Kategori Şu An Silinemez!</h4>
                <p class="modal-text">
                    Seçtiğiniz kategori, mevcut projelerle ilişkilendirilmiştir ve bu nedenle doğrudan silinememektedir.
                    Kategoriyi silmeden önce, o kategoriye bağlı tüm projelerin başka bir kategoriye aktarılması
                    gerekmektedir.
                </p>
                <br>
                <div class="form-group row mb-4">
                    <label for="transferKategori">Projelerin Transfer Edileceği Yeni Kategori</label>
                    <select class="form-control" id="transferKategori" name="transferKategori">
                        <option value="" disabled selected>Lütfen Bir Kategori Seçin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light-dark" data-bs-dismiss="modal">Vazgeç</button>
                <button type="button" class="btn btn-primary" id="transferOnayBtn">Onayla ve Devam Et</button>
            </div>
        </div>
    </div>
</div>
