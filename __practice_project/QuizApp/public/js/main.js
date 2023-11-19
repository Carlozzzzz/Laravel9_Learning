(function () {
    "use strict";

    const select = (el, all = false) => {
        el = el.trim();
        if (all) {
            return [...document.querySelectorAll(el)];
        } else {
            return document.querySelector(el);
        }
    };

    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = true) => {
        if (all) {
            select(el, all).forEach((e) => e.addEventListener(type, listener));
        } else {
            select(el, all).addEventListener(type, listener);
        }
    };

    /**
     * Sidebar toggle
     */
    if (select(".toggle-sidebar-btn")) {
        on("click", ".toggle-sidebar-btn", function (e) {
            select("body").classList.toggle("toggle-sidebar");
            select("body .toggle-sidebar-btn").classList.toggle("bi-arrow-bar-right");
        });
    }

    /**
     * Sidenav toggle
     */
    if (select(".toggle-sidenav-btn")) {
        on("click", ".toggle-sidenav-btn", function (e) {
            select("body").classList.toggle("toggle-sidenav");
            
        });
    }
})();
