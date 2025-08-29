
("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPKatalogForm from "./partials/form.js";

var RPKatalogDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const katalogForm = new RPKatalogForm();

    let FormGonder = function () {
        if (katalogForm.KatalogFormKontrol()) {
            FormGondermeOnay("Katalog Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Katalog Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = katalogForm.KatalogVeriler();
                        axios
                            .post(`${panelUrl}/katalog/duzenle/${katalogId}`, FormDataAPI, {
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
            $("#katalogBtnCnt").on("click", "#katalogBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPKatalogDuzenle.init();
});
