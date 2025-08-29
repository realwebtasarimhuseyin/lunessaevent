
"use strict";

import useReal from "../../../script/real.js";

var RPKatalogIndex = (function () {
    const { AjaxDataTables, ZamanFormati, Swall } = useReal();
    let katalogDataTable;

    let KatalogTable = function () {
        katalogDataTable = AjaxDataTables({
            id: "katalogDataTable",
            ajax: {
                url: `${panelUrl}/katalog/liste`,
                data: function (data) {
                    data.ara = ""; /* $("input[name='tablo-ara']").val(); */ // Dinamik olarak ara değerini alır
                },
            },
            sutunlar: [
                { data: "sira_no" },
                { data: "created_at" },
                { data: "baslik" },
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
                            <a href="${panelUrl}/katalog/duzenle/${row.id}" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                            <a href="javascript:void(0);" class="bs-tooltip tablo-satir-sil" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                        `;
                    },
                },
            ],
            buttons: {
                print: {
                    dosyaAdi: "katalog-liste",
                    baslik: "Katalog Liste",
                    tabloSutun: [1, 2, 3],
                },

                excel: {
                    dosyaAdi: "katalog-liste",
                    baslik: "Katalog Liste",
                    tabloSutun: [1, 2, 3],
                },

                pdf: {
                    dosyaAdi: "katalog-liste",
                    baslik: "Katalog Liste",
                    tabloSutun: [1, 2, 3],
                },
            },
        });
    };

    const KatalogTableKontrol = function () {
        document
            .querySelector("#katalogDataTable")
            .addEventListener("click", (e) => {
                if (e.target.closest(".tablo-satir-sil")) {
                    handleDelete(e);
                }
            });


        katalogDataTable.on('row-reorder', function (e, details, changes) {
            const sortedSiraNo = details
                .map(row => katalogDataTable.row(row.node).data().sira_no)
                .sort((a, b) => a - b);

            const katalogler = details.map((row, index) => {
                return {
                    id: katalogDataTable.row(row.node).data().id,
                    sira: sortedSiraNo[index]
                };
            });

            if (katalogler.length > 0) {
                Swall({
                    icon: "success",
                    baslik: "Sıralama Değiştiriyor",
                    onayButonDurum: false
                });

                axios.post(`${panelUrl}/katalog/siralamaduzenle`, { katalogler: katalogler })
                    .then(function (response) {
                        setTimeout(() => {
                            Swall({
                                icon: "success",
                                baslik: "Sıralama Değiştirildi",
                            });
                        }, 1000);

                        katalogDataTable.draw();
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
        const data = katalogDataTable.row($(parent)).data();

        Swall({
            icon: "warning",
            icerik: "Katalog Silinicek Onaylıyormusunuz!",
            iptalButonDurum: true,
        }).then((result) => {
            if (result.value) {
                axios
                    .post(`${panelUrl}/katalog/sil/${data.id}`)
                    .then((response) => {
                        Swall({
                            icon: "success",
                            icerik: response.data.mesaj,
                            onayButonİcerik: "Tamam!",
                        }).then(() => {
                            katalogDataTable.draw();
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
            KatalogTable();
            KatalogTableKontrol();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPKatalogIndex.init();
});
