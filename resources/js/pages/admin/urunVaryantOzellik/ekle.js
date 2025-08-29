("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPUrunVaryantOzellikForm from "./partials/form.js";

const RPUrunVaryantOzellikEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall, FormSifirla } = useReal();
    const urunVaryantOzellikForm = new RPUrunVaryantOzellikForm();

    const FormGonder = function () {
        if (urunVaryantOzellikForm.UrunVaryantOzellikFormKontrol()) {
            FormGondermeOnay("Ürün Varyant Ozellik Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ürün Varyant Ozellik Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = urunVaryantOzellikForm.UrunVaryantOzellikVeriler();
                        axios
                            .post(`${panelUrl}/urunvaryantozellik/ekle`, FormDataAPI, {
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
            $("#urunVaryantOzellikBtnCnt").on("click", "#urunVaryantOzellikBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunVaryantOzellikEkle.init();
});
