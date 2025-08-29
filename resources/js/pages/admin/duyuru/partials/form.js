"use strict";

import useReal from "../../../../script/real.js";

class RPDuyuruForm {

    constructor() {
        const { FormKontrol } = useReal();
        this.FormKontrol = FormKontrol;
        this.init();
    }

    init() {
        this.DuyuruFormElement();
    }

    DuyuruFormElement() {
        const self = this;

    }

    DuyuruVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach(dil => {
            let FormValues = {
                [`icerik_${dil}`]:  $(`#duyuruForm #icerik-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });
     
        if ($('#duyuruForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    DuyuruFormKontrol() {
        const self = this;

        const FormId = "duyuruForm";
        let FormValues = {
            icerik: $(`#duyuruForm #icerik-${varsayilanDil}`).val(),
        };

        const FormKontrol = [
            {
                label: "İçerik",
                name: `icerik-${varsayilanDil}`,
                value: FormValues.icerik,
                required: true,
            },
        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);

    }
}

export default RPDuyuruForm;
