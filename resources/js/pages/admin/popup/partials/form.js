"use strict";

import useReal from "../../../../script/real.js";

class RPPopupForm {
    popupTarih = null;
    popupResim = null;
    FormId = "popupForm";

    constructor() {
        const { FormKontrol, FilePonds, FlatPicker, ZamanFormati } = useReal();
        this.FilePonds = FilePonds;
        this.FormKontrol = FormKontrol; 
        this.FlatPicker = FlatPicker;
        this.ZamanFormati = ZamanFormati;
        this.init();
    }

    init() {
        this.PopupFormElement();
    }

    PopupFormElement() {
        const self = this;

        self.popupTarih = self.FlatPicker("tarih", fBaslangic, fBitis);

        self.popupResim = self.FilePonds(
            `#popupResim`,
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                maxFileSize: "10MB",
            }
        );

        if (typeof popupResimUrl !== 'undefined') {
            self.popupResim.addFile(popupResimUrl)
        }

    }

    PopupVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach(dil => {

            let FormValues = {
                baslik: $(`#popupForm #popupBaslik-${dil}`).val(),
                icerik: $(`#popupForm #popupIcerik-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        let popupResimf = self.popupResim.getFiles();

        if (popupResimf.length > 0) {
            formData.append(`popupResim`, popupResimf[0].file);
        }

        formData.append("baslangic_tarih", self.ZamanFormati(self.popupTarih.selectedDates[0]));
        formData.append("bitis_tarih", self.ZamanFormati(self.popupTarih.selectedDates[1]));

        if ($('#popupForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    PopupFormKontrol() {
        const self = this;
        const FormId = "popupForm";

        let FormValues = {
            baslik: $(`#popupForm #popupBaslik-${varsayilanDil}`).val(),
            icerik: $(`#popupForm #popupIcerik-${varsayilanDil}`).val(),


            baslangic_tarih: self.ZamanFormati(self.popupTarih.selectedDates[0]).replace(/-/g, ''),
        };


        const FormKontrol = [
            {
                label: "Popup Başlık",
                name: `popupBaslik-${varsayilanDil}`,
                value: FormValues.baslik,
                required: true,
            },

            {
                label: "Popup İçerik",
                name: `popupIcerik-${varsayilanDil}`,
                value: FormValues.icerik,
                required: true,
            },

            {
                label: "Popup Tarih",
                name: `tarih`,
                value: FormValues.baslangic_tarih,
                required: true,
            },

        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);

    }
}

export default RPPopupForm;
