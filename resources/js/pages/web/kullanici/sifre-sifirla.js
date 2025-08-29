("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";

var RPSifreSifirla = (function () {

    const { FormTamamlandi, Swall, FormSifirla } = useReal();

    let SifreSifirlaForm = function () {

        let formData = new FormData();
        const action = $(`#sifreSifirlaForm`).attr("action");
        const sifre = $("#sifreSifirlaForm #sifre").val();
        const sifreTekrar = $("#sifreSifirlaForm #sifreTekrar").val();

        let FormValues = {
            eposta: eposta,
            token: token,
            sifre: sifre,
            sifre_confirmation: sifreTekrar,
        };

        formData.append("eposta", FormValues.eposta);
        formData.append("token", FormValues.token);
        formData.append("sifre", FormValues.sifre);
        formData.append("sifre_confirmation", FormValues.sifre_confirmation);

        setTimeout(() => {
            axios
                .post(`${action}`, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    FormTamamlandi(response.data.mesaj);
                    FormSifirla();
                    window.location.href = $(`#sifreSifirlaForm`).attr("yonlendirme");
                    return true;
                }).catch(function (error) {
                    var icerik = "";
                    if (aktifDil == "tr") {
                        icerik = "Lütfen tüm alanları doğru bir şekilde doldurup tekrar deneyiniz!"
                    } else {
                        icerik = "Please fill in all fields correctly and try again!"
                    }
                    Swall({
                        icon: "error",
                        icerik: icerik,
                        onayButonİcerik: "Tamam"
                    });
                });
        }, 500);
    };

    return {
        init: function () {
            $("#sifre-sifirla-btn").on("click", function () {
                return SifreSifirlaForm();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPSifreSifirla.init();
});
