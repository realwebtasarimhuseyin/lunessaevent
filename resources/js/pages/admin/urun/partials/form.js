"use strict";

import axios from "axios";
import useReal from "../../../../script/real.js";
import IMask from "imask";

class RPUrunForm {
    urunAnaGorsel = null;
    urunGorseller = null;
    froala = {};
    FormId = "urunForm";

    constructor() {
        const { FormKontrol, FilePonds } = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;
        this.init();
    }

    init() {
        this.UrunFormElement();

        $('.masked-input-sayi').each(function () {
            if (!$(this).data('masked')) {
                IMask(this, {
                    mask: Number,
                    scale: 2, // Ondalık basamak sayısı
                    signed: false, // Negatif değerlere izin verme
                    radix: ',', // Ondalık ayracı
                    thousandsSeparator: '.', // Binlik ayırıcı
                    mapToRadix: ['.'],
                });

                $(this).data('masked', true);
            }
        });

        $('.masked-input-indirim').each(function () {
            IMask(this, {
                mask: Number,
                scale: 2, // Ondalık basamak sayısı
                signed: false, // Negatif değerlere izin verme
                min: 0, // Minimum değer
                max: 100, // Maksimum değer
                radix: ',', // Ondalık ayracı
                thousandsSeparator: '.', // Binlik ayırıcı
            });
        });
    }

    UrunFormElement() {
        const self = this;

        diller.forEach((dil) => {
            self.froala[dil] = new FroalaEditor(`#urunIcerik-${dil}`, {
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
                        if (typeof urunIcerik !== 'undefined' && urunIcerik[dil]) {
                            this.html.set(urunIcerik[dil]); // İçeriği ekler
                        }
                    }
                }
            });
        });

        self.urunAnaGorsel = self.FilePonds(
            "#anaResim",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                maxFileSize: "10MB",
            }
        );

        self.urunGorseller = self.FilePonds(
            "#normalResimler",
            {
                allowReorder: true,
                allowMultiple: true,
                labelIdle: `Dosyalarınızı Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`, // Yükleme mesajı
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp', 'application/pdf'],
                maxFileSize: "25MB"
            }
        );

        if (typeof anaResimUrl !== 'undefined') {
            self.urunAnaGorsel.addFile(anaResimUrl)
        }

        if (typeof normalResimlerUrl !== 'undefined') {

            normalResimlerUrl.forEach(resim => {
                self.urunGorseller.addFile(resim)
            });
        }

        $(`#${self.FormId}`).on("change", "#urunKategori", function () {
            axios
                .get(`${panelUrl}/urunaltkategori/liste`, { urunKategori: this.value }, {})
                .then((response) => {

                    let options = ``;
                    $(`#${self.FormId} #urunAltKategori`).html('');

                    if (response.data.length > 0) {
                        response.data.forEach(element => {
                            options += `<option value="${element.id}">${element.isim}</option>`;
                        });
                        $(`#${self.FormId} #urunAltKategori`).html("<option value='' selected disabled>Ürün Alt Kategori Seç</option>").append(options)

                    }

                });
        });

        $(`#${self.FormId}`).on("change", "#indirimYuzde", function (e) {

            if (this.value > 0) {
                $('[name="indirimTutar"]').val("0").trigger("change");
            }

        });

        $(`#${self.FormId}`).on("change", "#indirimTutar", function (e) {

            if (this.value > 0) {
                $('[name="indirimYuzde"]').val("0").trigger("change");
            }

        });

        $(`#${self.FormId}`).on("click", "#kombinasyon-ekle", function (e) {
            setTimeout(function () {
                $('.masked-input-sayi').each(function () {
                    if (!$(this).data('masked')) {
                        IMask(this, {
                            mask: Number,
                            scale: 2, // Ondalık basamak sayısı
                            signed: false, // Negatif değerlere izin verme
                            radix: ',', // Ondalık ayracı
                            thousandsSeparator: '.', // Binlik ayırıcı
                            mapToRadix: ['.'],
                        });

                        $(this).data('masked', true);
                    }
                });
            }, 500);

        });
    }


    UrunVeriler() {
        const self = this;

        let formData = new FormData();

        const urunKategori = $("#urunForm #urunKategori").val();
        const urunAltKategori = ($("#urunForm #urunAltKategori").val() ? $("#urunForm #urunAltKategori").val() : null);
        const stokAdet = $("#urunForm #stokAdet").val().replace(/\./g, "").replace(/,/g, ".");
        const stokKod = $("#urunForm #stokKod").val();
        const kdvDurum = $("#urunForm #kdvDurum").val();
        const birimFiyat = $("#urunForm #birimFiyat").val().replace(/\./g, "").replace(/,/g, ".");
        const kdvOran = $("#urunForm #kdvOran").val();
        const marka = $("#urunForm #marka").val() ? $("#urunForm #marka").val() : null;
        const indirimYuzde = $("#urunForm #indirimYuzde").val().replace(/\./g, "").replace(/,/g, ".");
        const indirimTutar = $("#urunForm #indirimTutar").val().replace(/\./g, "").replace(/,/g, ".");

        diller.forEach((dil) => {
            let FormValues = {
                [`baslik_${dil}`]: $(`#urunForm #baslik-${dil}`).val(),
                [`icerik_${dil}`]: self.froala[dil].html.get(),
                [`metaBaslik_${dil}`]: $(`#urunForm #metaBaslik-${dil}`).val(),
                [`metaIcerik_${dil}`]: $(`#urunForm #metaIcerik-${dil}`).val(),
                [`metaAnahtar_${dil}`]: $(`#urunForm #metaAnahtar-${dil}`).val(),
            };

            formData.append(`${dil}`, JSON.stringify(FormValues));
        });

        formData.append("urunKategoriId", urunKategori);
        formData.append("urunAltKategoriId", urunAltKategori);
        formData.append("stokAdet", stokAdet);
        formData.append("stokKod", stokKod);
        formData.append("kdvDurum", kdvDurum);
        formData.append("birimFiyat", birimFiyat);
        formData.append("kdvOran", kdvOran);
        formData.append("marka", marka);
        formData.append("indirimYuzde", indirimYuzde);
        formData.append("indirimTutar", indirimTutar);

        let urunAnaresimf = self.urunAnaGorsel.getFiles();
        if (urunAnaresimf.length > 0) {
            formData.append(`anaResim`, urunAnaresimf[0].file);
        }

        let files = self.urunGorseller.getFiles();
        if (files.length > 0) {
            files.forEach((fileItem, index) => {
                formData.append(`normalResimler[]`, fileItem.file);
            });
        }

        const kombinasyonlar = $('.kombinasyon-satiri').map(function () {
            const satir = $(this);
            const kombinasyon = {
                varyantlar: []
            };

            satir.find('select').each(function () {
                const select = $(this);
                const varyantId = select.val(); // Sadece ID'yi alıyoruz
                if (varyantId) {
                    kombinasyon.varyantlar.push(varyantId); // ID'yi diziye ekliyoruz
                }
            });

            kombinasyon.fiyat = satir.find('.fiyat-input').val().replace(/\./g, "").replace(/,/g, ".");
            kombinasyon.stokKod = satir.find('.stok-kodu-input').val();
            kombinasyon.stokAdet = satir.find('.stok-adeti-input').val().replace(/\./g, "").replace(/,/g, ".");

            return kombinasyon;
        }).get();

        formData.append('kombinasyonlar', JSON.stringify(kombinasyonlar));

        /*         $('input[name="varyantlar[]"]:checked').each(function () {
                    formData.append('varyantlar[]', $(this).val());
                }); */

        if ($("#urunForm #ozelAlan1").is(":checked")) {
            formData.append(`ozelAlan1`, 1);
        } else {
            formData.append(`ozelAlan1`, 0);
        }

        if ($("#urunForm #ozelAlan2").is(":checked")) {
            formData.append(`ozelAlan2`, 1);
        } else {
            formData.append(`ozelAlan2`, 0);
        }

        if ($("#urunForm #durum").is(":checked")) {
            formData.append(`durum`, 1);
        } else {
            formData.append(`durum`, 0);
        }

        return formData;
    }

    UrunFormKontrol() {
        const self = this;

        let FormValues = {
            baslik: $(`#urunForm #baslik-${varsayilanDil}`).val(),
            icerik: self.froala[varsayilanDil].html.get(),
            metaBaslik: $(`#urunForm #metaBaslik-${varsayilanDil}`).val(),
            metaIcerik: $(`#urunForm #metaIcerik-${varsayilanDil}`).val(),
            metaAnahtar: $(`#urunForm #metaAnahtar-${varsayilanDil}`).val(),
            urunKategori: $("#urunForm #urunKategori").val(),
            stokAdet: $("#urunForm #stokAdet").val(),
            stokKod: $("#urunForm #stokKod").val(),
            kdvDurum: $("#urunForm #kdvDurum").val(),
            kdvOran: $("#urunForm #kdvOran").val(),
            birimFiyat: $("#urunForm #birimFiyat").val(),
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
            {
                label: "Ürün Kategori",
                name: `urunKategori`,
                value: FormValues.urunKategori,
                required: true,
            },
            {
                label: "Stok Adet",
                name: `stokAdet`,
                value: FormValues.stokAdet,
                required: true,
            },
            {
                label: "Stok Kod",
                name: `stokKod`,
                value: FormValues.stokKod,
                required: true,
            },
            {
                label: "Kdv Durum",
                name: `kdvDurum`,
                value: FormValues.kdvDurum,
                required: true,
            },
            {
                label: "Kdv Oran",
                name: `kdvOran`,
                value: FormValues.kdvOran,
                required: true,
            },
            {
                label: "Birim Fiyat",
                name: `birimFiyat`,
                value: FormValues.birimFiyat,
                required: true,
            },
        ];

        return self.FormKontrol().validate(self.FormId, FormKontrol);
    }
}

export default RPUrunForm;
