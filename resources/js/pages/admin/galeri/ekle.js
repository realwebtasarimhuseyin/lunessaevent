("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPGaleriForm from "./partials/form.js";

const RPGaleriEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall, FormSifirla } = useReal();
    const galeriForm = new RPGaleriForm();

    const FormGonder = function () {
        if (galeriForm.GaleriFormKontrol()) {
            FormGondermeOnay("Galeri Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Galeri Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = galeriForm.GaleriVeriler();
                        axios
                            .post(`${panelUrl}/galeri/ekle`, FormDataAPI, {
                                headers: {
                                    "Content-Type": "multipart/form-data",
                                },
                            })
                            .then((response) => {
                                FormTamamlandi(response.data.mesaj);
                                FormSifirla();
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
            $("#galeriBtnCnt").on("click", "#galeriBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPGaleriEkle.init();
});
