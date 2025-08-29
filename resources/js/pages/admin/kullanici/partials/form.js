"use strict";

import useReal from "../../../../script/real.js";

class RPKullaniciForm {
    constructor() {
        const { FormKontrol } = useReal();
        this.FormKontrol = FormKontrol; // FormKontrol fonksiyonunu sınıfın bir parçası yapıyoruz.
        this.init();
    }

    init() {
        this.KullaniciFormElement();
    }

    KullaniciFormElement() {
        const self = this;
    }

    KullaniciVeriler() {
        const self = this;

        let formData = new FormData();
        
        $("#kategori-indirim-tablo tbody tr").each(function () {
            let kategoriId = $(this).attr("kategori-id");
            let indirimYuzde = $(this).find(".indirimYuzde").val();

            if (kategoriId && indirimYuzde) {
                formData.append(`kategoriIndirimler[${kategoriId}]`, indirimYuzde);
            }
        });

        let FormValues = {
            isimSoyisim: $("#kullaniciForm #isimSoyisim").val(),
            eposta: $("#kullaniciForm #eposta").val(),
            telefon: $("#kullaniciForm #telefon").val(),
            sifre: $("#kullaniciForm #sifre").val(),
        };

        formData.append("isimSoyisim", FormValues.isimSoyisim);
        formData.append("eposta", FormValues.eposta);
        formData.append("telefon", FormValues.telefon);
        formData.append("sifre", FormValues.sifre);


        if ($('#kullaniciForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    KullaniciFormKontrol() {
        const self = this;



        const FormId = "kullaniciForm";
        let FormValues = {
            isimSoyisim: $("#kullaniciForm #isimSoyisim").val(),
            eposta: $("#kullaniciForm #eposta").val(),
            telefon: $("#kullaniciForm #telefon").val(),
            sifre: ($("#kullaniciForm #sifre").attr("duzenle") == true ? $("#kullaniciForm #sifre").val() : "-"),
        };


        const FormKontrol = [
            {
                label: "İsim Soyisim",
                name: `isimSoyisim`,
                value: FormValues.isimSoyisim,
                required: true,
            },
            {
                label: "E posta",
                name: `eposta`,
                value: FormValues.eposta,
                required: true,
            },
            {
                label: "Telefon",
                name: `telefon`,
                value: FormValues.telefon,
                required: true,
            },
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

export default RPKullaniciForm;
