"use strict";

import useReal from "../../../../script/real.js";

class RPUrunOzellikForm {
    urunKategoriGorseller = null;

    constructor() {
        const { FormKontrol } = useReal();
        this.FormKontrol = FormKontrol;
        this.init();
    }

    init() {
        this.UrunOzellikFormElement();
    }

    UrunOzellikFormElement() {
        const self = this;
    }

    UrunOzellikVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach((dil) => {
            let FormValues = {
                [`isim_${dil}`]: $(`#urunOzellikForm #isim-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        if ($("#urunOzellikForm #durum").is(":checked")) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    UrunOzellikFormKontrol() {
        const self = this;

        const FormId = "urunOzellikForm";
        let FormValues = {
            isim: $(`#urunOzellikForm #isim-${varsayilanDil}`).val(),
        };

        const FormKontrol = [
            {
                label: "Ozellik İsim",
                name: `isim-${varsayilanDil}`,
                value: FormValues.isim,
                required: true,
            },
        ];

        return self.FormKontrol().validate(FormId, FormKontrol);
    }
}

export default RPUrunOzellikForm;
