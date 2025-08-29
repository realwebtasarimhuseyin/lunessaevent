"use strict";

import axios from "axios";
import useReal from "../../../../script/real.js";

class RPSSSForm {
    froala = {};
    FormId = "sssForm";

    constructor() {
        const {FormKontrol} = useReal();
        this.FormKontrol = FormKontrol; // FormKontrol fonksiyonunu sınıfın bir parçası yapıyoruz.
        this.init();
    }

    init() {
        this.SSSFormElement();
    }

    SSSFormElement() {
        const self = this;
        diller.forEach((dil) => {
            self.froala[dil] = new FroalaEditor(`#sssIcerik-${dil}`, {
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
                        if (typeof sssIcerik !== 'undefined' && sssIcerik[dil]) {
                            this.html.set(sssIcerik[dil]); // İçeriği ekler
                        }
                    }
                }
            });
        });
    }

    SSSVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach((dil) => {
            let FormValues = {
                [`baslik_${dil}`]: $(`#sssForm #baslik-${dil}`).val(),
                [`icerik_${dil}`]: self.froala[dil].html.get(),

            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        if ($("#sssForm #durum").is(":checked")) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    SSSFormKontrol() {
        const self = this;

        let FormValues = {
            baslik: $(`#sssForm #baslik-${varsayilanDil}`).val(),
            icerik: self.froala[varsayilanDil].html.get(),

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


        ];

        return self.FormKontrol().validate(self.FormId, FormKontrol);
    }
}

export default RPSSSForm;
