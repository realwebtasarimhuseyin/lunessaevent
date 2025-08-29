"use strict";

import axios from "axios";
import useReal from "../../script/real.js";
import IMask from 'imask';

const RPOdeme = (() => {
    const { Swall, SwallCikis, FormKontrol } = useReal();

    const FormElementHazirla = () => {
        const simdikiYil = new Date().getFullYear() % 100;
        const yilSiniri = simdikiYil + 10;

        const maskeler = [
            { elementId: 'siparisTelefon', maske: '+{90} 000 000 00 00' },
            { elementId: 'siparisPostaKodu', maske: '00000' },
        ];

        maskeler.forEach(({ elementId, maske, bloklar }) => {
            const maskOptions = bloklar ? { mask: maske, blocks: bloklar } : { mask: maske };
            IMask(document.getElementById(elementId), maskOptions);
        });

        $("input[name='payment']").on('change', function () {
            const odemeTip = $(this).val();

            if (odemeTip == "kapida") {
                $("#siparisKapidaOdemeTutar").removeClass("d-none");
                $('.sepetGenelToplamTutar').text( (Math.floor(toplamTutar) + Math.floor(kapidaOdemeTutar)) + " TL");

            } else {
                $("#siparisKapidaOdemeTutar").addClass("d-none");
                $('.sepetGenelToplamTutar').text( (Math.floor(toplamTutar)) + " TL");

            }
        });
    };

    const FormVerisiHazirla = () => {
        const formVerisi = new FormData();

        const formFields = {
            /*   siparisSirketIsim: $("#siparisSirketIsim").val(), */
            siparisIsim: $("#siparisIsim").val(),
            /*   siparisTcVergiNo: $(`#siparisForm #siparisTcVergiNo`).val(), */
            /*   siparisVergiDairesi: $("#siparisVergiDairesi").val(), */
            siparisTelefon: $("#siparisTelefon").val(),
            siparisEposta: $("#siparisEposta").val(),
            siparisIl: $("#siparisIl").val(),
            siparisIlce: $("#siparisIlce").val(),
            siparisAdres: $("#siparisAdres").val(),
            siparisPostaKodu: $("#siparisPostaKodu").val(),
            siparisOdemeTip: $("input[name='payment']:checked").val()
        };

        for (const [key, value] of Object.entries(formFields)) {
            if (value) {
                formVerisi.append(key, value);
            }
        }

        return { formVerisi };
    };

    const FormuGonder = async () => {
        if (SiparisFormKontrol()) {
            /* if (!$("#mesafeliSatisSozlesmesiCkbx").is(":checked")) {
                return Swall({
                    icon: "error",
                    icerik: "Ödemeyi Gerçekleştirmek İçin Mesafeli Satış Sözleşmesini Kabul Etmek Zorundasınız!",
                    onayButonIcerik: "Tamam"
                });
            } */

            const odemeTip = $("input[name='payment']:checked").val();

            const { formVerisi } = FormVerisiHazirla();

            Swall({
                icon: "info",
                icerik: "Sipariş Oluşturuluyor, Lütfen Bekleyiniz ...",
                onayButonDurum: false
            });

            try {
                const { data } = await axios.post(appUrl + "/siparis/ekle", formVerisi, { headers: { "Content-Type": "multipart/form-data" } });

                if (odemeTip == "krediKarti") {
                    console.log(data);
                    $("#siparisForm").remove();
                    $("#odemeIframeAlani").removeClass("d-none");
                    $("#iyziIframe").attr("src", data.data.iframeLink + "&iframe=true");

                    window.addEventListener("message", function (event) {
                        if (event.data?.type === "odemeSonucu" && event.data.redirectUrl) {
                            setTimeout(() => {
                                window.location.href = event.data.redirectUrl;
                                $(document).scrollTop(0);
                            }, 2000);
                        }
                    });

                    SwallCikis();

                } else {
                    window.location.href = appUrl + '/odeme/basarili'
                }

            } catch (error) {
                Swall({
                    icon: "error",
                    icerik: aktifDil === "tr" ? "Lütfen tüm alanları doğru bir şekilde doldurup tekrar deneyiniz!" : "Please fill in all fields correctly and try again!",
                    onayButonIcerik: "Tamam"
                });
            }
        }
    };

    const OlayDinleyicileriEkle = () => {
        $("#odeme-btn").on("click", FormuGonder);
    };

    const SiparisFormKontrol = () => {
        const FormId = "siparisForm";
        let FormValues = {
            siparisIsim: $(`#siparisForm #siparisIsim`).val(),
            siparisTelefon: $(`#siparisForm #siparisTelefon`).val(),
            siparisEposta: $(`#siparisForm #siparisEposta`).val(),
            siparisIl: $(`#siparisForm #siparisIl`).val(),
            siparisIlce: $(`#siparisForm #siparisIlce`).val(),
            siparisAdres: $(`#siparisForm #siparisAdres`).val(),
            siparisPostaKodu: $(`#siparisForm #siparisPostaKodu`).val()
        };

        const FormKontrolArray = [
            {
                label: "İsim Soyisim",
                name: `siparisIsim`,
                value: FormValues.siparisIsim,
                required: true,
            },
           
            {
                label: "Telefon",
                name: `siparisTelefon`,
                value: FormValues.siparisTelefon,
                required: true,
            },
            {
                label: "E-Posta",
                name: `siparisEposta`,
                value: FormValues.siparisEposta,
                required: true,
            },
            {
                label: "İl",
                name: `siparisIl`,
                value: FormValues.siparisIl,
                required: true,
            },
            {
                label: "İlçe",
                name: `siparisIlce`,
                value: FormValues.siparisIlce,
                required: true,
            },
            {
                label: "Adres",
                name: `siparisAdres`,
                value: FormValues.siparisAdres,
                required: true,
            },
            {
                label: "Posta Kod",
                name: `siparisPostaKodu`,
                value: FormValues.siparisPostaKodu,
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

document.addEventListener("DOMContentLoaded", RPOdeme.init);