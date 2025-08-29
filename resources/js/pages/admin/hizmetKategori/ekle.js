("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPHizmetKategoriForm from "./partials/form.js";

var RPHizmetKategoriEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const hizmetKategoriForm = new RPHizmetKategoriForm();

    let FormGonder = function () {
        if (hizmetKategoriForm.HizmetKategoriFormKontrol()) {
            FormGondermeOnay("Hizmet Kategori Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Hizmet Kategori Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = hizmetKategoriForm.HizmetKategoriVeriler();
                        axios
                            .post(`${panelUrl}/hizmetkategori/ekle`, FormDataAPI, {
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
            $("#hizmetKategoriBtnCnt").on("click", "#hizmetKategoriBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPHizmetKategoriEkle.init();
});
