"use strict";

import axios from "axios";
import useReal from "../../../script/real.js";
import IMask from "imask";

const RPProfil = (() => {
    const { Swall, SwallCikis, FormKontrol, FormTamamlandi } = useReal();

    const FormElementHazirla = () => {
        const maskeler = [
            { elementId: 'profilTelefon', maske: '+{90} 000 000 00 00' },
        ];

        maskeler.forEach(({ elementId, maske, bloklar }) => {
            const maskOptions = bloklar ? { mask: maske, blocks: bloklar } : { mask: maske };
            IMask(document.getElementById(elementId), maskOptions);
        });
    };

    const FormVerisiHazirla = () => {
        const formVerisi = new FormData();

        const formFields = {
            isimSoyisim: $("#profilIsimSoyisim").val(),
            eposta: $("#profilEposta").val(),
            telefon: $("#profilTelefon").val(),
            sifre: $("#profilSifre").val(),
            sifre_confirmation: $("#profilSifreTekrar").val(),
        };

        for (const [key, value] of Object.entries(formFields)) {
            if (value) {
                formVerisi.append(key, value);
            }
        }

        return { formVerisi };
    };


    const FormuGonder = async () => {

        if (ProfilFormKontrol()) {

            const { formVerisi } = FormVerisiHazirla();

            Swall({
                icon: "info",
                icerik: "Hesap Bilgileri Düzenleme Yapılıyor, Lütfen Bekleyiniz ...",
                onayButonDurum: false
            });

            try {
                const { data } = await axios.post(appUrl + "/hesabim/duzenle", formVerisi);

                FormTamamlandi(data.mesaj);

                setTimeout(() => {

                    SwallCikis();

                }, 1000);
                window.location.reload();
            } catch (error) {
                setTimeout(() => {
                    Swall({
                        icon: "error",
                        baslik: "Düzenleme Başarısız !",
                        icerik: "Lütfen Bilgilerinizi kontrol ediniz ...",
                        onayButonIcerik: "Tamam"
                    });
                }, 1000);
            }
        }
    };



    const OlayDinleyicileriEkle = () => {
        $("#profil-duzenle-btn").on("click", FormuGonder);

        $(".siparis-detay-btn").on("click", async function () {
            const siparisId = $(this).closest(".siparis").attr("siparis-id");

            if (!siparisId) {
                Swal.fire({
                    icon: "error",
                    title: "Hata",
                    text: "Sipariş ID bulunamadı!",
                    confirmButtonText: "Tamam"
                });
                return;
            }

            try {
                const { data } = await axios.post(appUrl + "/siparis/detay", { "siparis-id": siparisId });

                let modalContent = '';

                $("#siparisModal .modal-body").html(modalContent);

                $("#siparisModal").modal("show");

            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Hata",
                    text: error.response?.data?.mesaj || "Sipariş detayları alınırken bir hata oluştu.",
                    confirmButtonText: "Tamam"
                });
            }

        });
    };

    const ProfilFormKontrol = () => {
        const FormId = "profilForm";
        let FormValues = {
            profilIsimSoyisim: $(`#profilForm #profilIsimSoyisim`).val(),
            profilEposta: $(`#profilForm #profilEposta`).val(),
            profilTelefon: $(`#profilForm #profilTelefon`).val(),
            profilSifre: $(`#profilForm #profilSifre`).val().trim(),
            profilSifreTekrar: $(`#profilForm #profilSifreTekrar`).val().trim()
        };

        if (FormValues.profilSifre != FormValues.profilSifreTekrar) {
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
                name: `profilIsimSoyisim`,
                value: FormValues.profilIsimSoyisim,
                required: true,
            },
            {
                label: "E-Posta",
                name: `profilEposta`,
                value: FormValues.profilEposta,
                required: true,
            },
            {
                label: "Telefon",
                name: `profilTelefon`,
                value: FormValues.profilTelefon,
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

document.addEventListener("DOMContentLoaded", RPProfil.init);