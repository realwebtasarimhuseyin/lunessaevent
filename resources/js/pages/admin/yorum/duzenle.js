("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPYorumForm from "./partials/form.js";

const RPYorumEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const yorumForm = new RPYorumForm();

    const FormGonder = function () {
        if (yorumForm.YorumFormKontrol()) {
            FormGondermeOnay("Yorum Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Yorum Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = yorumForm.YorumVeriler();
                        axios
                            .post(`${panelUrl}/yorum/duzenle/${yorumId}`, FormDataAPI, {
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
            $("#yorumBtnCnt").on("click", "#yorumBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPYorumEkle.init();
});
