("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPYetkiForm from "./partials/form.js";

const RPYetkiEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall, FormSifirla } = useReal();
    const yetkiForm = new RPYetkiForm();

    const FormGonder = function () {
        if (yetkiForm.YetkiFormKontrol()) {
            FormGondermeOnay("Yetki Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Yetki Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = yetkiForm.YetkiVeriler();
                        axios
                            .post(`${panelUrl}/yetki/ekle`, FormDataAPI, {
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
            $("#yetkiBtnCnt").on("click", "#yetkiBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPYetkiEkle.init();
});
