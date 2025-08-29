("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPDuyuruForm from "./partials/form.js";

const RPDuyuruEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const duyuruForm = new RPDuyuruForm();

    const FormGonder = function () {
        if (duyuruForm.DuyuruFormKontrol()) {
            FormGondermeOnay("Duyuru Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Duyuru Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = duyuruForm.DuyuruVeriler();
                        axios
                            .post(`${panelUrl}/duyuru/duzenle/${duyuruId}`, FormDataAPI, {
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
            $("#duyuruBtnCnt").on("click", "#duyuruBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPDuyuruEkle.init();
});
