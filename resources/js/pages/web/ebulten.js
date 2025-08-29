("use strict");

import axios from "axios";
import useReal from "../../script/real.js";

var RPEBulten = (function () {

    const { FormTamamlandi, Swall } = useReal();

    let EBultenForm = function () {

        let formData = new FormData();

        let FormValues = {
            eposta: $("#EBultenForm #ebulten-eposta").val(),
        };

        formData.append("eposta", FormValues.eposta);

        setTimeout(() => {
            axios
                .post(`${appUrl}/ebulten/ekle`, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    FormTamamlandi(response.data.mesaj);
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
                        icerik: icerik ,
                        onayButonİcerik: "Tamam"
                    });
                });
        }, 500);
    };

    return {
        init: function () {
            $("#ebulten-abone-btn").on("click", function () {
                return EBultenForm();
            });
            // $(".ebulten-abone-btn").on("click", function () {
            //     return EBultenForm();
            // });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPEBulten.init();
});
