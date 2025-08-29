"use strict";

import useReal from "../../../../script/real.js";

class RPYorumForm {
    yorumGorsel = null;
    froala = {};

    constructor() {
        const {FormKontrol,FilePonds} = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;

        this.init();
    }

    init() {
        this.YorumFormElement();
    }

    YorumFormElement() {
        const self = this;

          diller.forEach((dil) => {
            self.froala[dil] = new FroalaEditor(`#icerik-${dil}`, {
                imageDefaultDisplay: 'inline',
                language: 'tr',
                toolbarButtons: [
                    ['undo', 'redo', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript'],
                    ['fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'lineHeight'],
                    ['paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent'],
                    ['insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'specialCharacters', 'fileManager'],
                    ['clearFormatting', 'selectAll', 'html', 'alert', 'clear', 'insert', 'print', 'fullscreen']
                ],
                pluginsEnabled: [
                    'align', 'charCounter', 'codeBeautifier', 'codeView', 'colors',
                    'draggable', 'emoticons', 'entities', 'fontFamily', 'fontSize',
                    'image', 'inlineClass', 'inlineStyle', 'lineBreaker', 'link',
                    'lists', 'paragraphFormat', 'paragraphStyle', 'lineHeight',
                    'quote', 'specialCharacters', 'table', 'url', 'wordPaste', 'print', 'file', 'filesManager',
                    'imageTUI', 'video', 'fullscreen'
                ],
                imageEditButtons: ['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen',
                    'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize', 'imageTUI'
                ],
                events: {
                    initialized: function () {
                        // Editör yüklendikten sonra içerik çekilebilir
                        if (typeof hizmetIcerik !== 'undefined' && hizmetIcerik[dil]) {
                            this.html.set(hizmetIcerik[dil]); // İçeriği ekler
                        }
                    }
                }
            });
        });

         self.yorumGorsel = self.FilePonds(
            "#product-images",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi veya Videonuzu Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`, // Yükleme mesajı
                acceptedFileTypes: [
                    'image/png', 'image/jpeg', 'image/webp',
                    'video/mp4', 'video/webm', 'video/ogg'
                ],
                maxFileSize: '10MB',
            }
        );

        if (typeof resimUrl !== 'undefined') {
            self.yorumGorsel.addFile(resimUrl)
        }

    }

    YorumVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach(dil => {
            let FormValues = {
                [`icerik_${dil}`]: self.froala[dil].html.get(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        let kisiIsim = $("#yorumForm #kisiIsim").val();
        let kisiUnvan = $("#yorumForm #kisiUnvan").val();

        formData.append(`kisiIsim`, kisiIsim);
        formData.append(`kisiUnvan`, kisiUnvan);

         let files = self.yorumGorsel.getFiles();

        if (files.length > 0) {
            files.forEach((fileItem, index) => {
                formData.append(`resim`, fileItem.file);
            });
        }

        if ($('#yorumForm #durum').is(':checked')) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    YorumFormKontrol() {
        const self = this;

        const FormId = "yorumForm";
        let FormValues = {
            kisiIsim: $(`#yorumForm #kisiIsim`).val(),
            kisiUnvan: $(`#yorumForm #kisiUnvan`).val(),
            icerik: self.froala[varsayilanDil].html.get(),
        };

        const FormKontrol = [

            {
                label: "Kişi İsim",
                name: `kisiIsim`,
                value: FormValues.kisiIsim,
                required: true,
            },

            {
                label: "Kişi Ünvan",
                name: `kisiUnvan`,
                value: FormValues.kisiUnvan,
                required: true,
            },

            {
                label: "İçerik",
                name: `icerik-${varsayilanDil}`,
                value: FormValues.icerik,
                required: true,
            },
        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);

    }
}

export default RPYorumForm;
