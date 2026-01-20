/**
 *
 * JS for Styling
 *
 */

/**
 *
 * JS for actions
 *
 */
function registerDatatables(options) {
    let defaultSettings = {
        processing: true,
        serverSide: true,
        ajax: options.url,
        columns: options.columns,
        responsive: true,
        autoWidth: false,
        paging: typeof options.paging !== "undefined" ? options.paging : true,
        info: typeof options.info !== "undefined" ? options.info : true,
        filter: typeof options.filter !== "undefined" ? options.filter : true,
    };

    if (options.columnDefs) {
        defaultSettings.columnDefs = options.columnDefs;
    }

    let settings = $.extend({}, defaultSettings, options.customSettings || {});
    return options.element.DataTable(settings);
}

function sweetAlertDelete() {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            formEl.submit();
        }
    });
}

function sweetAlertSuccess(text) {
    Swal.fire({
        title: "Success !",
        text: text,
        icon: "success",
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: "top-end",
    });
}
function sweetAlertDanger(text) {
    Swal.fire({
        title: "Failed !",
        text: text,
        icon: "error",
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: "top-end",
    });
}

function sweetAlertWarning(text) {
    Swal.fire({
        title: "Warning !",
        text: text,
        icon: "warning",
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: "top-end",
    });
}

function sweetAlertLoading() {
    Swal.fire({
        title: "Sedang diproses..",
        text: "Tunggu sampai selesai, jangan ditutup halaman ini",
        timerProgressBar: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
}
