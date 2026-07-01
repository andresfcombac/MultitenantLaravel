document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById("sidebar");

    const toggle = document.getElementById("toggleSidebar");

    if (!sidebar || !toggle) return;

    const estado = localStorage.getItem("sidebar");

    if (estado === "collapsed") {

        sidebar.classList.add("collapsed");

    }

    toggle.addEventListener("click", function () {

        sidebar.classList.toggle("collapsed");

        if (sidebar.classList.contains("collapsed")) {

            localStorage.setItem("sidebar", "collapsed");

        } else {

            localStorage.setItem("sidebar", "expanded");

        }

    });

});