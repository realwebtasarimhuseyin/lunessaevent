"use strict";

import useReal from "../../../../script/real.js";

class RPUrunKategoriForm {
    urunKategoriGorsel = null;

    constructor() {
        const { FormKontrol, FilePonds } = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;
        this.init();
    }

    init() {
        this.UrunKategoriFormElement();
    }

    UrunKategoriFormElement() {
        const self = this;

        self.urunKategoriGorsel = self.FilePonds(
            "#kategoriResim",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'],
                maxFileSize: '10MB',
            }
        );

        if (typeof urunKategoriResimUrl !== 'undefined') {
            self.urunKategoriGorsel.addFile(urunKategoriResimUrl)
        }

    }

    UrunKategoriVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach(dil => {
            let FormValues = {
                [`isim_${dil}`]: $(`#urunKategoriForm #isim-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        let files = self.urunKategoriGorsel.getFiles();
        if (files.length > 0) {
            files.forEach((fileItem, index) => {
                formData.append(`kategoriResim`, fileItem.file);
            });
        }


        if ($('#urunKategoriForm #indirimDurum').is(':checked')) {
            formData.append(`indirimDurum`, 1);
        } else {
            formData.append(`indirimDurum`, 0);
        }


        if ($('#urunKategoriForm #menuDurum').is(':checked')) {
            formData.append(`menuDurum`, 1);
        } else {
            formData.append(`menuDurum`, 0);
        }

        if ($('#urunKategoriForm #anaSayfaDurum').is(':checked')) {
            formData.append(`anaSayfaDurum`, 1);
        } else {
            formData.append(`anaSayfaDurum`, 0);
        }

        if ($('#urunKategoriForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    UrunKategoriFormKontrol() {
        const self = this;

        const FormId = "urunKategoriForm";
        let FormValues = {
            isim: $(`#urunKategoriForm #isim-${varsayilanDil}`).val(),
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

export default RPUrunKategoriForm;
