("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPYetkiForm from "./partials/form.js";

const RPYetkiDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi,Swall } = useReal();
    const yetkiForm = new RPYetkiForm();

    const FormGonder = function () {
        if (yetkiForm.YetkiFormKontrol()) {
            FormGondermeOnay("Yetki Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Yetki Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = yetkiForm.YetkiVeriler();
                        axios
                            .post(`${panelUrl}/yetki/duzenle/${yetkiId}`, FormDataAPI, {
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
                    }, 500);
                }
            });
        }
    };

    return {
        init: function () {
            $("#yetkiBtnCnt").on("click", "#yetkiBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPYetkiDuzenle.init();
});
