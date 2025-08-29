("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPAdminForm from "./partials/form.js";

const RPAdminEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall, FormSifirla } = useReal();
    const adminForm = new RPAdminForm();

    const FormGonder = function () {
        if (adminForm.AdminFormKontrol()) {
            FormGondermeOnay("Admin Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Admin Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = adminForm.AdminVeriler();
                        axios
                            .post(`${panelUrl}/adminyonetim/ekle`, FormDataAPI, {
                                headers: {
                                    "Content-Type": "multipart/form-data",
                                },
                            })
                            .then((response) => {
                                FormTamamlandi(response.data.mesaj);
                                FormSifirla();
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
    RPAdminEkle.init();
});
