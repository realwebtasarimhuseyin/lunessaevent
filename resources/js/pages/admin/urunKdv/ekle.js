("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPUrunKdvForm from "./partials/form.js";

const RPUrunKdvEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall,FormSifirla } = useReal();
    const urunKdvForm = new RPUrunKdvForm();

    const FormGonder = function () {
        if (urunKdvForm.UrunKdvFormKontrol()) {
            FormGondermeOnay("Ürün Kdv Oluşturulacak !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Ürün Kdv Oluşturuluyor...");
                    setTimeout(() => {
                        const FormDataAPI = urunKdvForm.UrunKdvVeriler();
                        axios
                            .post(`${panelUrl}/urunkdv/ekle`, FormDataAPI, {
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
            $("#urunKdvBtnCnt").on("click", "#urunKdvBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPUrunKdvEkle.init();
});
