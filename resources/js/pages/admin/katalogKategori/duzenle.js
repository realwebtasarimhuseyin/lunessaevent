("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPKatalogKategoriForm from "./partials/form.js";

const RPKatalogKategoriDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const katalogKategoriForm = new RPKatalogKategoriForm();

    const FormGonder = function () {
        if (katalogKategoriForm.KatalogKategoriFormKontrol()) {
            FormGondermeOnay("Katalog Kategori Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Katalog Kategori Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = katalogKategoriForm.KatalogKategoriVeriler();
                        axios
                            .post(`${panelUrl}/katalogkategori/duzenle/${katalogKategoriId}`, FormDataAPI, {
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
            $("#katalogKategoriBtnCnt").on("click", "#katalogKategoriBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPKatalogKategoriDuzenle.init();
});
