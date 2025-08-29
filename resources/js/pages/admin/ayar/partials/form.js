"use strict";

import useReal from "../../../../script/real.js";
import IMask from 'imask';

class RPAyarForm {
    ustLogo = null;
    altLogo = null;
    favicon = null;

    reklamBanner1Resim = {};
    reklamBanner2Resim = {};
    reklamBanner3Resim = {};

    reklamBanner4Resim = {};
    reklamBanner5Resim = {};
    reklamBanner6Resim = {};

    reklamBanner7Resim = {};

    constructor() {
        const { FormKontrol, FilePonds, Swall } = useReal();
        this.FormKontrol = FormKontrol;
        this.FilePonds = FilePonds;
        this.Swall = Swall;
        this.init();
    }

    init() {
        const self = this
        self.AyarFormElement();


        $("#siteMapGuncelle").on("click", function () {
            self.Swall({
                icon: "info",
                baslik: "Site Map Güncelleniyor",
                icerik: "Bu işlem biraz uzun süre bilir lütfen bekleyin ...",
                onayButonDurum: false
            });

            axios.post(`${panelUrl}/sitemap/guncelle`)
                .then(function (response) {
                    setTimeout(() => {
                        self.Swall({
                            icon: "success",
                            baslik: response.data,
                        });
                    }, 1000);
                })
                .catch(function (error) {
                    setTimeout(() => {
                        self.Swall({
                            icon: "success",
                            baslik: "Site Map Güncellenemedi !"
                        });
                    }, 1000);
                });
        });
    }

    AyarFormElement() {
        const self = this;


        const maskeler = [
            { elementId: 'telefon', maske: '+{90} 000 000 00 00' },
        ];

        maskeler.forEach(({ elementId, maske, bloklar }) => {
            const maskOptions = bloklar ? { mask: maske, blocks: bloklar } : { mask: maske };
            IMask(document.getElementById(elementId), maskOptions);
        });

        self.ustLogo = self.FilePonds(
            "#ustLogo-image",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                maxFileSize: '5MB',
            }
        );

        self.altLogo = self.FilePonds(
            "#altLogo-image",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                maxFileSize: '5MB',
            }
        );

        self.favicon = self.FilePonds(
            "#favicon-image",
            {
                allowMultiple: false,
                maxFiles: 1,
                labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                maxFileSize: '5MB',
            }
        );


        diller.forEach(dil => {

            self.reklamBanner1Resim[dil] = self.FilePonds(
                `#reklamBanner1-${dil}`,
                {
                    allowMultiple: false,
                    maxFiles: 1,
                    labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                    maxFileSize: '5MB',
                }
            );
        
            self.reklamBanner2Resim[dil] = self.FilePonds(
                `#reklamBanner2-${dil}`,
                {
                    allowMultiple: false,
                    maxFiles: 1,
                    labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                    maxFileSize: '5MB',
                }
            );
        
            self.reklamBanner3Resim[dil] = self.FilePonds(
                `#reklamBanner3-${dil}`,
                {
                    allowMultiple: false,
                    maxFiles: 1,
                    labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                    maxFileSize: '5MB',
                }
            );
        
            self.reklamBanner4Resim[dil] = self.FilePonds(
                `#reklamBanner4-${dil}`,
                {
                    allowMultiple: false,
                    maxFiles: 1,
                    labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                    maxFileSize: '5MB',
                }
            );
        
            self.reklamBanner5Resim[dil] = self.FilePonds(
                `#reklamBanner5-${dil}`,
                {
                    allowMultiple: false,
                    maxFiles: 1,
                    labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                    maxFileSize: '5MB',
                }
            );
        
            self.reklamBanner6Resim[dil] = self.FilePonds(
                `#reklamBanner6-${dil}`,
                {
                    allowMultiple: false,
                    maxFiles: 1,
                    labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                    maxFileSize: '5MB',
                }
            );

            self.reklamBanner7Resim[dil] = self.FilePonds(
                `#reklamBanner7-${dil}`,
                {
                    allowMultiple: false,
                    maxFiles: 1,
                    labelIdle: `Resminizi Sürükleyip Bırakın veya <span class="filepond--label-action">Tarayıcıdan Ekleyin</span>`,
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/webp'],
                    maxFileSize: '5MB',
                }
            );
    
        
            if (typeof reklamBanner1ResimUrl[dil] !== 'undefined') {
                self.reklamBanner1Resim[dil].addFile(reklamBanner1ResimUrl[dil]);
            }
        
            if (typeof reklamBanner2ResimUrl[dil] !== 'undefined') {
                self.reklamBanner2Resim[dil].addFile(reklamBanner2ResimUrl[dil]);
            }
        
            if (typeof reklamBanner3ResimUrl[dil] !== 'undefined') {
                self.reklamBanner3Resim[dil].addFile(reklamBanner3ResimUrl[dil]);
            }
        
            if (typeof reklamBanner4ResimUrl[dil] !== 'undefined') {
                self.reklamBanner4Resim[dil].addFile(reklamBanner4ResimUrl[dil]);
            }
        
            if (typeof reklamBanner5ResimUrl[dil] !== 'undefined') {
                self.reklamBanner5Resim[dil].addFile(reklamBanner5ResimUrl[dil]);
            }
        
            if (typeof reklamBanner6ResimUrl[dil] !== 'undefined') {
                self.reklamBanner6Resim[dil].addFile(reklamBanner6ResimUrl[dil]);
            }

            if (typeof reklamBanner7ResimUrl[dil] !== 'undefined') {
                self.reklamBanner7Resim[dil].addFile(reklamBanner7ResimUrl[dil]);
            }
        
        });
        


        if (typeof ustLogo !== 'undefined') {
            self.ustLogo.addFile(ustLogo)
        }
        if (typeof altLogo !== 'undefined') {
            self.altLogo.addFile(altLogo)
        }
        if (typeof favicon !== 'undefined') {
            self.favicon.addFile(favicon)
        }
    }

    AyarVeriler() {
        const self = this;

        let formData = new FormData();

        diller.forEach(dil => {
            let FormValues = {
                siteBaslik: $(`#ayarForm #siteBaslik-${dil}`).val(),
                siteAciklama: $(`#ayarForm #siteAciklama-${dil}`).val(),
                metaBaslik: $(`#ayarForm #metaBaslik-${dil}`).val(),
                metaIcerik: $(`#ayarForm #metaIcerik-${dil}`).val(),
                metaAnahtar: $(`#ayarForm #metaAnahtar-${dil}`).val(),

                reklamBanner1Baslik: $(`#ayarForm #reklamBanner1Baslik-${dil}`).val(),
                reklamBanner1AltBaslik: $(`#ayarForm #reklamBanner1AltBaslik-${dil}`).val(),
                reklamBanner1ButonIcerik: $(`#ayarForm #reklamBanner1ButonIcerik-${dil}`).val(),
                reklamBanner1Link: $(`#ayarForm #reklamBanner1Link-${dil}`).val(),

                reklamBanner2Baslik: $(`#ayarForm #reklamBanner2Baslik-${dil}`).val(),
                reklamBanner2AltBaslik: $(`#ayarForm #reklamBanner2AltBaslik-${dil}`).val(),
                reklamBanner2ButonIcerik: $(`#ayarForm #reklamBanner2ButonIcerik-${dil}`).val(),
                reklamBanner2Link: $(`#ayarForm #reklamBanner2Link-${dil}`).val(),

                reklamBanner3Baslik: $(`#ayarForm #reklamBanner3Baslik-${dil}`).val(),
                reklamBanner3AltBaslik: $(`#ayarForm #reklamBanner3AltBaslik-${dil}`).val(),
                reklamBanner3ButonIcerik: $(`#ayarForm #reklamBanner3ButonIcerik-${dil}`).val(),
                reklamBanner3Link: $(`#ayarForm #reklamBanner3Link-${dil}`).val(),

                reklamBanner4Baslik: $(`#ayarForm #reklamBanner4Baslik-${dil}`).val(),
                reklamBanner4AltBaslik: $(`#ayarForm #reklamBanner4AltBaslik-${dil}`).val(),
                reklamBanner4ButonIcerik: $(`#ayarForm #reklamBanner4ButonIcerik-${dil}`).val(),
                reklamBanner4Link: $(`#ayarForm #reklamBanner4Link-${dil}`).val(),

                reklamBanner5Baslik: $(`#ayarForm #reklamBanner5Baslik-${dil}`).val(),
                reklamBanner5AltBaslik: $(`#ayarForm #reklamBanner5AltBaslik-${dil}`).val(),
                reklamBanner5ButonIcerik: $(`#ayarForm #reklamBanner5ButonIcerik-${dil}`).val(),
                reklamBanner5Link: $(`#ayarForm #reklamBanner5Link-${dil}`).val(),

                reklamBanner6Baslik: $(`#ayarForm #reklamBanner6Baslik-${dil}`).val(),
                reklamBanner6AltBaslik: $(`#ayarForm #reklamBanner6AltBaslik-${dil}`).val(),
                reklamBanner6ButonIcerik: $(`#ayarForm #reklamBanner6ButonIcerik-${dil}`).val(),
                reklamBanner6Link: $(`#ayarForm #reklamBanner6Link-${dil}`).val(),

               /*  reklamBanner7Baslik: $(`#ayarForm #reklamBanner7Baslik-${dil}`).val(),
                reklamBanner7AltBaslik: $(`#ayarForm #reklamBanner7AltBaslik-${dil}`).val(),
                reklamBanner7ButonIcerik: $(`#ayarForm #reklamBanner7ButonIcerik-${dil}`).val(),
                reklamBanner7Link: $(`#ayarForm #reklamBanner7Link-${dil}`).val(),

                reklamBanner8Baslik: $(`#ayarForm #reklamBanner8Baslik-${dil}`).val(),
                reklamBanner8AltBaslik: $(`#ayarForm #reklamBanner8AltBaslik-${dil}`).val(),
                reklamBanner8ButonIcerik: $(`#ayarForm #reklamBanner8ButonIcerik-${dil}`).val(),
                reklamBanner8Link: $(`#ayarForm #reklamBanner8Link-${dil}`).val(),

                reklamBanner9Baslik: $(`#ayarForm #reklamBanner9Baslik-${dil}`).val(),
                reklamBanner9AltBaslik: $(`#ayarForm #reklamBanner9AltBaslik-${dil}`).val(),
                reklamBanner9ButonIcerik: $(`#ayarForm #reklamBanner9ButonIcerik-${dil}`).val(),
                reklamBanner9Link: $(`#ayarForm #reklamBanner9Link-${dil}`).val(),

                reklamBanner10Baslik: $(`#ayarForm #reklamBanner10Baslik-${dil}`).val(),
                reklamBanner10AltBaslik: $(`#ayarForm #reklamBanner10AltBaslik-${dil}`).val(),
                reklamBanner10ButonIcerik: $(`#ayarForm #reklamBanner10ButonIcerik-${dil}`).val(),
                reklamBanner10Link: $(`#ayarForm #reklamBanner10Link-${dil}`).val(), */


            };

            formData.append(`${dil}`, JSON.stringify(FormValues));


            let reklamBanner1Resimf = self.reklamBanner1Resim[dil].getFiles();
            if (reklamBanner1Resimf.length > 0) {
                formData.append(`reklamBanner1Resim-${dil}`, reklamBanner1Resimf[0].file);
            }
            
            let reklamBanner2Resimf = self.reklamBanner2Resim[dil].getFiles();
            if (reklamBanner2Resimf.length > 0) {
                formData.append(`reklamBanner2Resim-${dil}`, reklamBanner2Resimf[0].file);
            }
            
            let reklamBanner3Resimf = self.reklamBanner3Resim[dil].getFiles();
            if (reklamBanner3Resimf.length > 0) {
                formData.append(`reklamBanner3Resim-${dil}`, reklamBanner3Resimf[0].file);
            }
            
            let reklamBanner4Resimf = self.reklamBanner4Resim[dil].getFiles();
            if (reklamBanner4Resimf.length > 0) {
                formData.append(`reklamBanner4Resim-${dil}`, reklamBanner4Resimf[0].file);
            }
            
            let reklamBanner5Resimf = self.reklamBanner5Resim[dil].getFiles();
            if (reklamBanner5Resimf.length > 0) {
                formData.append(`reklamBanner5Resim-${dil}`, reklamBanner5Resimf[0].file);
            }
            
            let reklamBanner6Resimf = self.reklamBanner6Resim[dil].getFiles();
            if (reklamBanner6Resimf.length > 0) {
                formData.append(`reklamBanner6Resim-${dil}`, reklamBanner6Resimf[0].file);
            }

            let reklamBanner7Resimf = self.reklamBanner7Resim[dil].getFiles();
            if (reklamBanner7Resimf.length > 0) {
                formData.append(`reklamBanner7Resim-${dil}`, reklamBanner7Resimf[0].file);
            }
            
        });

        formData.append('eposta', $(`#ayarForm #eposta`).val());
        formData.append('telefon', $(`#ayarForm #telefon`).val());

        formData.append('adres', $(`#ayarForm #adres`).val());
        formData.append('iframeLink', $(`#ayarForm #iframeLink`).val());

        formData.append('smtpSunucuAdresi', $(`#ayarForm #smtpSunucuAdresi`).val());
        formData.append('smtpPort', $(`#ayarForm #smtpPort`).val());
        formData.append('smtpKullaniciAdi', $(`#ayarForm #smtpKullaniciAdi`).val());
        formData.append('smtpSifresi', $(`#ayarForm #smtpSifresi`).val());
        formData.append('guvenlikProtokolu', $(`#ayarForm #guvenlikProtokolu`).val());
        formData.append('gonderenAdi', $(`#ayarForm #gonderenAdi`).val());
        formData.append('gonderenEpostaAdresi', $(`#ayarForm #gonderenEpostaAdresi`).val());


        formData.append('facebook', $(`#ayarForm #facebook`).val());
        formData.append('twitter', $(`#ayarForm #twitter`).val());
        formData.append('instagram', $(`#ayarForm #instagram`).val());
        formData.append('pinterest', $(`#ayarForm #pinterest`).val());
        formData.append('youtube', $(`#ayarForm #youtube`).val());

        formData.append('scriptKod', btoa($(`#ayarForm #scriptKod`).val()));
        formData.append('scriptKodBody', btoa($(`#ayarForm #scriptKodBody`).val()));

        formData.append('banka', $(`#ayarForm #banka`).val());
        formData.append('bankaHesapSahibi', $(`#ayarForm #bankaHesapSahibi`).val());
        formData.append('bankaIban', $(`#ayarForm #bankaIban`).val());

        formData.append('duyuruIcerik', $(`#ayarForm #duyuruIcerik`).val());
        formData.append('duyuruButonIcerik', $(`#ayarForm #duyuruButonIcerik`).val());
        formData.append('duyuruLink', $(`#ayarForm #duyuruLink`).val());


        formData.append('sepetMinKargoTutari', $(`#ayarForm #sepetMinKargoTutari`).val());
        formData.append('kargoTutari', $(`#ayarForm #kargoTutari`).val());
        formData.append('ortalamaKargoSuresi', $(`#ayarForm #ortalamaKargoSuresi`).val());
        formData.append('kapidaOdemeTutar', $(`#ayarForm #kapidaOdemeTutar`).val());


        let ustLogof = self.ustLogo.getFiles();
        if (ustLogof.length > 0) {
            formData.append(`ustLogo`, ustLogof[0].file);
        }

        let altLogof = self.altLogo.getFiles();
        if (altLogof.length > 0) {
            formData.append(`altLogo`, altLogof[0].file);
        }
        let faviconf = self.favicon.getFiles();
        if (faviconf.length > 0) {
            formData.append(`favicon`, faviconf[0].file);
        }

        return formData;
    }

    AyarFormKontrol() {
        const self = this;

        const FormId = "ayarForm";
        let FormValues = {

            siteBaslik: $(`#ayarForm #siteBaslik-${varsayilanDil}`).val(),
            siteAciklama: $(`#ayarForm #siteAciklama-${varsayilanDil}`).val(),
            metaBaslik: $(`#ayarForm #metaBaslik-${varsayilanDil}`).val(),
            metaIcerik: $(`#ayarForm #metaIcerik-${varsayilanDil}`).val(),
            metaAnahtar: $(`#ayarForm #metaAnahtar-${varsayilanDil}`).val(),

            eposta: $(`#ayarForm #eposta`).val(),
            telefon: $(`#ayarForm #telefon`).val(),

            adres: $(`#ayarForm #adres`).val(),
            smtpSunucuAdresi: $(`#ayarForm #smtpSunucuAdresi`).val(),
            smtpPort: $(`#ayarForm #smtpPort`).val(),
            smtpKullaniciAdi: $(`#ayarForm #smtpKullaniciAdi`).val(),
            smtpSifresi: $(`#ayarForm #smtpSifresi`).val(),
            guvenlikProtokolu: $(`#ayarForm #guvenlikProtokolu`).val(),
            gonderenAdi: $(`#ayarForm #gonderenAdi`).val(),
            gonderenEpostaAdresi: $(`#ayarForm #gonderenEpostaAdresi`).val(),
        };

        const FormKontrol = [
            {
                label: "Site Başlık",
                name: `siteBaslik-${varsayilanDil}`,
                value: FormValues.siteBaslik,
                required: true,
            },
            {
                label: "Site Açıklama",
                name: `siteAciklama-${varsayilanDil}`,
                value: FormValues.siteAciklama,
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
                label: "E-posta",
                name: `eposta`,
                value: FormValues.eposta,
                required: true,
            },
            {
                label: "Telefon",
                name: `telefon`,
                value: FormValues.telefon,
                required: true,
            },
          
            {
                label: "Adres",
                name: `adres`,
                value: FormValues.adres,
                required: true,
            },
            {
                label: "SMTP Sunucu Adresi",
                name: `smtpSunucuAdresi`,
                value: FormValues.smtpSunucuAdresi,
                required: true,
            },
            {
                label: "SMTP Port",
                name: `smtpPort`,
                value: FormValues.smtpPort,
                required: true,
            },
            {
                label: "SMTP Kullanıcı Adı",
                name: `smtpKullaniciAdi`,
                value: FormValues.smtpKullaniciAdi,
                required: true,
            },
            {
                label: "SMTP Şifre",
                name: `smtpSifresi`,
                value: FormValues.smtpSifresi,
                required: true,
            },
            {
                label: "Güvenlik Protokolu",
                name: `guvenlikProtokolu`,
                value: FormValues.guvenlikProtokolu,
                required: true,
            },
            {
                label: "Gönderen Adı",
                name: `gonderenAdi`,
                value: FormValues.gonderenAdi,
                required: true,
            },
            {
                label: "Gönderen Eposta Adresi",
                name: `gonderenEpostaAdresi`,
                value: FormValues.gonderenEpostaAdresi,
                required: true,
            },
        ];

        return self
            .FormKontrol()
            .validate(FormId, FormKontrol);
    }
}

export default RPAyarForm;
