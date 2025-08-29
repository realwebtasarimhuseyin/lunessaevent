("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPUrunVaryantOzellikForm from "./partials/form.js";

const RPUrunVaryantOzellikDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const urunVaryantOzellikForm = new RPUrunVaryantOzellikForm();

    const FormGonder = function () {
        if (urunVaryantOzellikForm.UrunVaryantOzellikFormKontrol()) {
            FormGondermeOnay("Ürün Varyant Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ürün Varyant Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI =
                            urunVaryantOzellikForm.UrunVaryantOzellikVeriler();
                        axios
                            .post(
                                `${panelUrl}/urunvaryantozellik/duzenle/${urunVaryantOzellikId}`,
                                FormDataAPI,
                                {
                                    headers: {
                                        "Content-Type": "multipart/form-data",
                                    },
                                }
                            )
                            .then((response) => {
                                FormTamamlandi(response.data.mesaj);
                                return true;
                            }).catch(function (error) {
                                Swall({
                                    icon: "error",
                                    icerik: "Lütfen tüm alanları doldurup tekrar deneyiniz !",
                                    onayButonİcerik: "Tamam"
                                });
                            });
                    }, 500);
                }
            });
        }
    };

    return {
        init: function () {
            $("#urunVaryantOzellikBtnCnt").on(
                "click",
                "#urunVaryantOzellikBtnSbt",
                function () {
                    return FormGonder();
                }
            );
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunVaryantOzellikDuzenle.init();
});
