("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPKatalogForm from "./partials/form.js";

var RPKatalogEkle = (function () {
    const {FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall, FormSifirla} = useReal();
    const katalogForm = new RPKatalogForm();

    let FormGonder = function () {
        if (katalogForm.KatalogFormKontrol()) {
            FormGondermeOnay("Katalog Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Katalog Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = katalogForm.KatalogVeriler();
                        axios
                            .post(`${panelUrl}/katalog/ekle`, FormDataAPI, {
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
        } else {
            console.log("boş alanar mevcut")
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
    RPKatalogEkle.init();
});
