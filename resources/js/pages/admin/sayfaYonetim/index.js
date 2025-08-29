"use strict";

import useReal from "../../../script/real.js";

const RPSayfaYonetimIndex = (function () {
    const { AjaxDataTables, ZamanFormati, Swall } = useReal();
    let sayfaYonetimDataTable;

    const SayfaYonetimTable = function () {
        sayfaYonetimDataTable = AjaxDataTables({
            id: "sayfaYonetimDataTable",
            ajax: {
                url: `${panelUrl}/sayfayonetim/liste`,
                data: function (data) {
                    data.ara = ""; /* $("input[name='tablo-ara']").val(); */ // Dinamik olarak ara değerini alır
                },
            },
            sutunlar: [
                { data: "baslik" },
                { data: "durum" },
                { data: null },
            ],
            sutunTanim: [
                {
                    targets: [1],
                    render: function (data, type, row, meta) {
                        return `<span>${data == 1 ? "Aktif" : "Pasif"}</span>`;
                    },
                },
                {
                    targets: [2],
                    orderable: false,
                    className: "text-center max-w-min min-w-max",
                    render: function (data, type, row, meta) {
                        return `
                           
                            <a href="${panelUrl}/sayfayonetim/duzenle/${row.slug}" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                            <a href="javascript:void(0);" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                        
                       `;
                    },
                },
            ],
            buttons: {
                print: {
                    dosyaAdi: "sayfaYonetim-liste",
                    baslik: "Sayfa Yonetim Liste",
                    tabloSutun: [1, 2],
                },

                excel: {
                    dosyaAdi: "sayfaYonetim-liste",
                    baslik: "Sayfa Yonetim Liste",
                    tabloSutun: [1, 2],
                },

                pdf: {
                    dosyaAdi: "sayfaYonetim-liste",
                    baslik: "Sayfa Yonetim Liste",
                    tabloSutun: [1, 2],
                },
            },
        });

    };

    const SayfaYonetimTableKontrol = function () {

        sayfaYonetimDataTable.on('row-reorder', function (e, details, changes) {
            const sortedSiraNo = details
                .map(row => sayfaYonetimDataTable.row(row.node).data().sira_no)
                .sort((a, b) => a - b);

            const sayfayonetimler = details.map((row, index) => {
                return {
                    id: sayfaYonetimDataTable.row(row.node).data().id,
                    sira: sortedSiraNo[index]
                };
            });

            if (sayfayonetimler.length > 0) {
                Swall({
                    icon: "success",
                    baslik: "Sıralama Değiştiriyor",
                    onayButonDurum: false
                });

                axios.post(`${panelUrl}/sayfayonetim/siralamaduzenle`, { sayfayonetimler: sayfayonetimler })
                    .then(function (response) {
                        setTimeout(() => {
                            Swall({
                                icon: "success",
                                baslik: "Sıralama Değiştirildi",
                            });
                        }, 1000);

                        sayfaYonetimDataTable.draw();
                    })
                    .catch(function (error) {
                        console.error('Sıralama güncelleme hatası:', error);
                    });
            }

        });
    }

    return {
        init: function () {
            SayfaYonetimTable();
            SayfaYonetimTableKontrol();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPSayfaYonetimIndex.init();
});
