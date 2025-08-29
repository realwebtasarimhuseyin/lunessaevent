("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPHizmetForm from "./partials/form.js";

var RPHizmetEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi ,Swall} = useReal();
    const hizmetForm = new RPHizmetForm();

    let FormGonder = function () {
        if (hizmetForm.HizmetFormKontrol()) {
            FormGondermeOnay("Hizmet Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Hizmet Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = hizmetForm.HizmetVeriler();
                        axios
                            .post(`${panelUrl}/hizmet/ekle`, FormDataAPI, {
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
            $("#hizmetBtnCnt").on("click", "#hizmetBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPHizmetEkle.init();
});
