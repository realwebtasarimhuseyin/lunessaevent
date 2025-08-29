("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPUrunVaryantForm from "./partials/form.js";

const RPUrunVaryantDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const urunVaryantForm = new RPUrunVaryantForm();

    const FormGonder = function () {
        if (urunVaryantForm.UrunVaryantFormKontrol()) {
            FormGondermeOnay("Ürün Varyant Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ürün Varyant Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI =
                            urunVaryantForm.UrunVaryantVeriler();
                        axios
                            .post(
                                `${panelUrl}/urunvaryant/duzenle/${urunVaryantId}`,
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
            $("#urunVaryantBtnCnt").on(
                "click",
                "#urunVaryantBtnSbt",
                function () {
                    return FormGonder();
                }
            );
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunVaryantDuzenle.init();
});
