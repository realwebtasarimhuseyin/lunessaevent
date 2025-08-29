"use strict";

import axios from "axios";
import useReal from "../../../script/real.js";

const RPGiris = (() => {
    const { Swall, SwallCikis, FormKontrol, FormTamamlandi } = useReal();

    const FormElementHazirla = () => {

    };

    const FormVerisiHazirla = () => {
        const formVerisi = new FormData();

        const formFields = {
            eposta: $("#girisEposta").val(),
            sifre: $("#girisSifre").val(),
            beniHatirla: $("#girisBeniHatirla").is('checked')
        };

        for (const [key, value] of Object.entries(formFields)) {
            if (value) {
                formVerisi.append(key, value);
            }
        }

        return { formVerisi };
    };

    const FormuGonder = async () => {

        if (GirisFormKontrol()) {

            const { formVerisi } = FormVerisiHazirla();

            Swall({
                icon: "info",
                icerik: "Giriş Yapılıyor, Lütfen Bekleyiniz ...",
                onayButonDurum: false
            });

            try {
                const { data } = await axios.post(appUrl + "/giris", formVerisi);

                FormTamamlandi(data.mesaj);

                setTimeout(() => {

                    SwallCikis();

                    window.location.href = appUrl + '/hesabim'

                }, 1000);

            } catch (error) {
                setTimeout(() => {
                    Swall({
                        icon: "error",
                        baslik: "Giriş Başarısız !",
                        icerik: "Lütfen Bilgilerinizi kontrol ediniz ...",
                        onayButonIcerik: "Tamam"
                    });
                }, 1000);
            }
        }
    };

    const OlayDinleyicileriEkle = () => {
        $("#giris-btn").on("click", FormuGonder);
    };

    const GirisFormKontrol = () => {
        const FormId = "girisForm";
        let FormValues = {
            girisEposta: $(`#girisForm #girisEposta`).val(),
            girisSifre: $(`#girisForm #girisSifre`).val()
        };

        const FormKontrolArray = [
            {
                label: "E-Posta",
                name: `girisEposta`,
                value: FormValues.girisEposta,
                required: true,
            },
            {
                label: "Şifre",
                name: `girisSifre`,
                value: FormValues.girisSifre,
                required: true,
            },
        ];

        return FormKontrol()
            .validate(FormId, FormKontrolArray);
    }

    return {
        init: () => {
            FormElementHazirla();
            OlayDinleyicileriEkle();

        },
    };
})();

document.addEventListener("DOMContentLoaded", RPGiris.init);