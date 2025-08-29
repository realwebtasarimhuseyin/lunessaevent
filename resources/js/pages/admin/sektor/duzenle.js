("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPSektorlerForm from "./partials/form.js";

var RPSektorlerEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const sektorlerForm = new RPSektorlerForm();

    let FormGonder = function () {
        if (sektorlerForm.SektorlerFormKontrol()) {
            FormGondermeOnay("Sektorler Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Sektorler Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = sektorlerForm.SektorlerVeriler();
                        axios
                            .post(`${panelUrl}/sektorler/duzenle/${sektorlerId}`, FormDataAPI, {
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
            $("#sektorlerBtnCnt").on("click", "#sektorlerBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPSektorlerEkle.init();
});
