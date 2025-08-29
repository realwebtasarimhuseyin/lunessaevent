"use strict";

import useReal from "../../../../script/real.js";

class RPYetkiForm {
    constructor() {
        const { FormKontrol } = useReal();
        this.FormKontrol = FormKontrol;
        this.init();
    }

    init() {
        this.YetkiFormElement();
    }

    YetkiFormElement() {
        const self = this;
    }

    YetkiVeriler() {
        const self = this;

        let formData = new FormData();

        let FormValues = {
            isim: $("#yetkiForm #isim").val(),
        };

        formData.append("isim", FormValues.isim);

        let yetkiler = [];


        $("input[name='yetkiler[]']:checked").each(function () {
            yetkiler.push($(this).val());
        });

        yetkiler.forEach(function (yetki) {
            formData.append("yetkiler[]", yetki);
        });

        return formData;
    }

    YetkiFormKontrol() {
        const self = this;

        const FormId = "yetkiForm";
        let FormValues = {
            isim: $("#yetkiForm #isim").val(),

        };


        const FormKontrol = [
            {
                label: "İsim",
                name: `isim`,
                value: FormValues.isim,
                required: true,
            },

        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);

    }
}

export default RPYetkiForm;
