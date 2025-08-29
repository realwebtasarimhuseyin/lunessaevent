"use strict";

import useReal from "../../../../script/real.js";

class RPSliderForm {
    sliderDosya = null;

    constructor() {
        const { FormKontrol, FilePonds } = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;
        this.init();
    }

    init() {
        this.SliderFormElement();
    }

    SliderFormElement() {
        const self = this;

        self.sliderDosya = self.FilePonds(
            ".sliderDosya",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi veya Videonuzu Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`, // Yükleme mesajı
                acceptedFileTypes: [
                    'image/png', 'image/jpeg', 'image/webp',
                    'video/mp4', 'video/webm', 'video/ogg'
                ],
                maxFileSize: '10MB',
            }
        );



        if (typeof dosyaUrl !== 'undefined') {
            self.sliderDosya.addFile(dosyaUrl)
        }
    }

    SliderVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach(dil => {
            let FormValues = {
                [`baslik_${dil}`]: $(`#sliderForm #baslik-${dil}`).val(),
                [`altBaslik_${dil}`]: $(`#sliderForm #altBaslik-${dil}`).val(),
                [`butonIcerik_${dil}`]: $(`#sliderForm #butonIcerik-${dil}`).val(),
                [`butonUrl_${dil}`]: $(`#sliderForm #butonUrl-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        let files = self.sliderDosya.getFiles();

        if (files.length > 0) {
            files.forEach((fileItem, index) => {
                formData.append(`dosya`, fileItem.file);
            });
        }
        if ($('#sliderForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    SliderFormKontrol() {
        const self = this;

        return true;

       /*  const FormId = "sliderForm";
        let FormValues = {
            baslik: $(`#sliderForm #baslik-${varsayilanDil}`).val(),
            altBaslik: $(`#sliderForm #altBaslik-${varsayilanDil}`).val(),
            butonIcerik: $(`#sliderForm #butonIcerik-${varsayilanDil}`).val(),
            butonUrl: $(`#sliderForm #butonUrl-${varsayilanDil}`).val(),
        };

        const FormKontrol = [
            {
                label: "Başlık",
                name: `baslik-${varsayilanDil}`,
                value: FormValues.baslik,
                required: true,
            },
            {
                label: "Alt Başlık",
                name: `altBaslik-${varsayilanDil}`,
                value: FormValues.altBaslik,
                required: true,
            },
            {
                label: "Buton İçerik",
                name: `butonIcerik-${varsayilanDil}`,
                value: FormValues.butonIcerik,
                required: true,
            },
            {
                label: "Buton Url",
                name: `butonUrl-${varsayilanDil}`,
                value: FormValues.butonUrl,
                required: true,
            },
        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol); */

    }
}

export default RPSliderForm;
