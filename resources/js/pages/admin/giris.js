"use strict";

import axios from "axios";
import useReal from "../../script/real.js";

const RPGiris = (function () {
    const { FormKontrol, Swall, FormSifirla } = useReal();

    const GirisForm = function () {
        const FormId = "girisForm";
        var girisBtn = document.querySelector("#giris-btn");

        $(girisBtn).click(function (e) {
            e.preventDefault();

            const form = {
                eposta: $("#eposta").val(),
                sifre: $("#sifre").val(),
                remember: false,
            };

            if ($(`#${FormId} #beniHatirla`).is(":checked")) {
                form["remember"] = true;
            } else {
                form["remember"] = false;
            }

            const formKontrol = [
                {
                    label: "Eposta",
                    name: "eposta",
                    value: form.eposta,
                    required: true,
                },
                {
                    label: "Şifre",
                    name: "sifre",
                    value: form.sifre,
                    required: true,
                },
            ];

            const FormKontrolGiris = FormKontrol().validate(FormId, formKontrol);

            if (FormKontrolGiris) {
                axios
                    .post("giris", form)
                    .then((response) => {
                        Swall({
                            icon: "success",
                            tiklamaDurum: false,
                            baslik: response.data.mesaj,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = panelUrl;
                            }
                        });
                    })
                    .catch((error) => {
                        Swall({
                            icon: "error",
                            baslik: error.response.data.mesaj,
                            onayButonİcerik: "Tamam"
                        });
                    });

                FormSifirla();
            }
        });
    };

    return {
        init: function () {
            GirisForm();
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPGiris.init();
});
