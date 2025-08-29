("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPPopupForm from "./partials/form.js";

const RPPopupEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const popupForm = new RPPopupForm();

    const FormGonder = function () {
        if (popupForm.PopupFormKontrol()) {
            FormGondermeOnay("Popup Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Popup Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = popupForm.PopupVeriler();
                        axios
                            .post(`${panelUrl}/popup/duzenle/${popupId}`, FormDataAPI, {
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
            $("#popupBtnCnt").on("click", "#popupBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPPopupEkle.init();
});
