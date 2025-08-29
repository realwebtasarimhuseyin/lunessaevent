"use strict";

import useReal from "../../../script/real.js";

const RPKuponIndex = (function () {
    const { AjaxDataTables, ZamanFormati, Swall } = useReal();
    let kuponDataTable;

    const KuponTable = function () {
        kuponDataTable = AjaxDataTables({
            id: "kuponDataTable",
            ajax: {
                url: `${panelUrl}/kupon/liste`,
                data: function (data) {
                    data.ara = ""; /* $("input[name='tablo-ara']").val(); */ // Dinamik olarak ara değerini alır
                },
            },
            sutunlar: [
                { data: "created_at" },
                { data: "kod" },
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
                    targets: [2, 3],
                    render: function (data, type, row, meta) {
                        return `<span>${ZamanFormati(data, 'date')}</span>`;
                    },
                },
                {
                    targets: [4],
                    orderable: false,
                    className: "text-center max-w-min min-w-max",
                    render: function (data, type, row, meta) {
                        return `
                            <a href="${panelUrl}/kupon/duzenle/${row.id}" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                            <a href="javascript:void(0);" class="bs-tooltip tablo-satir-sil" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                        `;
                    },
                },
            ],
            buttons: {
                print: {
                    dosyaAdi: "kupon-liste",
                    baslik: "Kupon Liste",
                    tabloSutun: [0, 1, 2, 3, 4],
                },

                excel: {
                    dosyaAdi: "kupon-liste",
                    baslik: "Kupon Liste",
                    tabloSutun: [0, 1, 2, 3, 4],
                },

                pdf: {
                    dosyaAdi: "kupon-liste",
                    baslik: "Kupon Liste",
                    tabloSutun: [0, 1, 2, 3, 4],
                },
            },
        });

        multiCheck(kuponDataTable);
    };

    const KuponTableKontrol = function () {
        document
            .querySelector("#kuponDataTable")
            .addEventListener("click", (e) => {
                if (e.target.closest(".tablo-satir-sil")) {
                    handleDelete(e);
                }
            });
    }

    const handleDelete = (e) => {
        e.preventDefault();
        const parent = e.target.closest("tr");
        const data = kuponDataTable.row($(parent)).data();

        Swall({
            icon: "warning",
            icerik: "Kupon Silinicek Onaylıyormusunuz!",
            iptalButonDurum: true,
        }).then((result) => {
            if (result.value) {
                axios
                    .post(`${panelUrl}/kupon/sil/${data.id}`)
                    .then((response) => {
                        Swall({
                            icon: "success",
                            icerik: response.data.mesaj,
                            onayButonİcerik: "Tamam!",
                        }).then(() => {
                            kuponDataTable.draw();
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
            KuponTable();
            KuponTableKontrol();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPKuponIndex.init();
});
