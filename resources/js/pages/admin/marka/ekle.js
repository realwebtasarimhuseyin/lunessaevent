("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPMarkaForm from "./partials/form.js";

const RPMarkaEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall, FormSifirla } = useReal();
    const markaForm = new RPMarkaForm();

    const FormGonder = function () {
        if (markaForm.MarkaFormKontrol()) {
            FormGondermeOnay("Marka Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Marka Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = markaForm.MarkaVeriler();
                        axios
                            .post(`${panelUrl}/marka/ekle`, FormDataAPI, {
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
            $("#markaBtnCnt").on("click", "#markaBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPMarkaEkle.init();
});
