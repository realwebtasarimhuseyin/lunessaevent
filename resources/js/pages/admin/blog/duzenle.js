("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPBlogForm from "./partials/form.js";

const RPBlogDuzenle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi,Swall } = useReal();
    const blogForm = new RPBlogForm();

    const FormGonder = function () {
        if (blogForm.BlogFormKontrol()) {
            FormGondermeOnay("Blog Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Blog Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = blogForm.BlogVeriler();
                        axios
                            .post(`${panelUrl}/blog/duzenle/${blogId}`, FormDataAPI, {
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
            $("#blogBtnCnt").on("click", "#blogBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPBlogDuzenle.init();
});
