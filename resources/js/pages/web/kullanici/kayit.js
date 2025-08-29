"use strict";

import axios from "axios";
import useReal from "../../../script/real.js";
import IMask from "imask";

const RPKayit = (() => {
    const { Swall, SwallCikis, FormKontrol, FormTamamlandi } = useReal();

    const FormElementHazirla = () => {
        const maskeler = [
            { elementId: 'kayitTelefon', maske: '+{90} 000 000 00 00' },
        ];

        maskeler.forEach(({ elementId, maske, bloklar }) => {
            const maskOptions = bloklar ? { mask: maske, blocks: bloklar } : { mask: maske };
            IMask(document.getElementById(elementId), maskOptions);
        });
    };

    const FormVerisiHazirla = () => {
        const formVerisi = new FormData();

        const formFields = {
            isimSoyisim: $("#kayitIsimSoyisim").val(),
            eposta: $("#kayitEposta").val(),
            telefon: $("#kayitTelefon").val(),
            sifre: $("#kayitSifre").val(),
        };

        for (const [key, value] of Object.entries(formFields)) {
            if (value) {
                formVerisi.append(key, value);
            }
        }

        return { formVerisi };
    };

    const FormuGonder = async () => {

        if (KayitFormKontrol()) {

            const { formVerisi } = FormVerisiHazirla();

            Swall({
                icon: "info",
                icerik: "Kayıt Yapılıyor, Lütfen Bekleyiniz ...",
                onayButonDurum: false
            });

            try {
                const { data } = await axios.post(appUrl + "/kayit", formVerisi);

                FormTamamlandi(data.mesaj);

                setTimeout(() => {

                    SwallCikis();

                    window.location.href = appUrl + "/giris";

                }, 1000);

            } catch (error) {
                setTimeout(() => {
                    Swall({
                        icon: "error",
                        baslik: "Kayıt Başarısız !",
                        icerik: "Lütfen Bilgilerinizi kontrol ediniz ...",
                        onayButonIcerik: "Tamam"
                    });
                }, 1000);
            }
        }
    };

    const OlayDinleyicileriEkle = () => {
        $("#kayit-btn").on("click", FormuGonder);
    };

    const KayitFormKontrol = () => {
        const FormId = "kayitForm";
        let FormValues = {
            kayitIsimSoyisim: $(`#kayitForm #kayitIsimSoyisim`).val(),
            kayitEposta: $(`#kayitForm #kayitEposta`).val(),
            kayitTelefon: $(`#kayitForm #kayitTelefon`).val(),
            kayitSifre: $(`#kayitForm #kayitSifre`).val().trim(),
            kayitSifreTekrar: $(`#kayitForm #kayitSifreTekrar`).val().trim()
        };

        if (FormValues.kayitSifre != FormValues.kayitSifreTekrar) {
            Swall(
                {
                    icon: "error",
                    baslik: "Şifreler aynı değil !",
                    icerik: "Lütfen şifre tekrarını aynı giriniz !"
                }
            );

            return false;
        }

        const FormKontrolArray = [
            {
                label: "İsim Soyisim",
                name: `kayitIsimSoyisim`,
                value: FormValues.kayitIsimSoyisim,
                required: true,
            },
            {
                label: "E-Posta",
                name: `kayitEposta`,
                value: FormValues.kayitEposta,
                required: true,
            },
            {
                label: "Telefon",
                name: `kayitTelefon`,
                value: FormValues.kayitTelefon,
                required: true,
            },
            {
                label: "Şifre",
                name: `kayitSifre`,
                value: FormValues.kayitSifre,
                required: true,
            },
            {
                label: "Şifre Tekrar",
                name: `kayitSifreTekrar`,
                value: FormValues.kayitSifreTekrar,
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

document.addEventListener("DOMContentLoaded", RPKayit.init);