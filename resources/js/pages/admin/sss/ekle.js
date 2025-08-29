("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPSSSForm from "./partials/form.js";

const RPSSSEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall, FormSifirla } = useReal();
    const sssForm = new RPSSSForm();

    const FormGonder = function () {

        if (sssForm.SSSFormKontrol()) {
            FormGondermeOnay("SSS Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("SSS Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = sssForm.SSSVeriler();
                        axios
                            .post(`${panelUrl}/sss/ekle`, FormDataAPI, {
                                headers: {
                                    "Content-Type": "multipart/form-data",
                                },
                            })
                            .then((response) => {
                                FormTamamlandi(response.data.mesaj);
                                FormSifirla();
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
            $("#sssBtnCnt").on("click", "#sssBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPSSSEkle.init();
});
