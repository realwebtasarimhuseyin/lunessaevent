("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPMarkaForm from "./partials/form.js";

const RPMarkaDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const markaForm = new RPMarkaForm();

    const FormGonder = function () {
        if (markaForm.MarkaFormKontrol()) {
            FormGondermeOnay("Marka Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Marka Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = markaForm.MarkaVeriler();
                        axios
                            .post(`${panelUrl}/marka/duzenle/${markaId}`, FormDataAPI, {
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
            $("#markaBtnCnt").on("click", "#markaBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPMarkaDuzenle.init();
});
