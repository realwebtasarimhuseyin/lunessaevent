"use strict";

import useReal from "../../../../script/real.js";

class RPUrunKdvForm {
    urunKategoriGorseller = null;

    constructor() {
        const { FormKontrol } = useReal();
        this.FormKontrol = FormKontrol;
        this.init();
    }

    init() {
        this.UrunKdvFormElement();
    }

    UrunKdvFormElement() {
        const self = this;
    }

    UrunKdvVeriler() {
        const self = this;

        let formData = new FormData();

        formData.append("baslik", $("#urunKdvForm #kdvBaslik").val());
        formData.append("kdv", $("#urunKdvForm #kdvOran").val());

        if ($("#urunKdvForm #durum").is(":checked")) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    UrunKdvFormKontrol() {
        const self = this;

        const FormId = "urunKdvForm";
        let FormValues = {
            kdvBaslik: $(`#urunKdvForm #kdvBaslik`).val(),
            kdvOran: $(`#urunKdvForm #kdvOran`).val(),
        };

        const FormKontrol = [
            {
                label: "Kdv Başlık",
                name: `kdvBaslik`,
                value: FormValues.kdvBaslik,
                required: true,
            },
            {
                label: "Kdv Oran",
                name: `kdvOran`,
                value: FormValues.kdvOran,
                required: true,
            },
        ];

        return self.FormKontrol().validate(FormId, FormKontrol);
    }
}

export default RPUrunKdvForm;
