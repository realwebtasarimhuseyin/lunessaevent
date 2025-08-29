("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPUrunVaryantForm from "./partials/form.js";

const RPUrunVaryantEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall, FormSifirla } = useReal();
    const urunVaryantForm = new RPUrunVaryantForm();

    const FormGonder = function () {
        if (urunVaryantForm.UrunVaryantFormKontrol()) {
            FormGondermeOnay("Ürün Varyant Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ürün Varyant Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = urunVaryantForm.UrunVaryantVeriler();
                        axios
                            .post(`${panelUrl}/urunvaryant/ekle`, FormDataAPI, {
                                headers: {
                                    "Content-Type": "multipart/form-data",
                                },
                            })
                            .then((response) => {
                                FormTamamlandi(response.data.mesaj);
                                FormSifirla();
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
            $("#urunVaryantBtnCnt").on("click", "#urunVaryantBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunVaryantEkle.init();
});
