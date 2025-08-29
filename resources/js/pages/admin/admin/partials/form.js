"use strict";

import useReal from "../../../../script/real.js";

class RPAdminForm {
    constructor() {
        const { FormKontrol } = useReal();
        this.FormKontrol = FormKontrol; // FormKontrol fonksiyonunu sınıfın bir parçası yapıyoruz.
        this.init();
    }

    init() {
        this.AdminFormElement();
    }

    AdminFormElement() {
        const self = this;
    }

    AdminVeriler() {
        const self = this;

        let formData = new FormData();

        let FormValues = {
            isim: $("#adminForm #isim").val(),
            soyisim: $("#adminForm #soyisim").val(),
            eposta: $("#adminForm #eposta").val(),
/*             yetki: $("#adminForm #yetki").val(),
 */            sifre: $("#adminForm #sifre").val(),
        };

        formData.append("isim", FormValues.isim);
        formData.append("soyisim", FormValues.soyisim);
        formData.append("eposta", FormValues.eposta);
        formData.append("yetki", "010");
        formData.append("sifre", FormValues.sifre);


        if ($('#adminForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    AdminFormKontrol() {
        const self = this;

        const FormId = "adminForm";
        let FormValues = {
            isim: $("#adminForm #isim").val(),
            soyisim: $("#adminForm #soyisim").val(),
            eposta: $("#adminForm #eposta").val(),
            /*       
                  yetki: $("#adminForm #yetki").val(),
             */
            sifre: ($("#adminForm #sifre").attr("duzenle") == true ? $("#adminForm #sifre").val() : "-"),
        };


        const FormKontrol = [
            {
                label: "İsim",
                name: `isim`,
                value: FormValues.isim,
                required: true,
            },
            {
                label: "Soyisim",
                name: `soyisim`,
                value: FormValues.soyisim,
                required: true,
            },
            {
                label: "E-posta",
                name: `eposta`,
                value: FormValues.eposta,
                required: true,
            },
            /*  {
                 label: "Yetki",
                 name: `yetki`,
                 value: FormValues.yetki,
                 required: true,
             }, */
            {
                label: "Şifre",
                name: `sifre`,
                value: FormValues.sifre,
                required: true,
            },
        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);

    }
}

export default RPAdminForm;
