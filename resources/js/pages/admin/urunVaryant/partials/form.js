"use strict";

import useReal from "../../../../script/real.js";

class RPUrunVaryantForm {
    urunKategoriGorseller = null;
    quill = {};

    constructor() {
        const { FormKontrol } = useReal();
        this.FormKontrol = FormKontrol; // FormKontrol fonksiyonunu sınıfın bir parçası yapıyoruz.
        this.init();
    }

    init() {
        this.UrunVaryantFormElement();
    }

    UrunVaryantFormElement() {
        const self = this;


    }

    UrunVaryantVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach((dil) => {
            let FormValues = {
                [`isim_${dil}`]: $(`#urunVaryantForm #isim-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        if ($("#urunVaryantForm #durum").is(":checked")) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    UrunVaryantFormKontrol() {
        const self = this;

        const FormId = "urunVaryantForm";
        let FormValues = {
            isim: $(`#urunVaryantForm #isim-${varsayilanDil}`).val(),
        };

        const FormKontrol = [
            {
                label: "Varyant İsim",
                name: `isim-${varsayilanDil}`,
                value: FormValues.isim,
                required: true,
            },
        ];

        return self.FormKontrol().validate(FormId, FormKontrol);
    }
}

export default RPUrunVaryantForm;
