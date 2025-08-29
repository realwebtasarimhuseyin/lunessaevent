"use strict";

import useReal from "../../../script/real.js";

var RPGaleriIndex = (function () {
    const { AjaxDataTables, ZamanFormati, Swall } = useReal();
    let galeriDataTable;

    let GaleriTable = function () {
        galeriDataTable = AjaxDataTables({
            id: "galeriDataTable",
            ajax: {
                url: `${panelUrl}/galeri/liste`,
                data: function (data) {
                    data.ara = "";
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
                        
                            <a href="${panelUrl}/galeri/duzenle/${row.id}" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                            <a href="javascript:void(0);" class="bs-tooltip tablo-satir-sil" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                        
                            `;
                    },
                },
            ],
            buttons: {
                print: {
                    dosyaAdi: "galeri-liste",
                    baslik: "Galeri Liste",
                    tabloSutun: [0, 1, 2, 3],
                },

                excel: {
                    dosyaAdi: "galeri-liste",
                    baslik: "Galeri Liste",
                    tabloSutun: [0, 1, 2, 3],
                },

                pdf: {
                    dosyaAdi: "galeri-liste",
                    baslik: "Galeri Liste",
                    tabloSutun: [0, 1, 2, 3],
                },
            },
        });

    };

    const GaleriTableKontrol = function () {
        document
            .querySelector("#galeriDataTable")
            .addEventListener("click", (e) => {
                if (e.target.closest(".tablo-satir-sil")) {
                    handleDelete(e);
                }
            });


        galeriDataTable.on('row-reorder', function (e, details, changes) {
            const sortedSiraNo = details
                .map(row => galeriDataTable.row(row.node).data().sira_no) // sira_no değerlerini al
                .sort((a, b) => a - b); // Küçükten büyüğe sırala

            // 2. details.map döngüsünde sıralanmış sira_no değerlerini sırayla ata
            const galeriler = details.map((row, index) => {
                return {
                    id: galeriDataTable.row(row.node).data().id, // ID'yi al
                    sira: sortedSiraNo[index] // Sıralanmış sira_no değerini ata
                };
            });

            if (galeriler.length > 0) {
                Swall({
                    icon: "success",
                    baslik: "Sıralama Değiştiriyor",
                    onayButonDurum: false
                });

                axios.post(`${panelUrl}/galeri/siralamaduzenle`, { galeriler: galeriler })
                    .then(function (response) {
                        setTimeout(() => {
                            Swall({
                                icon: "success",
                                baslik: "Sıralama Değiştirildi",
                            });
                        }, 1000);

                        galeriDataTable.draw();
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
        const data = galeriDataTable.row($(parent)).data();

        Swall({
            icon: "warning",
            icerik: "Galeri Silinicek Onaylıyormusunuz!",
            iptalButonDurum: true,
        }).then((result) => {
            if (result.value) {
                axios
                    .post(`${panelUrl}/galeri/sil/${data.id}`)
                    .then((response) => {
                        Swall({
                            icon: "success",
                            icerik: response.data.mesaj,
                            onayButonİcerik: "Tamam!",
                        }).then(() => {
                            galeriDataTable.draw();
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
            GaleriTable();
            GaleriTableKontrol();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPGaleriIndex.init();
});
