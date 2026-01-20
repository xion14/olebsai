/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
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
        paging: typeof options.paging !== 'undefined' ? options.paging : true,
        info: typeof options.info !== 'undefined' ? options.info : true,
        filter: typeof options.filter !== 'undefined' ? options.filter : true,
    };

    if (options.columnDefs) {
        defaultSettings.columnDefs = options.columnDefs;
    }

    let settings = $.extend({}, defaultSettings, options.customSettings || {});
    return options.element.DataTable(settings);
}