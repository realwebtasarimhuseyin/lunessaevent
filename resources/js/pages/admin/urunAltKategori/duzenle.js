("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPUrunAltKategoriForm from "./partials/form.js";

const RPUrunAltKategoriDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const urunAltKategoriForm = new RPUrunAltKategoriForm();

    const FormGonder = function () {
        if (urunAltKategoriForm.UrunAltKategoriFormKontrol()) {
            FormGondermeOnay("Ürün Kategori Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ürün Kategori Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = urunAltKategoriForm.UrunAltKategoriVeriler();
                        axios
                            .post(`${panelUrl}/urunaltkategori/duzenle/${urunAltKategoriId}`, FormDataAPI, {
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
            $("#urunAltKategoriBtnCnt").on("click", "#urunAltKategoriBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunAltKategoriDuzenle.init();
});
