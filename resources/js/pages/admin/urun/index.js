"use strict";

import useReal from "../../../script/real.js";

const RPUrunIndex = (function () {
    const { AjaxDataTables, ZamanFormati, Swall } = useReal();
    let urunDataTable;

    const UrunTable = function () {
        urunDataTable = AjaxDataTables({
            id: "urunDataTable",
            ajax: {
                url: `${panelUrl}/urun/liste`,
                data: function (data) {
                    data.ara = $("input[name='tablo-ara']").val().trim();
                    data.durum = $("select[name='tablo-durum']").val();
                    data.kategori = $("select[name='tablo-kategori']").val();
                },
            },
            sutunlar: [
                { data: "sira_no" },
                { data: "created_at" },
                { data: "baslik" },
                { data: "sepet_urun_sayisi" },
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
                    className: "text-center",
                    render: function (data, type, row, meta) {
                        return `<span>${data}</span>`;
                    },
                },
                {
                    targets: [4],
                    render: function (data, type, row, meta) {
                        return `<span>${data == 1 ? "Aktif" : "Pasif"}</span>`;
                    },
                },
                {
                    targets: [5],
                    orderable: false,
                    className: "text-center max-w-min min-w-max",
                    render: function (data, type, row, meta) {
                        return `
                            <a href="${panelUrl}/urun/duzenle/${row.id}" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                            <a href="javascript:void(0);" class="bs-tooltip tablo-satir-sil" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                        `;
                    },
                },
            ],
            buttons: {
                print: {
                    dosyaAdi: "urun-liste",
                    baslik: "Ürün Liste",
                    tabloSutun: [0, 1, 2, 3, 4],
                },

                excel: {
                    dosyaAdi: "urun-liste",
                    baslik: "Ürün Liste",
                    tabloSutun: [0, 1, 2, 3, 4],
                },

                pdf: {
                    dosyaAdi: "urun-liste",
                    baslik: "Ürün Liste",
                    tabloSutun: [0, 1, 2, 3, 4],
                },
            },
        });





    };

    const UrunTableKontrol = function () {
        document
            .querySelector("#urunDataTable")
            .addEventListener("click", (e) => {
                if (e.target.closest(".tablo-satir-sil")) {
                    handleDelete(e);
                }
            });

        urunDataTable.on('row-reorder', function (e, details, changes) {
            const sortedSiraNo = details
                .map(row => urunDataTable.row(row.node).data().sira_no)
                .sort((a, b) => a - b);

            const urunler = details.map((row, index) => {
                return {
                    id: urunDataTable.row(row.node).data().id,
                    sira: sortedSiraNo[index]
                };
            });

            if (urunler.length > 0) {
                Swall({
                    icon: "success",
                    baslik: "Sıralama Değiştiriyor",
                    onayButonDurum: false
                });

                axios.post(`${panelUrl}/urun/siralamaduzenle`, { urunler: urunler })
                    .then(function (response) {
                        setTimeout(() => {
                            Swall({
                                icon: "success",
                                baslik: "Sıralama Değiştirildi",
                            }); 
                        }, 1000);

                        urunDataTable.draw();
                    })
                    .catch(function (error) {
                        console.error('Sıralama güncelleme hatası:', error);
                    });
            }

        });


        $(".tablo-filtre").change(function (e) {
            e.preventDefault();
            urunDataTable.draw();
        });

        $(".tablo-ara").keyup(function (e) {
            e.preventDefault();
            urunDataTable.draw();
        });

    }

    const handleDelete = (e) => {
        e.preventDefault();
        const parent = e.target.closest("tr");
        const data = urunDataTable.row($(parent)).data();

        Swall({
            icon: "warning",
            icerik: "Ürün Silinicek Onaylıyormusunuz!",
            iptalButonDurum: true,
        }).then((result) => {
            if (result.value) {
                axios
                    .post(`${panelUrl}/urun/sil/${data.id}`)
                    .then((response) => {
                        Swall({
                            icon: "success",
                            icerik: response.data.mesaj,
                            onayButonİcerik: "Tamam!",
                        }).then(() => {
                            urunDataTable.draw();
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
    };


    return {
        init: function () {
            UrunTable();
            UrunTableKontrol();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunIndex.init();
});
