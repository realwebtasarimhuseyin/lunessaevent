("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";

var RPSifreSifirlaTalep = (function () {

    const { FormTamamlandi, Swall,FormSifirla } = useReal();

    let SifreSifirlaTalepForm = function () {

        let formData = new FormData();
        const action = $(`#sifreSifirlaTalepForm`).attr("action");

        let FormValues = {
            eposta: $("#sifreSifirlaTalepForm #eposta").val(),
        };

        formData.append("eposta", FormValues.eposta);

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
            $("#sifre-sifirla-talep-btn").on("click", function () {
                return SifreSifirlaTalepForm();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPSifreSifirlaTalep.init();
});
