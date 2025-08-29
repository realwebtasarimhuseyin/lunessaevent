("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPKullaniciForm from "./partials/form.js";

var RPKullaniciDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const kullaniciForm = new RPKullaniciForm();

    let FormGonder = function () {
        if (kullaniciForm.KullaniciFormKontrol()) {
            FormGondermeOnay("Kullanici Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Kullanici Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = kullaniciForm.KullaniciVeriler();
                        axios
                            .post(`${panelUrl}/kullanici/duzenle/${kullaniciId}`, FormDataAPI, {
                                headers: {
                                    "Content-Type": "multipart/form-data",
                                },
                            })
                            .then((response) => {
                                FormTamamlandi(response.data.mesaj);
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
            $("#kullaniciBtnCnt").on("click", "#kullaniciBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPKullaniciDuzenle.init();
});
