"use strict";

import useReal from "../../../../script/real.js";

class RPSektorlerForm {
    sektorlerResim = null;

    quill = {};

    constructor() {
        const { FormKontrol, FilePonds } = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;
        this.init();
    }

    init() {
        this.SektorlerFormElement();
    }

    SektorlerFormElement() {
        const self = this;

        const toolbarOptions = [
            ["bold", "italic", "underline", "strike"],
            ["blockquote", "code-block"],
            ["link", "image", "video", "formula"],

            [{ header: 1 }, { header: 2 }],
            [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
            [{ script: "sub" }, { script: "super" }],
            [{ indent: "-1" }, { indent: "+1" }],
            [{ direction: "rtl" }],

            [{ size: ["small", false, "large", "huge"] }],
            [{ header: [1, 2, 3, 4, 5, 6, false] }],

            [{ color: [] }, { background: [] }],
            [{ font: [] }],
            [{ align: [] }],

            ["clean"],
        ];

        diller.forEach((dil) => {
            self.quill[dil] = new Quill(`#icerik-${dil}`, {
                modules: {
                    toolbar: toolbarOptions,
                },
                placeholder: "Sektorler İçerik...",
                theme: "snow", // or 'bubble'
            });

            if (typeof sektorlerIcerik !== 'undefined') {
                self.quill[dil].root.innerHTML = (sektorlerIcerik[dil] ? sektorlerIcerik[dil] : "");
            }
        });

        self.sektorlerResim = self.FilePonds(
            ".sektorlerResim",
            {
                allowMultiple: false, // Tek dosya yüklemeye izin verir
                maxFiles: 1, // Yüklenebilecek maksimum dosya sayısı
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`, // Yükleme mesajı
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                maxFileSize: '10MB', // Maksimum dosya boyutu (isteğe bağlı)
            }
        );

      


        if (typeof sektorlerResimUrl !== 'undefined') {
            self.sektorlerResim.addFile(sektorlerResimUrl)
        }

     

    }

    SektorlerVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach(dil => {
            let FormValues = {
                [`baslik_${dil}`]: $(`#sektorlerForm #baslik-${dil}`).val(),
                [`kisaIcerik_${dil}`]: $(`#sektorlerForm #kisaIcerik-${dil}`).val(),
                [`icerik_${dil}`]: self.quill[dil].root.innerHTML,
                [`metaBaslik_${dil}`]: $(`#sektorlerForm #metaBaslik-${dil}`).val(),
                [`metaIcerik_${dil}`]: $(`#sektorlerForm #metaIcerik-${dil}`).val(),
                [`metaAnahtar_${dil}`]: $(`#sektorlerForm #metaAnahtar-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        let sektorlerResimf = self.sektorlerResim.getFiles();
        if (sektorlerResimf.length > 0) {
            formData.append(`sektorlerResim`, sektorlerResimf[0].file); // Dosyaları FormData'ya ekliyoruz
        }

       


        if ($('#sektorlerForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    SektorlerFormKontrol() {
        const self = this;

        const FormId = "sektorlerForm";
        let FormValues = {
            baslik: $(`#sektorlerForm #baslik-${varsayilanDil}`).val(),
            kisaIcerik: $(`#sektorlerForm #kisaIcerik-${varsayilanDil}`).val(),
            icerik: self.quill[varsayilanDil].root.innerText,
            metaBaslik: $(`#sektorlerForm #metaBaslik-${varsayilanDil}`).val(),
            metaIcerik: $(`#sektorlerForm #metaIcerik-${varsayilanDil}`).val(),
            metaAnahtar: $(`#sektorlerForm #metaAnahtar-${varsayilanDil}`).val(),
        };

        const FormKontrol = [
            {
                label: "Başlık",
                name: `baslik-${varsayilanDil}`,
                value: FormValues.baslik,
                required: true,
            },
            {
                label: "Kısa İçerik",
                name: `kisaIcerik-${varsayilanDil}`,
                value: FormValues.kisaIcerik,
                required: true,
            },
            {
                label: "İçerik",
                name: `icerik-${varsayilanDil}`,
                value: FormValues.icerik,
                required: true,
            },
            {
                label: "Meta Başlık",
                name: `metaBaslik-${varsayilanDil}`,
                value: FormValues.metaBaslik,
                required: true,
            },
            {
                label: "Meta Anahtar",
                name: `metaAnahtar-${varsayilanDil}`,
                value: FormValues.metaAnahtar,
                required: true,
            },
            {
                label: "Meta İçerik",
                name: `metaIcerik-${varsayilanDil}`,
                value: FormValues.metaIcerik,
                required: true,
            },
        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);

    }
}

export default RPSektorlerForm;
