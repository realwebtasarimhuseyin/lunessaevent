("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPProjeForm from "./partials/form.js";

var RPProjeEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const projeForm = new RPProjeForm();

    let FormGonder = function () {
        if (projeForm.ProjeFormKontrol()) {
            FormGondermeOnay("Proje Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Proje Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = projeForm.ProjeVeriler();
                        axios
                            .post(`${panelUrl}/proje/ekle`, FormDataAPI, {
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
        }else{
            console.log("boş alanar mevcut")
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
    RPProjeEkle.init();
});