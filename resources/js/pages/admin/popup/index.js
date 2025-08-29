"use strict";

import useReal from "../../../script/real.js";

const RPPopupIndex = (function () {
    const { AjaxDataTables, ZamanFormati, Swall } = useReal();
    let popupDataTable;

    const PopupTable = function () {
        popupDataTable = AjaxDataTables({
            id: "popupDataTable",
            ajax: {
                url: `${panelUrl}/popup/liste`,
                data: function (data) {
                    data.ara = ""; /* $("input[name='tablo-ara']").val(); */ // Dinamik olarak ara değerini alır
                },
            },
            sutunlar: [
                { data: "sira_no" },
                { data: "created_at" },
                { data: "baslik" },
                { data: "baslangic_tarih" },
                { data: "bitis_tarih" },
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
                    targets: [3, 4],
                    render: function (data, type, row, meta) {
                        return `<span>${ZamanFormati(data, 'date')}</span>`;
                    },
                },

                {
                    targets: [5],
                    orderable: false,
                    className: "text-center max-w-min min-w-max",
                    render: function (data, type, row, meta) {
                        return `
                            <a href="${panelUrl}/popup/duzenle/${row.id}" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                            <a href="javascript:void(0);" class="bs-tooltip tablo-satir-sil" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                        `;
                    },
                },
            ],
            buttons: {
                print: {
                    dosyaAdi: "popup-liste",
                    baslik: "Popup Liste",
                    tabloSutun: [0, 1, 2, 3],
                },

                excel: {
                    dosyaAdi: "popup-liste",
                    baslik: "Popup Liste",
                    tabloSutun: [0, 1, 2, 3],
                },

                pdf: {
                    dosyaAdi: "popup-liste",
                    baslik: "Popup Liste",
                    tabloSutun: [0, 1, 2, 3],
                },
            },
        });

        multiCheck(popupDataTable);
    };

    const PopupTableKontrol = function () {
        document
            .querySelector("#popupDataTable")
            .addEventListener("click", (e) => {
                if (e.target.closest(".tablo-satir-sil")) {
                    handleDelete(e);
                }
            });


        popupDataTable.on('row-reorder', function (e, details, changes) {
            const sortedSiraNo = details
                .map(row => popupDataTable.row(row.node).data().sira_no)
                .sort((a, b) => a - b);

            const popuplar = details.map((row, index) => {
                return {
                    id: popupDataTable.row(row.node).data().id,
                    sira: sortedSiraNo[index]
                };
            });

            if (popuplar.length > 0) {
                Swall({
                    icon: "success",
                    baslik: "Sıralama Değiştiriyor",
                    onayButonDurum: false
                });

                axios.post(`${panelUrl}/popup/siralamaduzenle`, { popuplar: popuplar })
                    .then(function (response) {
                        setTimeout(() => {
                            Swall({
                                icon: "success",
                                baslik: "Sıralama Değiştirildi",
                            });
                        }, 1000);

                        popupDataTable.draw();
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
        const data = popupDataTable.row($(parent)).data();

        Swall({
            icon: "warning",
            icerik: "Popup Silinicek Onaylıyormusunuz!",
            iptalButonDurum: true,
        }).then((result) => {
            if (result.value) {
                axios
                    .post(`${panelUrl}/popup/sil/${data.id}`)
                    .then((response) => {
                        Swall({
                            icon: "success",
                            icerik: response.data.mesaj,
                            onayButonİcerik: "Tamam!",
                        }).then(() => {
                            popupDataTable.draw();
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
            PopupTable();
            PopupTableKontrol();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPPopupIndex.init();
});
