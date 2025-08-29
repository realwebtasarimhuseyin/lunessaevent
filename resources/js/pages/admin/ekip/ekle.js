("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPEkipForm from "./partials/form.js";

var RPEkipEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi,Swall } = useReal();
    const ekipForm = new RPEkipForm();

    let FormGonder = function () {
        if (ekipForm.EkipFormKontrol()) {
            FormGondermeOnay("Ekip Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ekip Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = ekipForm.EkipVeriler();
                        axios
                            .post(`${panelUrl}/ekip/ekle`, FormDataAPI, {
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
            $("#ekipBtnCnt").on("click", "#ekipBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPEkipEkle.init();
});