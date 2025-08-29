"use strict";

import useReal from "../../../../script/real.js";

class RPSayfaYonetimForm {
    sayfaYonetimGorseller = null;
    froala = {};

    constructor() {
        const {FormKontrol, FilePonds} = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;
        this.init();
    }

    init() {
        this.SayfaYonetimFormElement();
    }

    SayfaYonetimFormElement() {
        const self = this;
        diller.forEach((dil) => {
            self.froala[dil] = new FroalaEditor(`#sayfaYonetimIcerik-${dil}`, {
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
                        if (typeof sayfaYonetimIcerik !== 'undefined' && sayfaYonetimIcerik[dil]) {
                            this.html.set(sayfaYonetimIcerik[dil]); // İçeriği ekler
                        }
                    }
                }
            });
        });

        self.sayfaYonetimResim = self.FilePonds(
            "#sayfaYonetimResim",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                maxFileSize: '10MB',
            }
        );

        if (typeof resimUrl !== 'undefined') {
            self.sayfaYonetimResim.addFile(resimUrl)
        }

    }

    SayfaYonetimVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach(dil => {
            let FormValues = {
                [`icerik_${dil}`]: self.froala[dil].html.get(),
                [`sayfaIcerikBaslik_${dil}`]: $(`#sayfaYonetimForm #sayfaIcerikBaslik-${dil}`).val(),
                [`metaBaslik_${dil}`]: $(`#sayfaYonetimForm #metaBaslik-${dil}`).val(),
                [`metaIcerik_${dil}`]: $(`#sayfaYonetimForm #metaIcerik-${dil}`).val(),
                [`metaAnahtar_${dil}`]: $(`#sayfaYonetimForm #metaAnahtar-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        if ($('#sayfaYonetimForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        let sayfaYonetimResimf = self.sayfaYonetimResim.getFiles();
        if (sayfaYonetimResimf.length > 0) {
            formData.append(`resim`, sayfaYonetimResimf[0].file);
        }

        return formData;
    }

    SayfaYonetimFormKontrol() {
        const self = this;

        const FormId = "sayfaYonetimForm";
        let FormValues = {
            icerik: self.froala[varsayilanDil].html.get(),
            sayfaIcerikBaslik: $(`#sayfaYonetimForm #sayfaIcerikBaslik-${varsayilanDil}`).val(),
            metaBaslik: $(`#sayfaYonetimForm #metaBaslik-${varsayilanDil}`).val(),
            metaIcerik: $(`#sayfaYonetimForm #metaIcerik-${varsayilanDil}`).val(),
            metaAnahtar: $(`#sayfaYonetimForm #metaAnahtar-${varsayilanDil}`).val(),
        };

        const FormKontrol = [
            {
                label: "İçerik",
                name: `icerik-${varsayilanDil}`,
                value: FormValues.icerik,
                required: true,
            },
            {
                label: "Başlık",
                name: `sayfaIcerikBaslik-${varsayilanDil}`,
                value: FormValues.sayfaIcerikBaslik,
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

export default RPSayfaYonetimForm;
