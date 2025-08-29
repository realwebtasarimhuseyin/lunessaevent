("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPDovizYonetimForm from "./partials/form.js";

const RPDovizYonetimEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const dovizYonetimForm = new RPDovizYonetimForm();

    const FormGonder = function () {
        if (dovizYonetimForm.DovizYonetimFormKontrol()) {
            FormGondermeOnay("Doviz Yonetim Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Doviz Yonetim Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = dovizYonetimForm.DovizYonetimVeriler();
                        axios
                            .post(`${panelUrl}/dovizyonetim/duzenle/${slug}`, FormDataAPI, {
                                headers: {
                                    "Content-Type": "multipart/form-data",
                                },
                            })
                            .then((response) => {
                                FormTamamlandi(response.data.mesaj);
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
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
            $("#dovizYonetimBtnCnt").on("click", "#dovizYonetimBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPDovizYonetimEkle.init();
});
