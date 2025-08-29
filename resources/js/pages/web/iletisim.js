"use strict";

import axios from "axios";
import useReal from "../../script/real.js";
import IMask from "imask";

const RPIletisim = (() => {
    const { Swall, SwallCikis, FormKontrol, FormTamamlandi, FormSifirla } = useReal();

    const FormElementHazirla = () => {
        const maskeler = [
            { elementId: 'iletisimTelefon', maske: '+{90} 000 000 00 00' },
        ];

        maskeler.forEach(({ elementId, maske, bloklar }) => {
            const maskOptions = bloklar ? { mask: maske, blocks: bloklar } : { mask: maske };
            IMask(document.getElementById(elementId), maskOptions);
        });
    };

    const FormVerisiHazirla = () => {
        const formVerisi = new FormData();

        const formFields = {
            isimSoyisim: $("#iletisimForm #iletisimIsimSoyisim").val(),
            telefon: $("#iletisimForm #iletisimTelefon").val(),
            eposta: $("#iletisimForm #iletisimEposta").val(),
            mesaj: $("#iletisimForm #iletisimMesaj").val(),
        };

        for (const [key, value] of Object.entries(formFields)) {
            if (value) {
                formVerisi.append(key, value);
            }
        }

        return { formVerisi };
    };

    const FormuGonder = async () => {

        if (IletisimFormKontrol()) {

            const { formVerisi } = FormVerisiHazirla();

            Swall({
                icon: "info",
                icerik: "İletişim Formu Gönderiliyor, Lütfen Bekleyiniz ...",
                onayButonDurum: false
            });

            try {
                const { data } = await axios.post(appUrl + "/iletisim/ekle", formVerisi);

                FormTamamlandi(data.mesaj);

                setTimeout(() => {
                    FormSifirla();
                }, 1000);

            } catch (error) {
                setTimeout(() => {
                    Swall({
                        icon: "error",
                        baslik: "Mesajınız İletilemedi !",
                        icerik: "Lütfen Bilgilerinizi kontrol ediniz ...",
                        onayButonIcerik: "Tamam"
                    });
                }, 1000);
            }
        }
    };

    const OlayDinleyicileriEkle = () => {
        $("#iletisim-btn").on("click", FormuGonder);
    };

    const IletisimFormKontrol = () => {
        const FormId = "iletisimForm";
        let FormValues = {
            iletisimIsimSoyisim: $("#iletisimForm #iletisimIsimSoyisim").val(),
            iletisimTelefon: $("#iletisimForm #iletisimTelefon").val(),
            iletisimEposta: $("#iletisimForm #iletisimEposta").val(),
            iletisimMesaj: $("#iletisimForm #iletisimMesaj").val(),
        };

        const FormKontrolArray = [
            {
                label: "İsim Soyisim",
                name: `iletisimIsimSoyisim`,
                value: FormValues.iletisimIsimSoyisim,
                required: true,
            },
            {
                label: "E-Posta",
                name: `iletisimEposta`,
                value: FormValues.iletisimEposta,
                required: true,
                type: "email"
            },
            {
                label: "Telefon",
                name: `iletisimTelefon`,
                value: FormValues.iletisimTelefon,
                required: true,
            },
            {
                label: "Mesaj",
                name: `iletisimMesaj`,
                value: FormValues.iletisimMesaj,
                required: true,
                minUzunluk: 10,
                maxUzunluk: 5000
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

document.addEventListener("DOMContentLoaded", RPIletisim.init);
