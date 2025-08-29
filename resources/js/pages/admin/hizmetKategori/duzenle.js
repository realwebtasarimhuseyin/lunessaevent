("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPHizmetKategoriForm from "./partials/form.js";

var RPHizmetKategoriDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const hizmetKategoriForm = new RPHizmetKategoriForm();

    let FormGonder = function () {
        if (hizmetKategoriForm.HizmetKategoriFormKontrol()) {
            FormGondermeOnay("Hizmet Kategori Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Hizmet Kategori Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = hizmetKategoriForm.HizmetKategoriVeriler();
                        axios
                            .post(`${panelUrl}/hizmetkategori/duzenle/${hizmetKategoriId}`, FormDataAPI, {
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
            $("#hizmetKategoriBtnCnt").on("click", "#hizmetKategoriBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPHizmetKategoriDuzenle.init();
});
