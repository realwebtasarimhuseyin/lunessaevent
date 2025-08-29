("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPKatalogKategoriForm from "./partials/form.js";

const RPKatalogKategoriEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall, FormSifirla } = useReal();
    const katalogKategoriForm = new RPKatalogKategoriForm();

    const FormGonder = function () {
        if (katalogKategoriForm.KatalogKategoriFormKontrol()) {
            FormGondermeOnay("Katalog Kategori Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Katalog Kategori Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = katalogKategoriForm.KatalogKategoriVeriler();
                        axios
                            .post(`${panelUrl}/katalogkategori/ekle`, FormDataAPI, {
                                headers: {
                                    "Content-Type": "multipart/form-data",
                                },
                            })
                            .then((response) => {
                                FormTamamlandi(response.data.mesaj);
                                FormSifirla();
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
    RPKatalogKategoriEkle.init();
});
