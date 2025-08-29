("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPAyarForm from "./partials/form.js";

const RPAyarDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const ayarForm = new RPAyarForm();

    const FormGonder = function () {
        if (ayarForm.AyarFormKontrol()) {
            FormGondermeOnay("Ayar Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ayar Düzenleniyor...");
                    const FormDataAPI = ayarForm.AyarVeriler();
                    axios
                        .post(`${panelUrl}/ayar/duzenle`, FormDataAPI, {
                            headers: {
                                "Content-Type": "multipart/form-data",
                            },
                        })
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
                }
            });
        }
    };

    return {
        init: function () {
            $("#ayarBtnCnt").on("click", "#ayarBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPAyarDuzenle.init();
});
