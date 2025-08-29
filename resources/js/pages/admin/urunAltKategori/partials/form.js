"use strict";

import useReal from "../../../../script/real.js";

class RPUrunAltKategoriForm {
    urunKategoriGorseller = null;
    quill = {};

    constructor() {
        const { FormKontrol } = useReal();
        this.FormKontrol = FormKontrol; // FormKontrol fonksiyonunu sınıfın bir parçası yapıyoruz.
        this.init();
    }

    init() {
        this.UrunAltKategoriFormElement();
    }

    UrunAltKategoriFormElement() {
        const self = this;

    }

    UrunAltKategoriVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach((dil) => {
            let FormValues = {
                [`isim_${dil}`]: $(`#urunAltKategoriForm #isim-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        formData.append(
            "kategori_id",
            $(`#urunAltKategoriForm #kategori`).val()
        );

        if ($("#urunAltKategoriForm #durum").is(":checked")) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    UrunAltKategoriFormKontrol() {
        const self = this;

        const FormId = "urunAltKategoriForm";
        let FormValues = {
            kategori: $(`#urunAltKategoriForm #kategori`).val(),
            isim: $(`#urunAltKategoriForm #isim-${varsayilanDil}`).val(),
        };

        const FormKontrol = [
            {
                label: "Kategori",
                name: `kategori`,
                value: FormValues.kategori,
                required: true,
            },
            {
                label: "Başlık",
                name: `isim-${varsayilanDil}`,
                value: FormValues.isim,
                required: true,
            },
        ];

        return self.FormKontrol().validate(FormId, FormKontrol);
    }
}

export default RPUrunAltKategoriForm;
