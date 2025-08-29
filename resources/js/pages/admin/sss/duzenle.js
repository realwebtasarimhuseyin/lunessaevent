("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPSSSForm from "./partials/form.js";

const RPSSSDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const sssForm = new RPSSSForm();

    const FormGonder = function () {
        if (sssForm.SSSFormKontrol()) {
            FormGondermeOnay("SSS Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("SSS Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = sssForm.SSSVeriler();
                        axios
                            .post(`${panelUrl}/sss/duzenle/${sssId}`, FormDataAPI, {
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
            $("#sssBtnCnt").on("click", "#sssBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPSSSDuzenle.init();
});
