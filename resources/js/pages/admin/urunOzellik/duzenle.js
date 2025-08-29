("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPUrunOzellikForm from "./partials/form.js";

var RPUrunOzellikDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const urunOzellikForm = new RPUrunOzellikForm();

    let FormGonder = function () {
        if (urunOzellikForm.UrunOzellikFormKontrol()) {
            FormGondermeOnay("Ürün Özellik Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ürün Özellik Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI =
                            urunOzellikForm.UrunOzellikVeriler();
                        axios
                            .post(
                                `${panelUrl}/urunozellik/duzenle/${urunOzellikId}`,
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
            $("#urunOzellikBtnCnt").on(
                "click",
                "#urunOzellikBtnSbt",
                function () {
                    return FormGonder();
                }
            );
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunOzellikDuzenle.init();
});
