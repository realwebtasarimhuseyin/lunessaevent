("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPSayfaYonetimForm from "./partials/form.js";

const RPSayfaYonetimEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi,Swall } = useReal();
    const sayfaYonetimForm = new RPSayfaYonetimForm();

    const FormGonder = function () {
        if (sayfaYonetimForm.SayfaYonetimFormKontrol()) {
            FormGondermeOnay("Sayfa Yonetim Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Sayfa Yonetim Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = sayfaYonetimForm.SayfaYonetimVeriler();
                        axios
                            .post(`${panelUrl}/sayfayonetim/duzenle/${slug}`, FormDataAPI, {
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
            $("#sayfaYonetimBtnCnt").on("click", "#sayfaYonetimBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPSayfaYonetimEkle.init();
});
