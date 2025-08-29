"use strict";

import useReal from "../../../../script/real.js";

class RPProjeKategoriForm {
    projeKategoriGorsel = null;

    constructor() {
        const { FormKontrol, FilePonds } = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;
        this.init();
    }

    init() {
        this.ProjeKategoriFormElement();
    }

    ProjeKategoriFormElement() {
        const self = this;

        self.projeKategoriGorsel = self.FilePonds(
            "#kategoriResim",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'],
                maxFileSize: '10MB',
            }
        );

        if (typeof projeKategoriResimUrl !== 'undefined') {
            self.projeKategoriGorsel.addFile(projeKategoriResimUrl)
        }

    }

    ProjeKategoriVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach(dil => {
            let FormValues = {
                [`isim_${dil}`]: $(`#projeKategoriForm #isim-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        let files = self.projeKategoriGorsel.getFiles();
        if (files.length > 0) {
            files.forEach((fileItem, index) => {
                formData.append(`kategoriResim`, fileItem.file);
            });
        }


        if ($('#projeKategoriForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    ProjeKategoriFormKontrol() {
        const self = this;

        const FormId = "projeKategoriForm";
        let FormValues = {
            isim: $(`#projeKategoriForm #isim-${varsayilanDil}`).val(),
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

export default RPProjeKategoriForm;
