"use strict";

import useReal from "../../../script/real.js";

var RPIletisimFormIndex = (function () {
    const { AjaxDataTables, ZamanFormati, Swall } = useReal();
    let iletisimFormDataTable;

    let IletisimFormTable = function () {
        iletisimFormDataTable = AjaxDataTables({
            id: "iletisimFormDataTable",
            ajax: {
                url: `${panelUrl}/iletisimform/liste`,
                data: function (data) {
                    data.ara = ""; /* $("input[name='tablo-ara']").val(); */ // Dinamik olarak ara değerini alır
                },
            },
            sutunlar: [
                { data: "created_at" },
                { data: "isim" },
                { data: "telefon" },
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
                    targets: [4],
                    orderable: false,
                    className: "text-center max-w-min min-w-max",
                    render: function (data, type, row, meta) {
                        return `

                            <a href="${panelUrl}/iletisimform/detay/${row.id}" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                            <a href="javascript:void(0);" class="bs-tooltip tablo-satir-sil" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                        
                        `;
                    },
                },
            ],
            buttons: {
                print: {
                    dosyaAdi: "iletisimForm-liste",
                    baslik: "IletisimForm Liste",
                    tabloSutun: [0, 1, 2, 3],
                },

                excel: {
                    dosyaAdi: "iletisimForm-liste",
                    baslik: "IletisimForm Liste",
                    tabloSutun: [0, 1, 2, 3],
                },

                pdf: {
                    dosyaAdi: "iletisimForm-liste",
                    baslik: "IletisimForm Liste",
                    tabloSutun: [0, 1, 2, 3],
                },
            },
        });

    };

    const IletisimFormTableKontrol = function () {
        document
            .querySelector("#iletisimFormDataTable")
            .addEventListener("click", (e) => {
                if (e.target.closest(".tablo-satir-sil")) {
                    handleDelete(e);
                }
            });
    }

    const handleDelete = (e) => {
        e.preventDefault();
        const parent = e.target.closest("tr");
        const data = iletisimFormDataTable.row($(parent)).data();

        Swall({
            icon: "warning",
            icerik: "Iletisim Form Silinicek Onaylıyormusunuz!",
            iptalButonDurum: true,
        }).then((result) => {
            if (result.value) {
                axios
                    .post(`${panelUrl}/iletisimform/sil/${data.id}`)
                    .then((response) => {
                        Swall({
                            icon: "success",
                            icerik: response.data.mesaj,
                            onayButonİcerik: "Tamam!",
                        }).then(() => {
                            iletisimFormDataTable.draw();
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
            IletisimFormTable();
            IletisimFormTableKontrol();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPIletisimFormIndex.init();
});
