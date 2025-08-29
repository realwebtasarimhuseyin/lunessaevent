("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPAdminForm from "./partials/form.js";

const RPAdminDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi,Swall } = useReal();
    const adminForm = new RPAdminForm();

    const FormGonder = function () {
        if (adminForm.AdminFormKontrol()) {
            FormGondermeOnay("Admin Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Admin Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = adminForm.AdminVeriler();
                        axios
                            .post(`${panelUrl}/adminyonetim/duzenle/${adminId}`, FormDataAPI, {
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
            $("#adminBtnCnt").on("click", "#adminBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPAdminDuzenle.init();
});
