"use strict";

import useReal from "../../../../script/real.js";

class RPKatalogForm {
    katalogAnaGorsel = null;
    katalogGorseller = null;

    FormId = "katalogForm";

    constructor() {
        const { FormKontrol, FilePonds } = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;

        this.init();
    }

    init() {
        this.KatalogFormElement();
    }

    KatalogFormElement() {
        const self = this;

        self.katalogAnaGorsel = self.FilePonds(
            "#anaResim",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ["image/png", "image/jpeg", 'image/webp'],
                maxFileSize: "10MB",
            }
        );
        if (typeof anaResimUrl !== 'undefined') {
            self.katalogAnaGorsel.addFile(anaResimUrl)
        }
        self.katalogDosya = self.FilePonds(
            "#katalogDosya",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Dosyalarınızı Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ['application/pdf', 'application/zip', 'text/plain', 'application/msword', 'application/vnd.ms-excel'],
            }
        );
        if (typeof katalogDosyaUrl !== 'undefined') {
            self.katalogDosya.addFile(katalogDosyaUrl)
        }
    }

    KatalogVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach((dil) => {
            let FormValues = {
                [`baslik_${dil}`]: $(`#katalogForm #baslik-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        let katalogAnaresimf = self.katalogAnaGorsel.getFiles();
        if (katalogAnaresimf.length > 0) {
            formData.append(`anaResim`, katalogAnaresimf[0].file);
        }

        let katalogDosyaf = self.katalogDosya.getFiles();
        if (katalogDosyaf.length > 0) {
            formData.append(`katalogDosya`, katalogDosyaf[0].file);
        }

        // formData.append(`kategori`, $(`#katalogForm #katalogKategori`).val());


        if ($("#katalogForm #durum").is(":checked")) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    KatalogFormKontrol() {
        const self = this;

        let FormValues = {
            baslik: $(`#katalogForm #baslik-${varsayilanDil}`).val(),
        };

        const FormKontrol = [
            {
                label: "Başlık",
                name: `baslik-${varsayilanDil}`,
                value: FormValues.baslik,
                required: true,
            },


        ];

        return self.FormKontrol().validate(self.FormId, FormKontrol);
    }
}

export default RPKatalogForm;
