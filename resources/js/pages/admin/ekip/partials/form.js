"use strict";

import useReal from "../../../../script/real.js";

class RPEkipForm {
    ekipResim = null;
    quill = {};

    constructor() {
        const { FormKontrol, FilePonds } = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;
        this.init();
    }

    init() {
        this.EkipFormElement();
    }

    EkipFormElement() {
        const self = this;



        self.ekipResim = self.FilePonds(
            ".ekipResim",
            {
                allowMultiple: false, // Tek dosya yüklemeye izin verir
                maxFiles: 1, // Yüklenebilecek maksimum dosya sayısı
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`, // Yükleme mesajı
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                maxFileSize: '5MB', // Maksimum dosya boyutu (isteğe bağlı)
            }
        );



        if (typeof resimUrl !== 'undefined') {
            self.ekipResim.addFile(resimUrl)
        }
    }

    EkipVeriler() {
        const self = this;

        let formData = new FormData();

        let FormValues = {
            isim: $("#ekipForm #isim").val(),
            unvan: $("#ekipForm #unvan").val(),
        };

        formData.append("isim", FormValues.isim);
        formData.append("unvan", FormValues.unvan);

        let ekipResimf = self.ekipResim.getFiles();

        if (ekipResimf.length > 0) {
            formData.append(`resim`, ekipResimf[0].file);
        }

        if ($('#ekipForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    EkipFormKontrol() {
        const self = this;

        const FormId = "ekipForm";
        let FormValues = {
            isim: $(`#ekipForm #isim`).val(),
            unvan: $(`#ekipForm #unvan`).val(),
        };

        const FormKontrol = [
            {
                label: "Ekip İsim",
                name: `isim`,
                value: FormValues.isim,
                required: true,
            },
            {
                label: "Ekip Ünvan",
                name: `unvan`,
                value: FormValues.unvan,
                required: true,
            },
        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);

    }
}

export default RPEkipForm;