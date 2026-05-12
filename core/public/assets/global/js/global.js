"use strict";
(function($) {
    // Global utilities
    window.notify = window.notify || function(type, msg) {
        if (typeof iziToast !== 'undefined') {
            iziToast[type]({ title: type, message: msg, position: 'topRight' });
        } else {
            console.log(type + ':', msg);
        }
    };
})(jQuery || function(){});
