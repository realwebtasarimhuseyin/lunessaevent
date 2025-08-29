// main.js
import useReal from "../../script/real.js";
const { Swall, FiyatFormati } = useReal();

document.addEventListener("DOMContentLoaded", function () {
    init();
    sepetiBaslat();
});

let sepetToplam = 0;

const Sepet = {
    urunler: [],

    sepeteEkle(urun, adet = 1) {
        let mevcutUrun = this.urunler.find(
            (item) =>
                JSON.stringify(item.varyantlar) ===
                JSON.stringify(urun.varyantlar) &&
                JSON.stringify(item.id) == JSON.stringify(urun.id)
        );

        if (mevcutUrun) {
            mevcutUrun.adet = Number(mevcutUrun.adet) + Number(adet);
        } else {
            this.urunler.push({ ...urun, adet });
        }
        this.sepetiKaydet();
    },

    sepettenCikar(sepetId, callback) {
        const self = this;
        axios
            .post(`${appUrl}/sepet/sil`, { sepet_id: sepetId })
            .then(function (response) {
                Swall({
                    icon: "success",
                    tiklamaDurum: false,
                    baslik: response.data.mesaj,
                });
                self.sepetiYukle();

                callback(true);
            })
            .catch(function (error) {
                Swall({
                    icon: "error",
                    baslik: error.response
                        ? error.response.data.mesaj
                        : "Bir hata oluştu.",
                    onayButonİcerik: "Tamam",
                });

                callback(false);
            });
    },

    sepetiTemizle() {
        const self = this;
        axios
            .post(`${appUrl}/sepet/tumsil`)
            .then(function (response) {
                self.sepetiYukle();
            })
            .catch(function (error) {
                console.log(error);
            });
    },

    sepetiKaydet() {
        const self = this;
        return axios
            .post(`${appUrl}/sepet/duzenle`, { urunler: self.urunler })
            .then(function (response) {
                Swall({
                    icon: "success",
                    tiklamaDurum: false,
                    baslik: response.data.mesaj,
                });

                self.sepetiYukle();

                return true;
            })
            .catch(function (error) {
                Swall({
                    icon: "error",
                    baslik: error.response
                        ? error.response.data.mesaj
                        : "Bir hata oluştu.",
                    onayButonİcerik: "Tamam",
                });

                self.sepetiYukle();
                return false;
            });
    },

    sepetiYukle() {
        const self = this;
        axios({
            method: "get",
            url: `${appUrl}/sepet/liste?dil=${aktifDil}`,
            responseType: "json",
        }).then(function (response) {
            const sepet = response.data;
            var urunler = sepet.urunler;

            self.urunler = [];

            if (!Array.isArray(urunler)) {
                urunler = [urunler];
            }

            urunler.forEach((sepetUrun) => {
                var urun = {
                    id: sepetUrun.urun_id,
                    adet: sepetUrun.adet,
                    birim_fiyat: sepetUrun.birim_fiyat,
                    sepet_id: sepetUrun.sepet_id,
                    varyantlar: [],
                };

                sepetUrun.varyantlar.forEach((varyant) => {
                    urun.varyantlar.push(varyant.urun_varyant_ozellik_id);
                });

                self.urunler.push(urun);
            });

            return self.sepetArayuzunuGuncelle(sepet, urunler);
        });
    },

    sepetArayuzunuGuncelle(sepet, urunler) {
        sepetToplam = sepet.sepet_toplam;
        const onIzlemeCnt = document.getElementById("sepet-onizleme-cnt");

        if (onIzlemeCnt) {
            const mevcutUrun = onIzlemeCnt.querySelectorAll(".pr");
            mevcutUrun.forEach((li) => li.remove());
        }

        if (urunler.length > 0) {
            urunler.forEach((item, index) => {
                if (onIzlemeCnt) {
                    const urunElement = document.createElement("li");
                    urunElement.classList.add("pr");
                    urunElement.setAttribute("sepet-id", item.sepet_id);
                    urunElement.innerHTML = `


                 <a href="#">
                    <img src="${item.ana_resim}" alt="">
                </a>
                <div>
                    <h6 class="mb-0"> ${item.urun_baslik}</h6>
                    <p>
                      ${Object.values(item.varyantlar)
                            .map((element) => {
                                return `${element.ana_varyant_isim} : ${element.urun_varyant_ozellik_isim}<br/>`;
                            })
                            .join("")}
                    </p>
                    <p>
                        ${item.adet} X ${FiyatFormati(item.birim_fiyat)}
                    </p>
                    
                </div>
                <i class="iconsax delete-icon sepetten-cikar-btn" data-icon="trash"></i>
                                    `;

                    /* 
                                        if (index !== urunler.length - 1) {
                                            const divider = document.createElement("hr");
                                            divider.classList.add("cart-drawer-divider");
                                            urunElement.appendChild(divider);
                                        } */

                    onIzlemeCnt.prepend(urunElement);
                }
            });

        } else {
            if (onIzlemeCnt) {
                const urunElement = document.createElement("li");
                urunElement.classList.add(
                    "mt-1",
                    "pr",
                    "text-center",
                    "d-block"
                );
                if (aktifDil == "tr") {
                    urunElement.innerHTML = `Sepetinizde ürün yok !`;
                } else {
                    urunElement.innerHTML = `There are no items in your cart !`;
                }
                onIzlemeCnt.prepend(urunElement);
            }
        }

        if (onIzlemeCnt) {
            $("#sepet-onizleme-tutar").html(
                FiyatFormati(sepet.sepet_toplam)
            );
        }

        if (sepet.kupon_tutar > 0) {

            var indirimTutarCnt = $("#indirimTutarCnt");
            indirimTutarCnt.removeClass("d-none");
            indirimTutarCnt.find("#sepetIndirimTutar").html(FiyatFormati(sepet.kupon_tutar));

            var kuponOnayCnt = $("#kuponOnayCnt");
            kuponOnayCnt.removeClass("d-none");
            kuponOnayCnt.find("#seciliKuponKodu").html(sepet.kupon_bilgi.kod);

            if (sepet.kupon_bilgi.yuzde > 0) {
                kuponOnayCnt.find("#kuponIndirimMiktar").html(sepet.kupon_bilgi.yuzde + "% indirim");
            } else if (sepet.kupon_bilgi.tutar > 0) {
                kuponOnayCnt.find("#kuponIndirimMiktar").html(sepet.kupon_bilgi.tutar + " TL indirim");
            }

            $("#kuponFormCnt").addClass("d-none");

        } else {
            var indirimTutarCnt = $("#indirimTutarCnt");
            indirimTutarCnt.addClass("d-none");
            indirimTutarCnt.find("#sepetIndirimTutar").html(FiyatFormati(0.00));

            var kuponOnayCnt = $("#kuponOnayCnt");
            kuponOnayCnt.addClass("d-none");
            kuponOnayCnt.find("#seciliKuponKodu").html('');

            kuponOnayCnt.find("#kuponIndirimMiktar").html('');
            kuponOnayCnt.find("#kuponIndirimMiktar").html('');


            $("#kuponFormCnt").removeClass("d-none");
        }

        $(".sepet-sayisi").html(sepet.sepet_adet);
        $(".sepetAraToplamTutar").html(FiyatFormati(sepet.ara_toplam));
        $(".sepetKdvToplamTutar").html(FiyatFormati(sepet.kdv_toplam));
        $(".sepetGenelToplamTutar").html(FiyatFormati(sepet.sepet_toplam));
        $(".sepetKargoTutar").html(FiyatFormati(sepet.kargo_tutar));
    },
};

const init = () => {
    $("input#urun-adet").on("change", function () {
        let val = Number($(this).val());
        if (isNaN(val) || val <= 0) {
            val = 1;
        }
        $(this).val(val);
    });

    /*     const quantityBlock = document.querySelectorAll(".list-product-main .quantity-block-sepet");
    
        quantityBlock.forEach((item) => {
    
    
            const minus = item.querySelector(".ph-minus");
            const plus = item.querySelector(".ph-plus");
            const quantity = item.querySelector(".quantity");
    
            if (Number(quantity.textContent) < 2) {
                minus.classList.add("disabled");
            }
    
            const updateCart = (element) => {
    
                const sepetSatir = $(element).closest(".item");
                const sepetId = sepetSatir.attr("sepet-id");
                const sepetAdet = parseInt(quantity.textContent, 10);
    
                if (isNaN(sepetAdet) || sepetAdet <= 1) {
                    quantity.innerHTML = "1";
                }
    
                const sepetToplamSutun = sepetSatir.find(".sepet-toplam-sutun");
                const sepetUrun = Sepet.urunler.find((urun) => urun.sepet_id === parseInt(sepetId));
    
                if (sepetUrun) {
                    sepetUrun.adet = sepetAdet;
                    const sepetSatirToplam = (sepetUrun.adet * sepetUrun.birim_fiyat).toFixed(2);
    
                     const saveResult = Sepet.sepetiKaydet();
                    console.log(saveResult); 
    
                    return Sepet.sepetiKaydet().then((result) => {
                        if (result) {
                            sepetToplamSutun.html(FiyatFormati(sepetSatirToplam));
                        }
                        return result;
                    });
    
                }
            };
    
            minus.addEventListener("click", (e) => {
                e.stopPropagation();
                if (Number(quantity.textContent) > 1) {
                    quantity.innerHTML = Number(quantity.innerHTML) - 1;
                    minus.classList.toggle("disabled", Number(quantity.textContent) <= 1);
                    updateCart(minus);
                }
            });
    
            plus.addEventListener("click", (e) => {
                e.stopPropagation();
                quantity.innerHTML = Number(quantity.innerHTML) + 1;
                minus.classList.remove("disabled");
                updateCart(plus);
            });
        }); */

    $(".btn-increase").on("click", function () {
        var quantityInput = $(this).closest(".wg-quantity").find(".quantity-product");
        var currentQuantity = parseInt(quantityInput.val()) || 0;
        quantityInput.val(currentQuantity + 1).trigger('change');
    });

    $(".btn-decrease").on("click", function () {
        var quantityInput = $(this).closest(".wg-quantity").find(".quantity-product");
        var currentQuantity = parseInt(quantityInput.val()) || 0;
        if (currentQuantity > 1) {
            quantityInput.val(currentQuantity - 1).trigger('change');
        }
    });



    $("#sepet-tablo").on("change", ".sepetUrunAdet", function () {
        var sepetSatir = $(this).closest("tr");
        var sepetId = sepetSatir.attr("sepet-id");
        var sepetAdetInput = $(this).val();
        var sepetAdet = parseInt(sepetAdetInput, 10);

        if (isNaN(sepetAdet) || sepetAdet <= 0) {
            sepetAdetInput.val(1);
            sepetAdet = 1;
        }

        var sepetToplamSutun = sepetSatir.find(".sepet-toplam-sutun");

        var sepetUrun = Sepet.urunler.find(
            (urun) => urun.sepet_id === parseInt(sepetId)
        );

        if (sepetUrun) {
            sepetUrun.adet = sepetAdet;
            var sepetSatirToplam = (
                sepetUrun.adet * sepetUrun.birim_fiyat
            ).toFixed(2);
        }

        return Sepet.sepetiKaydet().then((result) => {
            if (result) {
                sepetToplamSutun.html(FiyatFormati(sepetSatirToplam));
            }
            return result;
        });

    });

    $("#sepet-onizleme-cnt").on("click", ".sepetten-cikar-btn", function () {
        var sepetSatir = $(this).closest(".pr");
        var sepetId = sepetSatir.attr("sepet-id");

        Sepet.sepettenCikar(sepetId, function (result) {
            if (result) {
                sepetSatir.remove();
            }
        });
    });

    $(".sepete-ekle-btn").on("click", function () {
        const adet = Number($("#urun-adet").val());
        if (!adet || adet <= 0) {
            alert("Lütfen geçerli bir adet girin.");
            return;
        }

        let urun = {
            id: $(this).attr("urun-id"),
            varyantlar: [],
        };

        $(".varyantlar input:checked").each(function () {
            urun.varyantlar.push(Number($(this).val()));
        });

        Sepet.sepeteEkle(urun, adet);
    });

    $(".favori-ekle-btn").on("click", function () {
        const self = $(this); // Sadece tıklanan butonu hedef al
        const urunId = self.attr("urun-id");

        axios.post(`${appUrl}/favori/ekle`, { urun_id: urunId })
            .then(function () {
                self.addClass("d-none"); // Sadece tıklanan butonu gizle
                self.siblings(".favori-sil-btn").removeClass("d-none"); // Yanındaki sil butonunu göster
            })
            .catch(function (error) {
                console.log(error);
            });
    });

    $(".favori-sil-btn").on("click", function () {
        const self = $(this);
        const urunId = self.attr("urun-id");
        const favoriOge = self.closest(".favori-oge"); // Butonun bağlı olduğu ürün öğesini bul

        axios.post(`${appUrl}/favori/sil`, { urun_id: urunId })
            .then(function () {
                self.addClass("d-none"); // Sadece tıklanan butonu gizle
                self.siblings(".favori-ekle-btn").removeClass("d-none"); // Yanındaki ekleme butonunu göster

                favoriOge.remove(); // Ürünü listeden kaldır

                var tbody = $("#favoriTablo");
                if (tbody.find(".favori-oge").length === 0) {
                    tbody.append(`<div class="text-center col-12">Favorinizde ürün yok!</div>`);
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    });


    $(".sepetten-cikar-btn").on("click", function () {
        var sepetSatir = $(this).closest("tr");
        var sepetId = sepetSatir.attr("sepet-id");

        Sepet.sepettenCikar(sepetId, function (result) {
            if (result) {
                sepetSatir.remove();
                var tbody = $(".sepet-tablo");
                if (tbody.find("tr").length === 0) {
                    if (aktifDil == "tr") {
                        tbody.append(
                            `<tr col-span="5" class="text-center">Sepetinizde ürün yok ! </tr>`
                        );
                    } else {
                        tbody.append(
                            `<tr col-span="5" class="text-center"> There are no items in your cart ! </tr>`
                        );
                    }
                }
            }
        });
    });

    $("#kupon-btn").on("click", function () {
        var kuponKod = $("#kupon").val();

        axios
            .get(`${appUrl}/kupon/kontrol`, { params: { kupon_kod: kuponKod } })
            .then(function (response) {
                Swall({
                    icon: "success",
                    baslik: response.data.mesaj,
                    onayButonİcerik: "Tamam",
                });

                Sepet.sepetiYukle();
            })
            .catch(function (error) {
                Swall({
                    icon: "error",
                    baslik: error.response.data.mesaj,
                    onayButonİcerik: "Tamam",
                });
            });
    });

    $("#kupon-iptal").on("click", function () {
        axios
            .get(`${appUrl}/kupon/iptal`)
            .then(function (response) {
                Swall({
                    icon: "success",
                    baslik: response.data.mesaj,
                    onayButonİcerik: "Tamam",
                });

                Sepet.sepetiYukle();
            })
            .catch(function (error) {
                Swall({
                    icon: "error",
                    baslik: error.response.data.mesaj,
                    onayButonİcerik: "Tamam",
                });
            });
    });


    $("#kupon").on("keyup", function () {
        var kupon = $(this).val();

        if (kupon.length > 0) {
            $("#kupon-btn").removeClass("disabled");
        } else {
            $("#kupon-btn").addClass("disabled");
        }
    });

    $("#urun-filtre-btn").on("click", function () {
        const minFiyat = $("#min-price").val();
        const maxFiyat = $("#max-price").val();

        var seciliVaryantlar = [];

        $('.filtre-varyantlar .varyant:checked').each(function () {
            seciliVaryantlar.push($(this).attr('varyant-id'));
        });

        var varyantParam = seciliVaryantlar.join(',');

        var url = new URL(window.location.href);

        if (minFiyat) {
            url.searchParams.set('minFiyat', minFiyat);
        } else {
            url.searchParams.delete('minFiyat');
        }

        if (maxFiyat) {
            url.searchParams.set('maxFiyat', maxFiyat);
        } else {
            url.searchParams.delete('maxFiyat');
        }

        if (varyantParam) {
            url.searchParams.set('varyantlar', varyantParam);
        } else {
            url.searchParams.delete('varyantlar');
        }

        window.location.href = url.toString();
    });


    $("#filtre-sayfa-adet").on("change", function () {
        var url = new URL(window.location.href);
        url.searchParams.set("sayfa-adet", $(this).val());
        window.location.href = url.toString();
    });

    $(".filtre-select").on("change", function () {

        var url = new URL(window.location.href);
        var deger = $(this).val();

        if (deger === "ilgili") {
            url.searchParams.delete("filtre");
        } else {
            url.searchParams.set("filtre", deger);
        }

        window.location.href = url.toString();
    });

    $('form').on('submit', function (event) {
        event.preventDefault();
    });

    let axiosCancelSource; // To hold the cancel token source


    $("#filtre-arama").on("keyup", function () {
        const input = document.getElementById('filtre-arama').value.toLowerCase();
        const searchResults = document.querySelector(".preemptive-search");

        if (axiosCancelSource) {
            axiosCancelSource.cancel("Previous request was canceled due to new input.");
        }

        axiosCancelSource = axios.CancelToken.source();

        axios({
            method: 'get',
            url: `${appUrl}/urunler/ajax?q=${$(this).val()}&dil=${aktifDil}`,
            responseType: 'json',
            cancelToken: axiosCancelSource.token,
        })
            .then(function (response) {
                const urunler = response.data.data || [];
                searchResults.innerHTML = '';
                console.log(urunler , urunler.length);
                if (urunler.length > 0) {
                    urunler.forEach(urun => {
                        const colDiv = document.createElement("div");
                        colDiv.className = "col-xl-2 col-sm-4 col-6";

                        colDiv.innerHTML = `
                        <div class="product-box-6">
                            <div class="img-wrapper">
                                <div class="product-image">
                                    <a href="${urun.slug}">
                                        <img class="bg-img" src="${urun.ana_resim}" alt="${urun.urun_baslik}">
                                    </a>
                                </div>
                            </div>
                            <div class="product-detail">
                                <div>
                                    <a href="${urun.slug}">
                                        <h6>${urun.urun_baslik}</h6>
                                    </a>
                                    <p>${urun.fiyat} TL</p>
                                </div>
                            </div>
                        </div>
                    `;

                        searchResults.appendChild(colDiv);
                    });
                } else {
                    searchResults.innerHTML = "<h5>Sonuç bulunamadı.</h5>";
                }

                const bgImg = document.querySelectorAll(".bg-img");
                for (i = 0; i < bgImg.length; i++) {
                    let bgImgEl = bgImg[i];

                    if (bgImgEl.classList.contains("bg-top")) {
                        bgImgEl.parentNode.classList.add("b-top");
                    } else if (bgImgEl.classList.contains("bg-bottom")) {
                        bgImgEl.parentNode.classList.add("b-bottom");
                    } else if (bgImgEl.classList.contains("bg-center")) {
                        bgImgEl.parentNode.classList.add("b-center");
                    } else if (bgImgEl.classList.contains("bg-left")) {
                        bgImgEl.parentNode.classList.add("b-left");
                    } else if (bgImgEl.classList.contains("bg-right")) {
                        bgImgEl.parentNode.classList.add("b-right");
                    }

                    if (bgImgEl.classList.contains("blur-up")) {
                        bgImgEl.parentNode.classList.add("blur-up", "lazyload");
                    }

                    if (bgImgEl.classList.contains("bg_size_content")) {
                        bgImgEl.parentNode.classList.add("b_size_content");
                    }

                    bgImgEl.parentNode.classList.add("bg-size");
                    const bgSrc = bgImgEl.src;
                    bgImgEl.style.display = "none";
                    bgImgEl.parentNode.setAttribute(
                        "style",
                        `
                            background-image: url(${bgSrc});
                            background-size:cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            display: block;
                        `
                    );
                }
            })
            .catch(function (error) {
                if (!axios.isCancel(error)) {
                    console.error("Arama hatası:", error);
                }
            });
    });






    $("#filtre-arama-btn").on("click", function () {
        const action = $("#filtre-arama-form").attr("action");
        const aramaKelimesi = $("#filtre-arama").val();

        const url = new URL(action);
        url.searchParams.set("q", aramaKelimesi);

        window.location.href = url.toString();
    });

    $(".varyantlar").on("click", ".varyant", function () {
        const parentVaryantKutusu = $(this).closest(".varyantlar");
        parentVaryantKutusu.find(".varyant").removeClass("active");
        $(this).addClass("active");
    });

    $(".filtre-varyantlar").on("click", ".varyant", function () {
        $(this).toggleClass("active");
    });

    $("#urun-adet").change(function (e) {
        e.preventDefault();
        console.log(this.value);
    });



};

function sepetiBaslat() {
    Sepet.sepetiYukle();
}