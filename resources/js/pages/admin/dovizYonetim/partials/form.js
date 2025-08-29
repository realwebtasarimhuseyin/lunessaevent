"use strict";

import useReal from "../../../../script/real.js";
import IMask from 'imask';

class RPDovizYonetimForm {

    constructor() {
        const { FormKontrol } = useReal();
        this.FormKontrol = FormKontrol;
        this.init();
    }

    init() {
        this.DovizYonetimFormElement();
    }

    DovizYonetimFormElement() {
        const self = this;
        const yuzde = document.getElementById('yuzde');
        const tutar = document.getElementById('birim');

        // Maskeler oluşturuluyor
        const yuzdeMask = IMask(yuzde, {
            mask: Number,
            scale: 2, // Ondalık basamak sayısı
            signed: false, // Negatif değerlere izin verme
            min: 0, // Minimum değer
            max: 100, // Maksimum değer
            radix: ',', // Ondalık ayracı
            thousandsSeparator: '.', // Binlik ayırıcı
        });

        const tutarMask = IMask(tutar, {
            mask: Number,
            scale: 2, // Ondalık basamak sayısı
            signed: false, // Negatif değerlere izin verme
            radix: ',', // Ondalık ayracı
            thousandsSeparator: '.', // Binlik ayırıcı
            mapToRadix: ['.'], // Noktaları ondalık ayracı olarak algıla
        });

        // Değişim olayları
        $("#dovizYonetimForm").on("change", "#yuzde", function () {
            let val = parseFloat(yuzdeMask.unmaskedValue) || 0; // Maskeyi kaldırarak gerçek değeri al
            if (val < 0) val = 0;
            if (val > 100) val = 100;

            // İndirim yüzdesi girildiyse tutarı sıfırla
            if (val > 0) {
                tutarMask.unmaskedValue = "0";
                tutarMask.updateValue(); // Maskeyi senkronize et
            }
            yuzdeMask.unmaskedValue = val.toFixed(2);
            yuzdeMask.updateValue(); // Maskeyi senkronize et
        });

        $("#dovizYonetimForm").on("change", "#birim", function () {
            let val = parseFloat(tutarMask.unmaskedValue) || 0;

            // Negatif değerleri engelle
            val = Math.max(0, val);

            // Eğer tutar girildiyse yüzdede sıfırla
            if (val > 0) {
                yuzdeMask.unmaskedValue = "0";
                yuzdeMask.updateValue(); // Maskeyi senkronize et
            }

            // Maskeyi güncelle
            tutarMask.unmaskedValue = val.toFixed(2);
            tutarMask.updateValue();
        });
    }

    DovizYonetimVeriler() {
        const self = this;

        let formData = new FormData();

        formData.append('kaynak', $("#dovizYonetimForm #kaynak").val());
        formData.append(`birim`, $("#dovizYonetimForm #birim").val().replace(/\./g, "").replace(/,/g, "."));
        formData.append(`yuzde`, $("#dovizYonetimForm #yuzde").val().replace(/\./g, "").replace(/,/g, "."));

        return formData;
    }

    DovizYonetimFormKontrol() {
        const self = this;

        return true;

    }
}

export default RPDovizYonetimForm;
