import * as bootstrap from "../bootstrap";
import fl_tr from "../../../public/admin/plugins/filepond/tr.js"


export default function useReal() {
    const datatables = {
        language: {
            info: "_TOTAL_ kayıttan _START_ ile _END_ arası gösteriliyor",
            emptyTable: "Tablo Boş",
            infoFiltered: "",
            infoEmpty: "0 kayıttan 0 ile 0 arası gösteriliyor",
            zeroRecords: "Hiçbir eşleşen kayıt bulunamadı",
            loadingRecords: "Yükleniyor...",
            lengthMenu: " _MENU_ Sayfa başına kayıt",
            paginate: {
                sPrevious:
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
            },
        },
    };

    function FilePonds(elementId, nitelikler) {

        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginImageExifOrientation,
            FilePondPluginImagePreview,
            FilePondPluginImageCrop,
            FilePondPluginImageResize,
            FilePondPluginImageTransform,
            FilePondPluginMediaPreview
        );

        FilePond.setOptions(fl_tr
            , {
                imagePreviewHeight: 150,
                imagePreviewWidth: 150,
                imagePreviewFit: 'cover',
                imageCropAspectRatio: '1:1',
            });


        return FilePond.create(
            document.querySelector(elementId),
            nitelikler
        );

    }

    function FormKontrol() {
        let Hatalar = {};

        function FormVlSifirla() {
            $(".lvvl *").remove(".hata");
            $(".lvvl .input").removeClass("border-danger");
        }

        return {
            FormVlSifirla: FormVlSifirla,
            validate: function (formId, formElements) {
                const FormElement = formElements;

                function HataMetni(name, mesaj) {
                    const Input = $(`#${formId} [name='${name}']`);
                    Input.addClass("border-danger");
                    const ustElement = Input.closest(".lvvl");
                    ustElement.append(
                        `<div class="mt-1 d-block text-danger hata">${mesaj}</div>`
                    );
                }

                FormVlSifirla();
                Hatalar = {};
                let isValid = true;

                FormElement.forEach((element) => {

                    let Hata = [];
                    if (element.required && (element.value == null || element.value == undefined || element.value.trim() == "")) {
                        const mesaj = `${element.label} boş bırakılamaz!`;
                        HataMetni(element.name, mesaj);
                        Hata.push([mesaj]);
                    }

                    if (element.type == "email" && element.value.trim() !== "") {
                        const emailRegex = /^[a-z0-9.]+@[a-z]+\.[a-z]{2,}$/i;

                        console.log("deeneme")
                        if (!emailRegex.test(element.value)) {
                            const mesaj = `${element.label} geçersiz formatta!`;
                            HataMetni(element.name, mesaj);
                            Hata.push(mesaj);
                        }
                    }

                    if (
                        element.maxUzunluk &&
                        element.value.length > element.maxUzunluk
                    ) {
                        const mesaj = `${element.label} en fazla ${element.maxUzunluk} karakter olmalıdır!`;
                        HataMetni(element.name, mesaj);
                        Hata.push([mesaj]);
                    }

                    if (
                        element.minUzunluk &&
                        element.minUzunluk > element.value.length
                    ) {
                        const mesaj = `${element.label} en az ${element.minUzunluk} karakter olmalıdır!`;
                        HataMetni(element.name, mesaj);
                        Hata.push([mesaj]);
                    }

                    if (Hata.length > 0) {
                        Hatalar[element.name] = Hata;
                        isValid = false;
                    }
                });

                return isValid;
            },
        };
    }

    function FormSifirla() {
        $('input, textarea, select').each(function () {
            if ($(this).is(':checkbox') || $(this).is(':radio')) {
                $(this).prop('checked', false);
            } else {
                $(this).val('');
            }
        });
    
        const quillInstances = document.querySelectorAll('.ql-container');
        quillInstances.forEach(container => {
            if (container.__quill) {
                container.__quill.setContents([]);
            }
        });
    
        const fileInputs = document.querySelectorAll('.filepond');
        fileInputs.forEach(input => {
            const pondInstance = FilePond.find(input);
            if (pondInstance) {
                pondInstance.removeFiles();
            }
        });
    }
    

    function ZamanFormati(zaman, tip = "full") {
        if (zaman) {
            if (tip == "full") {
                return moment(zaman, "YYYY-MM-DD HH:mm:ss").format(
                    "DD.MM.YYYY HH:mm"
                );
            } else if (tip == "date") {
                return moment(zaman, "YYYY-MM-DD HH:mm:ss").format(
                    "DD.MM.YYYY"
                );
            } else if (tip == "time") {
                return moment(zaman, "HH:mm:ss").format("HH:mm");
            }
        } else {
            return "-";
        }
    }

    function FiyatFormati(para = 0.0, doviz = "TL") {
        para = para > 0 ? para : 0;

        return (
            parseFloat(para).toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }) +
            " " +
            doviz
        );
    }

    function FormYukleniyor(mesaj) {
        return Swal.fire({
            text: mesaj,
            icon: "info",
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: {
                popup: "py-3 px-4 dark:text-white dark:bg-zinc-800 rounded-lg border dark:border-0 shadow",
                icon: "my-3",
            },
        });
    }

    function FormTamamlandi(mesaj) {
        Swal.close();
        return Swal.fire({
            text: mesaj,
            icon: "success",
            confirmButtonText: "Tamam!",
            customClass: {
                popup: "py-3 px-4 dark:text-white dark:bg-zinc-800 rounded-lg border dark:border-0 shadow",
                icon: "my-3",
                confirmButton:
                    "inline-flex items-center justify-center border-transparent font-medium rounded-md shadow-sm focus:outline-none text-center bg-green-500 text-white hover:bg-green-700 focus:ring-green-500 text-base px-5 py-1.5",
            },
        });
    }

    function FormGondermeOnay(mesaj) {
        Swal.close();
        return Swal.fire({
            title: mesaj,
            icon: "info",
            showCancelButton: true,
            cancelButtonText: "Hayır, İptal!",
            confirmButtonText: "Evet, Onayla!",

        });
    }

    function DataTables(tablo) {
        return new DataTable(`#${tablo.id}`, {
            searching: false,
            responsive: true,
            serverSide: false,
            stateSave: false,
            ordering: false,
            paging: true,
            language: datatables.language,
            data: tablo.data,
            columns: tablo.sutunlar,
            columnDefs: tablo.sutunTanim,
            dom: 't <"mt-5" <"flex justify-between items-center" li> <"flex justify-center items-center" p> >',
            rowReorder: {
                selector: 'tr'
            },
            buttons: tablo.buttons
                ? [
                    {
                        extend: "print",
                        filename: tablo.buttons.print.dosyaAdi,
                        title: tablo.buttons.print.baslik,
                        header: true,
                        footer: true,
                        exportOptions: {
                            columns: tablo.buttons.print.tabloSutun,
                        },
                    },
                    {
                        extend: "excelHtml5",
                        filename: tablo.buttons.excel.dosyaAdi,
                        title: tablo.buttons.excel.baslik,
                        header: true,
                        footer: true,
                        exportOptions: {
                            columns: tablo.buttons.print.tabloSutun,
                        },
                    },
                    {
                        extend: "pdfHtml5",
                        filename: tablo.buttons.pdf.dosyaAdi,
                        title: tablo.buttons.pdf.baslik,
                        header: true,
                        footer: true,
                        exportOptions: {
                            columns: tablo.buttons.pdf.tabloSutun,
                        },
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 8;
                            doc.content[1].table.widths = Array(
                                doc.content[1].table.body[0].length + 1
                            )
                                .join("*")
                                .split("");
                            doc.styles.tableHeader.fontSize = 6;
                            doc.content[1].layout = {
                                hLineWidth: function (i, node) {
                                    return 1;
                                },
                                vLineWidth: function (i, node) {
                                    return 1;
                                },
                                hLineColor: function (i, node) {
                                    return "#aaa";
                                },
                                vLineColor: function (i, node) {
                                    return "#aaa";
                                },
                                paddingLeft: function (i, node) {
                                    return 4;
                                },
                                paddingRight: function (i, node) {
                                    return 4;
                                },
                                paddingTop: function (i, node) {
                                    return 2;
                                },
                                paddingBottom: function (i, node) {
                                    return 2;
                                },
                            };
                        },
                    },
                ]
                : [],
        });
    }

    function AjaxDataTables(tablo) {
        return $(`#${tablo.id}`).DataTable({
            responsive: true,
            searchDelay: 100,
            serverSide: true,
            stateSave: false,
            ordering: true,
            searching: false,
            rowReorder: {
                selector: "tr td:not(:last-child)",
                update: false,

            },
            ajax: {
                url: tablo.ajax.url,
                method: "GET",
                data: tablo.ajax.data,
            },
            order : tablo.order ?? [],
            columns: tablo.sutunlar,
            columnDefs: tablo.sutunTanim,
            dom:
                "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            language: datatables.language,
            buttons: tablo.buttons
                ? [
                    {
                        extend: "print",
                        filename: tablo.buttons.print.dosyaAdi,
                        title: tablo.buttons.print.baslik,
                        header: true,
                        footer: true,
                        exportOptions: {
                            columns: tablo.buttons.print.tabloSutun,
                        },
                    },
                    {
                        extend: "excelHtml5",
                        filename: tablo.buttons.excel.dosyaAdi,
                        title: tablo.buttons.excel.baslik,
                        header: true,
                        footer: true,
                        exportOptions: {
                            columns: tablo.buttons.print.tabloSutun,
                        },
                    },
                    {
                        extend: "pdfHtml5",
                        filename: tablo.buttons.pdf.dosyaAdi,
                        title: tablo.buttons.pdf.baslik,
                        header: true,
                        footer: true,
                        exportOptions: {
                            columns: tablo.buttons.pdf.tabloSutun,
                        },
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 8;
                            doc.content[1].table.widths = Array(
                                doc.content[1].table.body[0].length + 1
                            )
                                .join("*")
                                .split("");
                            doc.styles.tableHeader.fontSize = 6;
                            doc.content[1].layout = {
                                hLineWidth: function (i, node) {
                                    return 1;
                                },
                                vLineWidth: function (i, node) {
                                    return 1;
                                },
                                hLineColor: function (i, node) {
                                    return "#aaa";
                                },
                                vLineColor: function (i, node) {
                                    return "#aaa";
                                },
                                paddingLeft: function (i, node) {
                                    return 4;
                                },
                                paddingRight: function (i, node) {
                                    return 4;
                                },
                                paddingTop: function (i, node) {
                                    return 2;
                                },
                                paddingBottom: function (i, node) {
                                    return 2;
                                },
                            };
                        },
                    },
                ]
                : [],
            error: function (xhr, error, code) {
                console.error("Hata Oluştu: " + error);
            },
        });
    }

    function DataTablesDisaAktar(tablo, modul) {
        const modal = document.getElementById("kt_modal_export");
        const modalForm = modal.querySelector("#kt_modal_export_form");
        const bModal = new bootstrap.Modal(modal);

        const modalButton = modal.querySelector(
            '[data-kt-modal-action="submit"]'
        );
        modalButton.addEventListener("click", function (e) {
            e.preventDefault();

            const formData = new FormData(modalForm);
            const inputValue = formData.get("format");

            if (inputValue != "") {
                modalButton.setAttribute("data-kt-indicator", "on");
                modalButton.disabled = !0;
                modalButton.removeAttribute("data-kt-indicator"),
                    Swal.fire({
                        text: modul + " listesi başarıyla dışa aktarıldı!",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Tamam, Anladım!",
                        customClass: { confirmButton: "btn btn-primary" },
                    }).then(function (t) {
                        if (inputValue == "excel") {
                            tablo.buttons(".buttons-excel").trigger();
                        }
                        if (inputValue == "pdf") {
                            tablo.buttons(".buttons-pdf").trigger();
                        }
                        if (inputValue == "print") {
                            tablo.buttons(".buttons-print").trigger();
                        }
                        t.isConfirmed &&
                            (bModal.hide(), (modalButton.disabled = !1));
                    });
            } else {
                Swal.fire({
                    text: "Üzgünüz, bazı hatalar algılandı, lütfen tekrar deneyin.",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Tamam, Anladım!",
                    customClass: { confirmButton: "btn btn-primary" },
                });
            }
        });

        modal
            .querySelector('[data-kt-modal-action="cancel"]')
            .addEventListener("click", function (t) {
                bModal.hide();
            });

        modal
            .querySelector('[data-kt-modal-action="close"]')
            .addEventListener("click", function (t) {
                bModal.hide();
            });
    }

    function DatePicker(
        baslangic = moment().startOf("year"),
        bitis = moment().endOf("year")
    ) {
        function cb(baslangic, bitis) {
            $("#reportrange span").html(
                baslangic.format("MMMM D, YYYY") +
                " - " +
                bitis.format("MMMM D, YYYY")
            );
        }

        $('input[name="dates"]').daterangepicker(
            {
                showDropdowns: true,
                timePicker24Hour: true,
                startDate: baslangic,
                endDate: bitis,
                locale: {
                    customRangeLabel: "Özel Tarih Aralığı",
                    format: "DD/MM/YYYY",
                    applyLabel: "Uygula",
                    cancelLabel: "İptal",
                },
                showDropdowns: true,
                minYear: 2023,
                maxYear: parseInt(moment().format("YYYY")) + 20,
                opens: "center",
                drops: "auto",
                ranges: {
                    Bugün: [moment(), moment()],
                    Dün: [
                        moment().subtract(1, "days"),
                        moment().subtract(1, "days"),
                    ],
                    "Bu Hafta": [
                        moment().startOf("week"),
                        moment().endOf("week"),
                    ],
                    "Geçen Hafta": [
                        moment().subtract(1, "week").startOf("week"),
                        moment().subtract(1, "week").endOf("week"),
                    ],
                    "Bu Ay": [
                        moment().startOf("month"),
                        moment().endOf("month"),
                    ],
                    "Geçen Ay": [
                        moment().subtract(1, "month").startOf("month"),
                        moment().subtract(1, "month").endOf("month"),
                    ],
                    "Bu Yıl": [
                        moment().startOf("year"),
                        moment().endOf("year"),
                    ],
                    "Geçen Yıl": [
                        moment().subtract(1, "year").startOf("year"),
                        moment().subtract(1, "year").endOf("year"),
                    ],
                },
            },
            cb
        );

        cb(baslangic, bitis);

        return { baslangic, bitis };
    }

    function FlatPicker(id, baslangic = "", bitis = "") {
        return $(`#${id}`).flatpickr({
            /* enableTime: true,
            noCalendar: true, */
            /*          dateFormat: "H:i",              */
            /*    time_24hr: true, */
            /* defaultDate: moment().format("LT"), */
            mode: "range",
            dateFormat: "d.m.Y",
            "locale": "tr",
            defaultDate: ((baslangic !== "" && bitis !== "") ? [baslangic, bitis] : "")

        });
    }

    function AySelect(nitelik) {
        var aylar = [
            "Ocak",
            "Şubat",
            "Mart",
            "Nisan",
            "Mayıs",
            "Haziran",
            "Temmuz",
            "Ağustos",
            "Eylül",
            "Ekim",
            "Kasım",
            "Aralık",
        ];
        var selectElementi = document.querySelectorAll(nitelik);
        selectElementi.forEach((select) => {
            for (var i = 0; i < aylar.length; i++) {
                var option = document.createElement("option");
                option.text = aylar[i];
                option.value = i + 1;
                select.appendChild(option);
            }
        });
    }

    function YilSelect(nitelik, baslangicYil, YilSonrasi) {
        var suAnkiYil = new Date().getFullYear();
        var baslangicYili = baslangicYil;
        var onYilSonrasi = suAnkiYil + YilSonrasi;
        var selectElementi = document.querySelectorAll(nitelik);
        selectElementi.forEach((select) => {
            for (var yil = baslangicYili; yil <= onYilSonrasi; yil++) {
                var option = document.createElement("option");
                option.text = yil;
                option.value = yil;
                select.appendChild(option);
            }
        });
    }

    function Swall(swallArray) {
        Swal.close();

        return Swal.fire({
            icon: swallArray.icon,
            title: swallArray.baslik || false,
            html: swallArray.icerik
                ? `<p class="text-center">${swallArray.icerik}</p>`
                : false,
            showCloseButton: swallArray.cikisButonDurum || false,
            showCancelButton: swallArray.iptalButonDurum || false,
            showConfirmButton: swallArray.onayButonDurum ?? true,
            confirmButtonText: swallArray.onayButonİcerik || `Tamam !`,
            cancelButtonText: swallArray.iptalButonİcerik || `İptal !`,
            reverseButtons: swallArray.tersButon || false,
            footer: swallArray.footer || false,
            width: swallArray.genislik || "32rem",
            allowOutsideClick: swallArray.tiklamaDurum || false,
            backdrop: true,
            allowEscapeKey: swallArray.escCikisDurum || false,
            heightAuto: false,

            customClass: {
                popup: "py-3 px-4 dark:text-white dark:bg-zinc-800 rounded-lg border dark:border-0 shadow",
                icon: "my-3",
                confirmButton:
                    "inline-flex items-center justify-center border-transparent font-medium rounded-md shadow-sm focus:outline-none text-center bg-green-500 text-white hover:bg-green-700 focus:ring-green-500 text-base px-5 py-1.5",
                cancelButton:
                    "inline-flex items-center justify-center border-transparent font-medium rounded-md shadow-sm focus:outline-none text-center bg-rose-500 text-white hover:bg-rose-700 focus:ring-rose-500 text-base px-5 py-1.5",
            },
        });
    }

    function SwallCikis() {
        Swal.close();
    }


    return {
        FilePonds,
        FormKontrol,
        FormSifirla,
        ZamanFormati,
        FiyatFormati,
        FormYukleniyor,
        FormTamamlandi,
        FormGondermeOnay,
        DataTables,
        AjaxDataTables,
        DataTablesDisaAktar,
        DatePicker,
        FlatPicker,
        AySelect,
        YilSelect,
        Swall,
        SwallCikis,
    };
}
