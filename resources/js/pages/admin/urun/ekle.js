("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPUrunForm from "./partials/form.js";

const RPUrunEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall, FormSifirla } = useReal();
    const urunForm = new RPUrunForm();

    const FormGonder = function () {

        console.log(urunForm.UrunFormKontrol())
        if (urunForm.UrunFormKontrol()) {
            FormGondermeOnay("Ürün Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ürün Oluşturuluyor...");

                    const FormDataAPI = urunForm.UrunVeriler();
                    axios
                        .post(`${panelUrl}/urun/ekle`, FormDataAPI, {
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
                }
            });
        }
    };

    return {
        init: function () {
            $("#urunBtnCnt").on("click", "#urunBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunEkle.init();
});
