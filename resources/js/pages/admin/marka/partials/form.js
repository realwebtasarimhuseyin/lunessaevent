"use strict";

import useReal from "../../../../script/real.js";

class RPMarkaForm {
    markaGorseller = null;
    quill = {};

    constructor() {
        const { FormKontrol, FilePonds } = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;
        this.init();
    }

    init() {
        this.MarkaFormElement();
    }

    MarkaFormElement() {
        const self = this;

        self.markaGorseller = self.FilePonds(
            "#markaResim",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                maxFileSize: '5MB',
            }
        );

        if (typeof resimUrl !== 'undefined') {
            self.markaGorseller.addFile(resimUrl)
        }
    }

    MarkaVeriler() {
        const self = this;

        let formData = new FormData();

        let FormValues = {
            isim: $("#markaForm #isim").val(),
        };

        formData.append("isim", FormValues.isim);

        let files = self.markaGorseller.getFiles();

        if (files.length > 0) {
            files.forEach((fileItem, index) => {
                formData.append(`resim`, fileItem.file);
            });
        }

        if ($('#markaForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    MarkaFormKontrol() {
        const self = this;

        const FormId = "markaForm";
        let FormValues = {
            isim: $(`#markaForm #isim`).val(),
        };

        const FormKontrol = [
            {
                label: "Marka İsim",
                name: `isim`,
                value: FormValues.isim,
                required: true,
            },
        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);

    }
}

export default RPMarkaForm;
