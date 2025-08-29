"use strict";

import useReal from "../../../../script/real.js";

class RPBlogForm {
    blogGorsel = null;
    froala = {};

    constructor() {
        const {FormKontrol, FilePonds} = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;
        this.init();
    }

    init() {
        this.BlogFormElement();
    }

    BlogFormElement() {
        const self = this;
        diller.forEach((dil) => {
            self.froala[dil] = new FroalaEditor(`#blogIcerik-${dil}`, {
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
                        if (typeof blogIcerik !== 'undefined' && blogIcerik[dil]) {
                            this.html.set(blogIcerik[dil]); // İçeriği ekler
                        }
                    }
                }
            });
        });
        self.blogGorsel = self.FilePonds(
            "#blogResim",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                maxFileSize: '10MB',
            }
        );

        if (typeof resimUrl !== 'undefined') {
            self.blogGorsel.addFile(resimUrl)
        }
    }

    BlogVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach(dil => {
            let FormValues = {
                [`baslik_${dil}`]: $(`#blogForm #baslik-${dil}`).val(),
                [`icerik_${dil}`]: self.froala[dil].html.get(),
                [`metaBaslik_${dil}`]: $(`#blogForm #metaBaslik-${dil}`).val(),
                [`metaIcerik_${dil}`]: $(`#blogForm #metaIcerik-${dil}`).val(),
                [`metaAnahtar_${dil}`]: $(`#blogForm #metaAnahtar-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        let files = self.blogGorsel.getFiles();
        if (files.length > 0) {
            formData.append(`resim`, files[0].file);
        }

        if ($('#blogForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    BlogFormKontrol() {
        const self = this;

        const FormId = "blogForm";
        let FormValues = {
            baslik: $(`#blogForm #baslik-${varsayilanDil}`).val(),
            icerik: self.froala[varsayilanDil].html.get(),
            metaBaslik: $(`#blogForm #metaBaslik-${varsayilanDil}`).val(),
            metaIcerik: $(`#blogForm #metaIcerik-${varsayilanDil}`).val(),
            metaAnahtar: $(`#blogForm #metaAnahtar-${varsayilanDil}`).val(),
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

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);

    }
}

export default RPBlogForm;
