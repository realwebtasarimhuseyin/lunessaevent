"use strict";

import useReal from "../../../../script/real.js";

class RPHizmetForm {
  hizmetResim = null;

  froala = {};

  constructor() {
    const { FormKontrol, FilePonds } = useReal();
    this.FormKontrol = FormKontrol;
    this.FilePonds = FilePonds;
    this.init();
  }

  init() {
    this.HizmetFormElement();
  }

  HizmetFormElement() {
    const self = this;

    diller.forEach((dil) => {
      self.froala[dil] = new FroalaEditor(`#hizmetIcerik-${dil}`, {
        imageDefaultDisplay: "inline",
        language: "tr",
        toolbarButtons: [
          [
            "undo",
            "redo",
            "bold",
            "italic",
            "underline",
            "strikeThrough",
            "subscript",
            "superscript",
          ],
          [
            "fontFamily",
            "fontSize",
            "textColor",
            "backgroundColor",
            "inlineClass",
            "inlineStyle",
            "lineHeight",
          ],
          [
            "paragraphFormat",
            "align",
            "formatOL",
            "formatUL",
            "outdent",
            "indent",
          ],
          [
            "insertLink",
            "insertImage",
            "insertVideo",
            "insertFile",
            "insertTable",
            "specialCharacters",
            "fileManager",
          ],
          [
            "clearFormatting",
            "selectAll",
            "html",
            "alert",
            "clear",
            "insert",
            "print",
            "fullscreen",
          ],
        ],
        pluginsEnabled: [
          "align",
          "charCounter",
          "codeBeautifier",
          "codeView",
          "colors",
          "draggable",
          "emoticons",
          "entities",
          "fontFamily",
          "fontSize",
          "image",
          "inlineClass",
          "inlineStyle",
          "lineBreaker",
          "link",
          "lists",
          "paragraphFormat",
          "paragraphStyle",
          "lineHeight",
          "quote",
          "specialCharacters",
          "table",
          "url",
          "wordPaste",
          "print",
          "file",
          "filesManager",
          "imageTUI",
          "video",
          "fullscreen",
        ],
        imageEditButtons: [
          "imageReplace",
          "imageAlign",
          "imageRemove",
          "|",
          "imageLink",
          "linkOpen",
          "linkEdit",
          "linkRemove",
          "-",
          "imageDisplay",
          "imageStyle",
          "imageAlt",
          "imageSize",
          "imageTUI",
        ],
        events: {
          initialized: function () {
            // Editör yüklendikten sonra içerik çekilebilir
            if (typeof hizmetIcerik !== "undefined" && hizmetIcerik[dil]) {
              this.html.set(hizmetIcerik[dil]); // İçeriği ekler
            }
          },
        },
      });
    });

    self.hizmetResim = self.FilePonds(".hizmetResim", {
      allowMultiple: false, // Tek dosya yüklemeye izin verir
      maxFiles: 1, // Yüklenebilecek maksimum dosya sayısı
      labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`, // Yükleme mesajı
      acceptedFileTypes: ["image/png", "image/jpeg", "image/webp"],
      maxFileSize: "10MB", // Maksimum dosya boyutu (isteğe bağlı)
    });

    if (typeof hizmetResimUrl !== "undefined") {
      self.hizmetResim.addFile(hizmetResimUrl);
    }
  }

  HizmetVeriler() {
    const self = this;

    let formData = new FormData();

    diller.forEach((dil) => {
      let FormValues = {
        [`baslik_${dil}`]: $(`#hizmetForm #baslik-${dil}`).val(),
        [`kisaIcerik_${dil}`]: $(`#hizmetForm #kisaIcerik-${dil}`).val(),
        [`icerik_${dil}`]: self.froala[dil].html.get(),
        [`metaBaslik_${dil}`]: $(`#hizmetForm #metaBaslik-${dil}`).val(),
        [`metaIcerik_${dil}`]: $(`#hizmetForm #metaIcerik-${dil}`).val(),
        [`metaAnahtar_${dil}`]: $(`#hizmetForm #metaAnahtar-${dil}`).val(),
      };

      formData.append(`${dil}`, JSON.stringify(FormValues));
    });

    let hizmetResimf = self.hizmetResim.getFiles();
    if (hizmetResimf.length > 0) {
      formData.append(`hizmetResim`, hizmetResimf[0].file); // Dosyaları FormData'ya ekliyoruz
    }

    if ($("#hizmetForm #durum").is(":checked")) {
      formData.append(`durum`, 1);
    } else {
      formData.append(`durum`, 0);
    }

    return formData;
  }

  HizmetFormKontrol() {
    const self = this;

    const FormId = "hizmetForm";
    let FormValues = {
      baslik: $(`#hizmetForm #baslik-${varsayilanDil}`).val(),
      kisaIcerik: $(`#hizmetForm #kisaIcerik-${varsayilanDil}`).val(),
      icerik: self.froala[varsayilanDil].html.get(),
      metaBaslik: $(`#hizmetForm #metaBaslik-${varsayilanDil}`).val(),
      metaIcerik: $(`#hizmetForm #metaIcerik-${varsayilanDil}`).val(),
      metaAnahtar: $(`#hizmetForm #metaAnahtar-${varsayilanDil}`).val(),
    };

    const FormKontrol = [
      // {
      //     label: "Kategori",
      //     name: `hizmetKategori`,
      //     value: FormValues.kategori,
      //     required: false,
      // },

      {
        label: "Başlık",
        name: `baslik-${varsayilanDil}`,
        value: FormValues.baslik,
        required: true,
      },
      // {
      //     label: "Kısa İçerik",
      //     name: `kisaIcerik-${varsayilanDil}`,
      //     value: FormValues.kisaIcerik,
      //     required: true,
      // },
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

    return self.FormKontrol().validate(FormId, FormKontrol);
  }
}

export default RPHizmetForm;
