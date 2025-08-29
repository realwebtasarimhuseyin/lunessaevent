("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPProjeKategoriForm from "./partials/form.js";

var RPProjeKategoriDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const projeKategoriForm = new RPProjeKategoriForm();

    let FormGonder = function () {
        if (projeKategoriForm.ProjeKategoriFormKontrol()) {
            FormGondermeOnay("Proje Kategori Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Proje Kategori Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = projeKategoriForm.ProjeKategoriVeriler();
                        axios
                            .post(`${panelUrl}/projekategori/duzenle/${projeKategoriId}`, FormDataAPI, {
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
            $("#projeKategoriBtnCnt").on("click", "#projeKategoriBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPProjeKategoriDuzenle.init();
});
