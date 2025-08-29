"use strict";

import useReal from "../../../script/real.js";

const RPSiparisIndex = (function () {
    const { AjaxDataTables, ZamanFormati, Swall } = useReal();
    let siparisDataTable;

    const SiparisTable = function () {
        siparisDataTable = AjaxDataTables({
            id: "siparisDataTable",
            ajax: {
                url: `${panelUrl}/siparis/liste`,
                data: function (data) {
                    data.ara = ""; /* $("input[name='tablo-ara']").val(); */ // Dinamik olarak ara değerini alır
                },
            },
            sutunlar: [
                { data: "created_at" },
                { data: "kod" },
                { data: "kullanici" },
                { data: "toplam_tutar" },
                { data: "durum" },
                { data: null },
            ],
            order: [
                [0, 'desc']
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
                    render: function (data, type, row, meta) {
                        return `<span>${row.kullanici_id > 0 ? row.kullanici.isim_soyisim : "YOK"}</span>`;
                    },
                },

                {
                    targets: [3],
                    render: function (data, type, row, meta) {
                        return `<span>${data}</span>`;
                    },
                },

                {
                    targets: [4],
                    render: function (data, type, row, meta) {
                        return `<span>${data}</span>`;
                    },
                },

                {
                    targets: [5],
                    orderable: false,
                    className: "text-center max-w-min min-w-max",
                    render: function (data, type, row, meta) {
                        return `

                            <a href="${panelUrl}/siparis/detay/${row.id}" class="bs-tooltip"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                         
                        `;
                    },
                },
            ],
            buttons: {
                print: {
                    dosyaAdi: "siparis-liste",
                    baslik: "Siparis Liste",
                    tabloSutun: [0, 1, 2, 3],
                },

                excel: {
                    dosyaAdi: "siparis-liste",
                    baslik: "Siparis Liste",
                    tabloSutun: [0, 1, 2, 3],
                },

                pdf: {
                    dosyaAdi: "siparis-liste",
                    baslik: "Siparis Liste",
                    tabloSutun: [0, 1, 2, 3],
                },
            },
        });

        multiCheck(siparisDataTable);
    };

    const SiparisTableKontrol = function () {
        document
            .querySelector("#siparisDataTable")
            .addEventListener("click", (e) => {
                if (e.target.closest(".tablo-satir-sil")) {
                    handleDelete(e);
                }
            });
    }

    const handleDelete = (e) => {
        e.preventDefault();
        const parent = e.target.closest("tr");
        const data = siparisDataTable.row($(parent)).data();

        Swall({
            icon: "warning",
            icerik: "Siparis Silinicek Onaylıyormusunuz!",
            iptalButonDurum: true,
        }).then((result) => {
            if (result.value) {
                axios
                    .post(`${panelUrl}/siparis/sil/${data.id}`)
                    .then((response) => {
                        Swall({
                            icon: "success",
                            icerik: response.data.mesaj,
                            onayButonİcerik: "Tamam!",
                        }).then(() => {
                            siparisDataTable.draw();
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
            SiparisTable();
            SiparisTableKontrol();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPSiparisIndex.init();
});
