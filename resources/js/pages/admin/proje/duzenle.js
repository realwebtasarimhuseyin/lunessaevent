
("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPProjeForm from "./partials/form.js";

var RPProjeDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const projeForm = new RPProjeForm();

    let FormGonder = function () {
        if (projeForm.ProjeFormKontrol()) {
            FormGondermeOnay("Proje Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Proje Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = projeForm.ProjeVeriler();
                        axios
                            .post(`${panelUrl}/proje/duzenle/${projeId}`, FormDataAPI, {
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
            $("#projeBtnCnt").on("click", "#projeBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPProjeDuzenle.init();
});
