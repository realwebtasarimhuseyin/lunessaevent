"use strict";

import useReal from "../../../../script/real.js";

class RPKuponForm {
    kuponTarih = null;
    quill = {};
    FormId = "kuponForm";

    constructor() {
        const { FormKontrol, FlatPicker, ZamanFormati } = useReal();
        this.FormKontrol = FormKontrol; // FormKontrol fonksiyonunu sınıfın bir parçası yapıyoruz.
        this.FlatPicker = FlatPicker; // FlatPicker fonksiyonunu sınıfın bir parçası yapıyoruz.
        this.ZamanFormati = ZamanFormati; // ZamanFormati fonksiyonunu sınıfın bir parçası yapıyoruz.
        this.init();
    }

    init() {
        this.KuponFormElement();
    }

    KuponFormElement() {
        const self = this;

        self.kuponTarih = self.FlatPicker("tarih", fBaslangic, fBitis);


        $(`#${self.FormId}`).on("change", "#yuzde", function (e) {
            let val = parseFloat(e.target.value);
            if (!val || val < 0) {
                val = 0;
            }
            else if (val > 100) {
                val = 100;
            }
            if (val > 0) {
                $('[name="tutar"]').val("0.00").trigger("change");
            }
            e.target.value = parseFloat(val).toFixed(2);
        });

        $(`#${self.FormId}`).on("change", "#adet", function (e) {
            let val = parseFloat(e.target.value);
            if (val < 0) {
                val = 0;
            }
            e.target.value = parseFloat(val).toFixed(0);
        });


        $(`#${self.FormId}`).on("change", "#tutar", function (e) {
            let val = parseFloat(e.target.value);
            if (!val || val < 0) {
                val = 0;
            }
            if (val > 0) {
                $('[name="yuzde"]').val("0.00").trigger("change");
            }
            e.target.value = parseFloat(val).toFixed(2);
        });

    }

    KuponVeriler() {
        const self = this;

        let formData = new FormData();

        let FormValues = {
            kod: $("#kuponForm #kod").val(),
            adet: $("#kuponForm #adet").val(),
            tutar: $("#kuponForm #tutar").val(),
            yuzde: $("#kuponForm #yuzde").val(),
            baslangic_tarih: self.ZamanFormati(self.kuponTarih.selectedDates[0]),
            bitis_tarih: self.ZamanFormati(self.kuponTarih.selectedDates[1]),
        };


        if (!$("#kuponForm #kod").attr("disabled")) {
            formData.append("kod", FormValues.kod);
        }
        formData.append("adet", FormValues.adet);
        formData.append("tutar", FormValues.tutar);
        formData.append("yuzde", FormValues.yuzde);
        formData.append("baslangic_tarih", FormValues.baslangic_tarih);
        formData.append("bitis_tarih", FormValues.bitis_tarih);

        if ($('#kuponForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    KuponFormKontrol() {
        const self = this;
        const FormId = "kuponForm";

        let FormValues = {
            kod: $("#kuponForm #kod").val(),
            adet: $("#kuponForm #adet").val(),
            tutar: $("#kuponForm #tutar").val(),
            yuzde: $("#kuponForm #yuzde").val(),
            baslangic_tarih: self.ZamanFormati(self.kuponTarih.selectedDates[0]),
            bitis_tarih: self.ZamanFormati(self.kuponTarih.selectedDates[1]),
        };

        const FormKontrol = [
            {
                label: "Kupon Kod",
                name: `kod`,
                value: FormValues.kod,
                required: true,
            },
            {
                label: "Kupon Adet",
                name: `adet`,
                value: FormValues.adet,
                required: true,
            },
            {
                label: "Kupon Tarih",
                name: `tarih`,
                value: FormValues.baslangic_tarih,
                required: true,
            },
            {
                label: "Kupon Tutar",
                name: `tutar`,
                value: FormValues.tutar + FormValues.yuzde,
                required: true,
            },
        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);

    }
}

export default RPKuponForm;
