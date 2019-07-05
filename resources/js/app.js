window._ = require("lodash");

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": token.content
        }
    });
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}

$.extend(true, $.fn.dataTable.defaults, {
    lengthChange: false,
    processing: true,
    serverSide: true
});
