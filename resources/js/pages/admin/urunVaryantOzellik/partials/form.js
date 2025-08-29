"use strict";

import useReal from "../../../../script/real.js";

class RPUrunVaryantOzellikForm {

    constructor() {
        const { FormKontrol } = useReal();
        this.FormKontrol = FormKontrol; // FormKontrol fonksiyonunu sınıfın bir parçası yapıyoruz.
        this.init();
    }

    init() {
        this.UrunVaryantOzellikFormElement();
    }

    UrunVaryantOzellikFormElement() {
        const self = this;


    }

    UrunVaryantOzellikVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach((dil) => {
            let FormValues = {
                [`isim_${dil}`]: $(`#urunVaryantOzellikForm #isim-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        formData.append(
            "varyant_id",
            $(`#urunVaryantOzellikForm #varyant`).val()
        );

        formData.append(`durum`, 1);

        return formData;
    }

    UrunVaryantOzellikFormKontrol() {
        const self = this;

        const FormId = "urunVaryantOzellikForm";
        let FormValues = {
            varyant: $(`#urunVaryantOzellikForm #varyant`).val(),
            isim: $(`#urunVaryantOzellikForm #isim-${varsayilanDil}`).val(),
        };

        const FormKontrol = [
            {
                label: "Varyant",
                name: `varyant`,
                value: FormValues.varyant,
                required: true,
            },
            {
                label: "Özellik İsmi",
                name: `isim-${varsayilanDil}`,
                value: FormValues.isim,
                required: true,
            },
        ];

        return self.FormKontrol().validate(FormId, FormKontrol);
    }
}

export default RPUrunVaryantOzellikForm;
