"use strict";

import useReal from "../../../script/real.js";

const RPDovizYonetimIndex = (function () {
    const { AjaxDataTables, ZamanFormati } = useReal();
    let dovizYonetimDataTable;

    const DovizYonetimTable = function () {
        dovizYonetimDataTable = AjaxDataTables({
            id: "dovizYonetimDataTable",
            ajax: {
                url: `${panelUrl}/dovizyonetim/liste`,
                data: function (data) {
                    data.ara = ""; /* $("input[name='tablo-ara']").val(); */ // Dinamik olarak ara değerini alır
                },
            },
            sutunlar: [
                { data: null },
                { data: "doviz_slug" },
                { data: null },
            ],

            sutunTanim: [
                {
                    targets: 0,
                    width: "30px",
                    className: "",
                    orderable: !1,
                    render: function (data, type, row, meta) {
                        return `
                    <div class="form-check form-check-primary d-block new-control">
                        <input class="form-check-input child-chk" type="checkbox" id="form-check-default">
                    </div>`;
                    },
                },
             
                {
                    targets: [2],
                    orderable: false,
                    className: "text-center max-w-min min-w-max",
                    render: function (data, type, row, meta) {
                        return `
                           
                            <a href="${panelUrl}/dovizyonetim/duzenle/${row.doviz_slug}" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-8 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                            <a href="javascript:void(0);" class="bs-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-8 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                        
                       `;
                    },
                },
            ],
            buttons: {
                print: {
                    dosyaAdi: "dovizYonetim-liste",
                    baslik: "Döviz Yonetim Liste",
                    tabloSutun: [1, 2],
                },

                excel: {
                    dosyaAdi: "dovizYonetim-liste",
                    baslik: "Döviz Yonetim Liste",
                    tabloSutun: [1, 2],
                },

                pdf: {
                    dosyaAdi: "dovizYonetim-liste",
                    baslik: "Döviz Yonetim Liste",
                    tabloSutun: [1, 2],
                },
            },
        });

        multiCheck(dovizYonetimDataTable);
    };

    return {
        init: function () {
            DovizYonetimTable();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPDovizYonetimIndex.init();
});
