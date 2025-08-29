"use strict";

import useReal from "../../../../script/real.js";

class RPProjeForm {
    projeAnaGorsel = null;
    projeGorseller = null;

    tarih = null;

    froala = {};
    FormId = "projeForm";

    constructor() {
        const { FormKontrol, FilePonds } = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;

        this.init();
    }

    init() {
        this.ProjeFormElement();
    }

    ProjeFormElement() {
        const self = this;

        diller.forEach((dil) => {
            self.froala[dil] = new FroalaEditor(`#projeIcerik-${dil}`, {
                imageDefaultDisplay: 'inline',
                language: 'tr',
                toolbarButtons: [
                    ['undo', 'redo', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript'],
                    ['fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'lineHeight'],
                    ['paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent'],
                    ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'specialCharacters', 'fileManager'],
                    ['clearFormatting', 'selectAll', 'html', 'alert', 'clear', 'insert', 'print', 'fullscreen']
                ],
                pluginsEnabled: [
                    'align', 'charCounter', 'codeBeautifier', 'codeView', 'colors',
                    'draggable', 'emoticons', 'entities', 'fontFamily', 'fontSize',
                    'image', 'inlineClass', 'inlineStyle', 'lineBreaker', 'link',
                    'lists', 'paragraphFormat', 'paragraphStyle', 'lineHeight',
                    'quote', 'specialCharacters', 'table', 'url', 'wordPaste', 'print',
                    'imageTUI', 'video', 'fullscreen'
                ],
                imageInsertButtons: ['imageByURL'], // 🔒 Sadece URL'den resim eklenebilir
                videoInsertButtons: ['videoByURL'], // 🔒 Sadece URL'den video eklenebilir
                imageEditButtons: [
                    'imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen',
                    'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize', 'imageTUI'
                ],
                events: {
                    initialized: function () {
                        // Editör yüklendikten sonra içerik çekilebilir
                        if (typeof projeIcerik !== 'undefined' && projeIcerik[dil]) {
                            this.html.set(projeIcerik[dil]); // İçeriği ekler
                        }
                    }
                }
            });
        });

        self.projeAnaGorsel = self.FilePonds(
            "#anaResim",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ["image/png", "image/jpeg", 'image/webp'],
                maxFileSize: "10MB",
            }
        );

        self.projeGorseller = self.FilePonds(
            "#normalResimler",
            {
                allowReorder: true,
                allowMultiple: true,
                maxFiles: 30,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`, // Yükleme mesajı
                acceptedFileTypes: ["image/png", "image/jpeg", 'image/webp'],
                maxFileSize: "10MB"
            }
        );

        if (typeof anaResimUrl !== 'undefined') {
            self.projeAnaGorsel.addFile(anaResimUrl)
        }

        if (typeof normalResimlerUrl !== 'undefined') {

            normalResimlerUrl.forEach(resim => {
                self.projeGorseller.addFile(resim)
            });
        }

        $("#projeForm #ulke").on("change", function () {
            const ulkeId = $(this).val();
            if (ulkeId == 190) {
                $("#projeForm .ilContainer").removeClass("d-none");
            }
        });

    }

    ProjeVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach((dil) => {
            let FormValues = {
                [`baslik_${dil}`]: $(`#projeForm #baslik-${dil}`).val(),
                [`icerik_${dil}`]: self.froala[dil].html.get(),
                [`metaBaslik_${dil}`]: $(`#projeForm #metaBaslik-${dil}`).val(),
                [`metaIcerik_${dil}`]: $(`#projeForm #metaIcerik-${dil}`).val(),
                [`metaAnahtar_${dil}`]: $(`#projeForm #metaAnahtar-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        let projeAnaresimf = self.projeAnaGorsel.getFiles();
        if (projeAnaresimf.length > 0) {
            formData.append(`anaResim`, projeAnaresimf[0].file);
        }

        let files = self.projeGorseller.getFiles();
        if (files.length > 0) {
            files.forEach((fileItem, index) => {
                formData.append(`normalResimler[]`, fileItem.file);
            });
        }

        // formData.append(`kategori`, $(`#projeForm #projeKategori`).val());
        // formData.append(`il`, $(`#projeForm #il`).val());
        // formData.append(`tur`, $(`#projeForm #tur`).val());
        // formData.append(`alan`, $(`#projeForm #alan`).val());
        // formData.append(`asama`, $(`#projeForm #asama`).val());
        // formData.append(`tarih`, $(`#projeForm #tarih`).val());


        if ($("#projeForm #durum").is(":checked")) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    ProjeFormKontrol() {
        const self = this;

        let FormValues = {
            baslik: $(`#projeForm #baslik-${varsayilanDil}`).val(),
            icerik: self.froala[varsayilanDil].html.get(),
            metaBaslik: $(`#projeForm #metaBaslik-${varsayilanDil}`).val(),
            metaIcerik: $(`#projeForm #metaIcerik-${varsayilanDil}`).val(),
            metaAnahtar: $(`#projeForm #metaAnahtar-${varsayilanDil}`).val(),

            il: $(`#projeForm #il`).val(),
            tur: $(`#projeForm #tur`).val(),
            alan: $(`#projeForm #alan`).val(),
            asama: $(`#projeForm #asama`).val(),
            tarih: $(`#projeForm #tarih`).val(),
        };

        const FormKontrol = [
            {
                label: "Başlık",
                name: `baslik-${varsayilanDil}`,
                value: FormValues.baslik,
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

        return self.FormKontrol().validate(self.FormId, FormKontrol);
    }
}

export default RPProjeForm;
