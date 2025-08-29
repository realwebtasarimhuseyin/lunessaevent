("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPKuponForm from "./partials/form.js";

const RPKuponEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const kuponForm = new RPKuponForm();

    const FormGonder = function () {
        if (kuponForm.KuponFormKontrol()) {
            FormGondermeOnay("Kupon Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Kupon Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = kuponForm.KuponVeriler();
                        axios
                            .post(`${panelUrl}/kupon/duzenle/${kuponId}`, FormDataAPI, {
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
            $("#kuponBtnCnt").on("click", "#kuponBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPKuponEkle.init();
});
