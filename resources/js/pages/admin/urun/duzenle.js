("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPUrunForm from "./partials/form.js";

const RPUrunDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const urunForm = new RPUrunForm();

    const FormGonder = function () {
        if (urunForm.UrunFormKontrol()) {
            FormGondermeOnay("Ürün Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ürün Düzenleniyor...");
                    const FormDataAPI = urunForm.UrunVeriler();
                    axios
                        .post(`${panelUrl}/urun/duzenle/${urunId}`, FormDataAPI, {
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
            $("#urunBtnCnt").on("click", "#urunBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunDuzenle.init();
});
