"use strict";

import useReal from "../../../../script/real.js";

class RPHizmetKategoriForm {
    hizmetKategoriGorsel = null;
    /* quill = {}; */

    constructor() {
        const { FormKontrol, FilePonds } = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;
        this.init();
    }

    init() {
        this.HizmetKategoriFormElement();
    }

    HizmetKategoriFormElement() {
        const self = this;

        self.hizmetKategoriGorsel = self.FilePonds(
            "#kategoriResim",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'],
                maxFileSize: '10MB',
            }
        );

        if (typeof hizmetKategoriResimUrl !== 'undefined') {
            self.hizmetKategoriGorsel.addFile(hizmetKategoriResimUrl)
        }

    }

    HizmetKategoriVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach(dil => {
            let FormValues = {
                [`isim_${dil}`]: $(`#hizmetKategoriForm #isim-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        let files = self.hizmetKategoriGorsel.getFiles();
        if (files.length > 0) {
            files.forEach((fileItem, index) => {
                formData.append(`kategoriResim`, fileItem.file);
            });
        }


        if ($('#hizmetKategoriForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    HizmetKategoriFormKontrol() {
        const self = this;

        const FormId = "hizmetKategoriForm";
        let FormValues = {
            isim: $(`#hizmetKategoriForm #isim-${varsayilanDil}`).val(),
        };

        const FormKontrol = [
            {
                label: "Başlık",
                name: `isim-${varsayilanDil}`,
                value: FormValues.isim,
                required: true,
            },
        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);

    }
}

export default RPHizmetKategoriForm;
