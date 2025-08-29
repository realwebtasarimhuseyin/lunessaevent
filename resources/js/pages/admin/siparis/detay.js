"use strict";

import axios from "axios";
import useReal from "../../../script/real.js";

const RPSiparisDetay = (() => {
    const { FormTamamlandi, Swall } = useReal();

    const FormElementHazirla = () => {

    };

    const FormVerisiHazirla = () => {
        const formVerisi = new FormData();

        const siparisDurum = $("#siparisDetayForm #siparisDurum").val();

        formVerisi.append("durum", siparisDurum);


        return { formVerisi };
    };

    const FormuGonder = async () => {
        const { formVerisi } = FormVerisiHazirla();

        try {
            const { data } = await axios.post(`${panelUrl}/siparis/duzenle/${siparisId}`, formVerisi, { headers: { "Content-Type": "multipart/form-data" } });
            FormTamamlandi(data.mesaj);
            setTimeout(() => {
                window.location.reload();
            }, 500);
        } catch (error) {

            console.error(error);

            Swall({
                icon: "error",
                icerik: "Sipariş Düzenlenemedi !",
                onayButonIcerik: "Tamam"
            });
        }
    };


    const OlayDinleyicileriEkle = () => {
        $("#siparisDetayForm").on("change", "#siparisDurum", function () {
            FormuGonder();
        });
    };


    return {
        init: () => {
            FormElementHazirla();
            OlayDinleyicileriEkle();
        },
    };
})();

document.addEventListener("DOMContentLoaded", RPSiparisDetay.init);