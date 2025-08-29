("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPUrunKategoriForm from "./partials/form.js";

const RPUrunKategoriEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall, FormSifirla } = useReal();
    const urunKategoriForm = new RPUrunKategoriForm();

    const FormGonder = function () {
        if (urunKategoriForm.UrunKategoriFormKontrol()) {
            FormGondermeOnay("Ürün Kategori Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ürün Kategori Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = urunKategoriForm.UrunKategoriVeriler();
                        axios
                            .post(`${panelUrl}/urunkategori/ekle`, FormDataAPI, {
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
            $("#urunKategoriBtnCnt").on("click", "#urunKategoriBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunKategoriEkle.init();
});
