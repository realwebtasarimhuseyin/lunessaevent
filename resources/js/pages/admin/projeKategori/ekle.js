("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPProjeKategoriForm from "./partials/form.js";

var RPProjeKategoriEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const projeKategoriForm = new RPProjeKategoriForm();

    let FormGonder = function () {
        if (projeKategoriForm.ProjeKategoriFormKontrol()) {
            FormGondermeOnay("Proje Kategori Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Proje Kategori Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = projeKategoriForm.ProjeKategoriVeriler();
                        axios
                            .post(`${panelUrl}/projekategori/ekle`, FormDataAPI, {
                                headers: {
                                    "Content-Type": "multipart/form-data",
                                },
                            })
                            .then((response) => {
                                FormTamamlandi(response.data.mesaj);
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
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
            $("#projeKategoriBtnCnt").on("click", "#projeKategoriBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPProjeKategoriEkle.init();
});
