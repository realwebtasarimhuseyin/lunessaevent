"use strict";

import useReal from "../../../script/real.js";

const RPUrunKategoriIndex = (function () {
    const { AjaxDataTables, ZamanFormati, Swall } = useReal();
    let urunKategoriDataTable;

    const UrunKategoriTable = function () {
        urunKategoriDataTable = AjaxDataTables({
            id: "urunKategoriDataTable",
            ajax: {
                url: `${panelUrl}/urunkategori/tableliste`,
                data: function (data) {
                    data.ara = ""; /* $("input[name='tablo-ara']").val(); */ // Dinamik olarak ara değerini alır
                },
            },
            sutunlar: [
                { data: "sira_no" },
                { data: "created_at" },
                { data: "isim" },
                { data: "durum" },
                { data: null },
            ],

            sutunTanim: [
                {
                    targets: [0],
                    render: function (data, type, row, meta) {
                        return `<span>${data}</span>`;
                    },
                },
                {
                    targets: [1],
                    render: function (data, type, row, meta) {
                        return `<span>${data}</span>`;
                    },
                },
                {
                    targets: [3],
                    render: function (data, type, row, meta) {
                        return `<span>${data == 1 ? "Aktif" : "Pasif"}</span>`;
                    },
                },
                {
                    targets: [4],
                    orderable: false,
                    className: "text-center max-w-min min-w-max",
                    render: function (data, type, row, meta) {
                        return `
                        
                            <a href="${panelUrl}/urunkategori/duzenle/${row.id}" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                            <a href="javascript:void(0);" class="bs-tooltip tablo-satir-sil" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                        `;
                    },
                },
            ],
            buttons: {
                print: {
                    dosyaAdi: "urunKategori-liste",
                    baslik: "Ürün Kategori Liste",
                    tabloSutun: [0, 1, 2],
                },

                excel: {
                    dosyaAdi: "urunKategori-liste",
                    baslik: "Ürün Kategori Liste",
                    tabloSutun: [0, 1, 2],
                },

                pdf: {
                    dosyaAdi: "urunKategori-liste",
                    baslik: "Ürün Kategori Liste",
                    tabloSutun: [0, 1, 2],
                },
            },
        });

    };
    const UrunKategoriTableKontrol = function () {
        document
            .querySelector("#urunKategoriDataTable")
            .addEventListener("click", (e) => {
                if (e.target.closest(".tablo-satir-sil")) {

                    handleDelete(e);

                }
            });

        urunKategoriDataTable.on('row-reorder', function (e, details, changes) {
            const sortedSiraNo = details
                .map(row => urunKategoriDataTable.row(row.node).data().sira_no)
                .sort((a, b) => a - b);

            const kategoriler = details.map((row, index) => {
                return {
                    id: urunKategoriDataTable.row(row.node).data().id,
                    sira: sortedSiraNo[index]
                };
            });

            if (kategoriler.length > 0) {
                Swall({
                    icon: "success",
                    baslik: "Sıralama Değiştiriyor",
                    onayButonDurum: false
                });

                axios.post(`${panelUrl}/urunkategori/siralamaduzenle`, { kategoriler: kategoriler })
                    .then(function (response) {
                        setTimeout(() => {
                            Swall({
                                icon: "success",
                                baslik: "Sıralama Değiştirildi",
                            });
                        }, 1000);

                        urunKategoriDataTable.draw();
                    })
                    .catch(function (error) {
                        console.error('Sıralama güncelleme hatası:', error);
                    });
            }

        });


    }

    const handleDelete = (e) => {
        e.preventDefault();
        const parent = e.target.closest("tr");
        const data = urunKategoriDataTable.row($(parent)).data();

        // Kategoriye bağlı ürünleri kontrol et
        if (data.toplam_urun == 0) {
            Swall({
                icon: "warning",
                icerik: "Ürün Kategori Silinicek Onaylıyormusunuz!",
                iptalButonDurum: true,
            }).then((result) => {
                if (result.value) {
                    axios
                        .post(`${panelUrl}/urunkategori/sil/${data.id}`)
                        .then((response) => {
                            Swall({
                                icon: "success",
                                icerik: response.data.mesaj,
                                onayButonİcerik: "Tamam!",
                            }).then(() => {
                                urunKategoriDataTable.draw();
                            });
                        })
                        .catch((error) => {
                            Swall({
                                icon: "error",
                                icerik: error.response
                                    ? error.response.data.mesaj
                                    : "Hata Oluştu!",
                                onayButonİcerik: "Tamam!",
                            });
                        });
                }
            });
        } else {
            // Eğer kategoriye bağlı ürün varsa, transfer modal'ını aç
            axios
                .get(`${panelUrl}/urunkategori/liste`, { params: { urunKategori: data.id } })
                .then((response) => {
                    let options = ``;
                    response.data.forEach(element => {
                        options += `<option value="${element.id}">${element.isim}</option>`;
                    });

                    // Transfer kategori dropdown'unu güncelle
                    const transferKategoriSelect = $("#transferKategori");
                    transferKategoriSelect.html("<option value='' selected disabled>Lütfen Bir Kategori Seçin</option>").append(options);
                });

            // Modal'ı aç
            const transferModal = new bootstrap.Modal(document.getElementById('transferModal'), {
                keyboard: false
            });
            transferModal.show();

            // Onayla ve Devam Et butonuna tıklanma olayını dinle
            document.querySelector("#transferOnayBtn").addEventListener('click', function () {
                const selectedKategori = document.getElementById('transferKategori').value;

                if (!selectedKategori) {
                    Swall({
                        icon: "warning",
                        icerik: "Lütfen bir kategori seçin!",
                        onayButonİcerik: "Tamam!",
                    })
                    return;
                }

                Swall({
                    icon: "question",
                    icerik: "Ürünlerinizi bu kategoriye aktarmak istediğinize emin misiniz?",
                    iptalButonDurum: true,
                    onayButonİcerik: "Evet, Aktar",
                    iptalButonİcerik: "Hayır, İptal Et"

                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kategoriyi transfer et
                        axios
                            .post(`${panelUrl}/urunkategori/transfer`, {
                                eskiKategoriId: data.id,
                                yeniKategoriId: selectedKategori
                            })
                            .then((response) => {
                                Swall({
                                    icon: "success",
                                    icerik: response.data.mesaj,
                                    onayButonİcerik: "Tamam!",
                                }).then(() => {
                                    urunKategoriDataTable.draw();
                                });
                            })
                            .catch((error) => {
                                Swall({
                                    icon: "error",
                                    icerik: error.response
                                        ? error.response.data.mesaj
                                        : "Bir hata oluştu!",
                                    onayButonİcerik: "Tamam!",
                                });
                            });
                    }
                });
            });
        }
    };

    return {
        init: function () {
            UrunKategoriTable();
            UrunKategoriTableKontrol();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunKategoriIndex.init();
});
