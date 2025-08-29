"use strict";

import useReal from "../../../../script/real.js";

class RPGaleriForm {
    galeriDosya = null;

    constructor() {
        const { FormKontrol, FilePonds } = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;
        this.init();
    }

    init() {
        this.GaleriFormElement();
    }

    GaleriFormElement() {
        const self = this;



        self.galeriDosya = self.FilePonds(
            ".galeriDosya",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi veya Videonuzu Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`, // Yükleme mesajı
                acceptedFileTypes: [
                    'image/png', 'image/jpeg', 'image/webp',
                    'video/mp4', 'video/webm', 'video/ogg'
                ],
                maxFileSize: '50MB',
            }
        );


        if (typeof dosyaUrl !== 'undefined') {
            self.galeriDosya.addFile(dosyaUrl)
        }
    }

    GaleriVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach(dil => {
            let FormValues = {
                [`baslik_${dil}`]: $(`#galeriForm #baslik-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        let galeriDosyaf = self.galeriDosya.getFiles();

        if (galeriDosyaf.length > 0) {
            formData.append(`dosya`, galeriDosyaf[0].file);
        }

        if ($('#galeriForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    GaleriFormKontrol() {
        const self = this;

        const FormId = "galeriForm";
        let FormValues = {
            baslik: $(`#galeriForm #baslik-${varsayilanDil}`).val(),
        };

        const FormKontrol = [
            {
                label: "Başlık",
                name: `baslik-${varsayilanDil}`,
                value: FormValues.baslik,
                required: true,
            },

        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);

    }
}

export default RPGaleriForm;
