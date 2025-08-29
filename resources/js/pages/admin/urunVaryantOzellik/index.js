"use strict";

import useReal from "../../../script/real.js";

const RPUrunVaryantOzellikIndex = (function () {
    const { AjaxDataTables, ZamanFormati, Swall } = useReal();
    let urunVaryantOzellikDataTable;

    const UrunVaryantOzellikTable = function () {
        urunVaryantOzellikDataTable = AjaxDataTables({
            id: "urunVaryantOzellikDataTable",
            ajax: {
                url: `${panelUrl}/urunvaryantozellik/liste`,
                data: function (data) {
                    data.ara = "";
                },
            },
            sutunlar: [
                { data: "sira_no" },
                { data: "created_at" },
                { data: "varyant" },
                { data: "isim" },
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
                    targets: [4],
                    orderable: false,
                    className: " max-w-min min-w-max",
                    render: function (data, type, row, meta) {
                        return `
                            <ul class="table-controls text-center">
                                <li><a href="${panelUrl}/urunvaryantozellik/duzenle/${data.id}/" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Düzenle"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></li>
                                <li><a href="javascript:void(0);" class="bs-tooltip tablo-satir-sil" data-bs-toggle="tooltip" data-bs-placement="top" title="Sil"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a></li>
                            </ul>
                        `;
                    },
                },
            ],
            buttons: {
                print: {
                    dosyaAdi: "urunvaryantozellik-liste",
                    baslik: "Ürün Varyant Ozellik Liste",
                    tabloSutun: [1, 2, 3],
                },

                excel: {
                    dosyaAdi: "urunvaryantozellik-liste",
                    baslik: "Ürün Varyant Ozellik Liste",
                    tabloSutun: [1, 2, 3],
                },

                pdf: {
                    dosyaAdi: "urunvaryantozellik-liste",
                    baslik: "Ürün Varyant Ozellik Liste",
                    tabloSutun: [1, 2, 3, 4],
                },
            },
        });
    };

    const UrunVaryantOzellikTableKontrol = function () {
        document
            .querySelector("#urunVaryantOzellikDataTable")
            .addEventListener("click", (e) => {
                if (e.target.closest(".tablo-satir-sil")) {
                    handleDelete(e);
                }
            });

        urunVaryantOzellikDataTable.on('row-reorder', function (e, details, changes) {
            const sortedSiraNo = details
                .map(row => urunVaryantOzellikDataTable.row(row.node).data().sira_no)
                .sort((a, b) => a - b);

            const varyantOzellikler = details.map((row, index) => {
                return {
                    id: urunVaryantOzellikDataTable.row(row.node).data().id,
                    sira: sortedSiraNo[index]
                };
            });

            if (varyantOzellikler.length > 0) {
                Swall({
                    icon: "success",
                    baslik: "Sıralama Değiştiriyor",
                    onayButonDurum: false
                });

                axios.post(`${panelUrl}/urunvaryantozellik/siralamaduzenle`, { varyantOzellikler: varyantOzellikler })
                    .then(function (response) {
                        setTimeout(() => {
                            Swall({
                                icon: "success",
                                baslik: "Sıralama Değiştirildi",
                            });
                        }, 1000);

                        urunVaryantOzellikDataTable.draw();
                    })
                    .catch(function (error) {
                        Swall({
                            icon: "error",
                            baslik: "Sıralama Değiştirilemedi !",
                        });
                        console.error('Sıralama güncelleme hatası:', error);
                    });
            }

        });
    }

    const handleDelete = (e) => {
        e.preventDefault();
        const parent = e.target.closest("tr");
        const data = urunVaryantOzellikDataTable.row($(parent)).data();

        Swall({
            icon: "warning",
            icerik: "Ürün Varyant Özellik Silinicek Onaylıyormusunuz!",
            iptalButonDurum: true,
        }).then((result) => {
            if (result.value) {
                axios
                    .post(`${panelUrl}/urunvaryantozellik/sil/${data.id}`)
                    .then((response) => {
                        Swall({
                            icon: "success",
                            icerik: response.data.mesaj,
                            onayButonİcerik: "Tamam!",
                        }).then(() => {
                            urunVaryantOzellikDataTable.draw();
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
            UrunVaryantOzellikTable();
            UrunVaryantOzellikTableKontrol();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunVaryantOzellikIndex.init();
});
