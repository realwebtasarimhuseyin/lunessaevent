"use strict";

import useReal from "../../../script/real.js";

const RPBultenIndex = (function () {
    const { AjaxDataTables, ZamanFormati, Swall } = useReal();
    let bultenDataTable;

    const BultenTable = function () {
        bultenDataTable = AjaxDataTables({
            id: "bultenDataTable",
            ajax: {
                url: `${panelUrl}/bulten/liste`,
                data: function (data) {
                    data.ara = ""; 
                },
            },
            sutunlar: [
                { data: "created_at" },
                { data: "eposta" },
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
                    targets: [2],
                    orderable: false,
                    className: "text-center max-w-min min-w-max",
                    render: function (data, type, row, meta) {
                        return `
                            <a href="javascript:void(0);" class="bs-tooltip tablo-satir-sil" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                        `;
                    },
                },
            ],
            buttons: {
                print: {
                    dosyaAdi: "bulten-liste",
                    baslik: "Bülten Liste",
                    tabloSutun: [0, 1],
                },

                excel: {
                    dosyaAdi: "bulten-liste",
                    baslik: "Bülten Liste",
                    tabloSutun: [0, 1],
                },

                pdf: {
                    dosyaAdi: "bulten-liste",
                    baslik: "Bülten Liste",
                    tabloSutun: [0, 1],
                },
            },
        });

        multiCheck(bultenDataTable);
    };

    const BultenTableKontrol = function () {
        document
            .querySelector("#bultenDataTable")
            .addEventListener("click", (e) => {
                if (e.target.closest(".tablo-satir-sil")) {
                    handleDelete(e);
                }
            });
    }

    const handleDelete = (e) => {
        e.preventDefault();
        const parent = e.target.closest("tr");
        const data = bultenDataTable.row($(parent)).data();

        Swall({
            icon: "warning",
            icerik: "Bülten Silinicek Onaylıyormusunuz!",
            iptalButonDurum: true,
        }).then((result) => {
            if (result.value) {
                axios
                    .post(`${panelUrl}/bulten/sil/${data.id}`)
                    .then((response) => {
                        Swall({
                            icon: "success",
                            icerik: response.data.mesaj,
                            onayButonİcerik: "Tamam!",
                        }).then(() => {
                            bultenDataTable.draw();
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
            BultenTable();
            BultenTableKontrol();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPBultenIndex.init();
});
