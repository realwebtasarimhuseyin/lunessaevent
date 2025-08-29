("use strict");

import axios from "axios";
import useReal from "../../../script/real.js";
import RPSliderForm from "./partials/form.js";

const RPSliderEkle = (function () {
    const { FormGondermeOnay, FormYukleniyor, FormTamamlandi, Swall } = useReal();
    const sliderForm = new RPSliderForm();

    const FormGonder = function () {
        if (sliderForm.SliderFormKontrol()) {
            FormGondermeOnay("Slider Düzenleniyor !").then((result) => {
                if (result.isConfirmed) {
                    FormYukleniyor("Slider Düzenleniyor...");
                    setTimeout(() => {
                        const FormDataAPI = sliderForm.SliderVeriler();
                        axios
                            .post(`${panelUrl}/slider/duzenle/${sliderId}`, FormDataAPI, {
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
            $("#sliderBtnCnt").on("click", "#sliderBtnSbt", function () {
                return FormGonder();
            });
        },
    };
})();

document.addEventListener("DOMContentLoaded", (event) => {
    RPSliderEkle.init();
});
