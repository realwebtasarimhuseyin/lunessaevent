("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPUrunAltKategoriForm from "./partials/form.js";

const RPUrunAltKategoriEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall, FormSifirla } = useReal();
    const urunAltKategoriForm = new RPUrunAltKategoriForm();

    const FormGonder = function () {
        if (urunAltKategoriForm.UrunAltKategoriFormKontrol()) {
            FormGondermeOnay("Ürün Alt Kategori Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ürün Alt Kategori Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = urunAltKategoriForm.UrunAltKategoriVeriler();
                        axios
                            .post(`${panelUrl}/urunaltkategori/ekle`, FormDataAPI, {
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
            $("#urunAltKategoriBtnCnt").on("click", "#urunAltKategoriBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunAltKategoriEkle.init();
});
