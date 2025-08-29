("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPUrunKategoriForm from "./partials/form.js";

const RPUrunKategoriDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const urunKategoriForm = new RPUrunKategoriForm();

    const FormGonder = function () {
        if (urunKategoriForm.UrunKategoriFormKontrol()) {
            FormGondermeOnay("Ürün Kategori Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ürün Kategori Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = urunKategoriForm.UrunKategoriVeriler();
                        axios
                            .post(`${panelUrl}/urunkategori/duzenle/${urunKategoriId}`, FormDataAPI, {
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
            $("#urunKategoriBtnCnt").on("click", "#urunKategoriBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunKategoriDuzenle.init();
});
