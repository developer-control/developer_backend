<script src="{{ url('/') }}/assets/soft-ui/js/core/popper.min.js"></script>
<script src="{{ url('/') }}/assets/soft-ui/js/core/bootstrap.min.js"></script>
<script src="{{ url('/') }}/assets/soft-ui/js/plugins/perfect-scrollbar.min.js"></script>
<script src="{{ url('/') }}/assets/soft-ui/js/plugins/smooth-scrollbar.min.js"></script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ url('/') }}/assets/soft-ui/js/soft-ui-dashboard.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-loading-overlay@1.1.0/dist/js-loading-overlay.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        JsLoadingOverlay.show();
        window.addEventListener("load", function() {
            JsLoadingOverlay.hide();

        })
    })
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    document.addEventListener("keydown", function(event) {
        // Periksa jika elemen yang terfokus adalah bagian dari sebuah form
        if (event.target.form && event.key === "Enter" && event.target.tagName !== "TEXTAREA") {
            event.preventDefault(); // Mencegah submit form
        }
    });
    // $(document).on("keydown", "form", function(event) {
    //     // return event.key != "Enter";
    //     if (event.key === "Enter" && event.target.tagName !== "TEXTAREA") {
    //         event.preventDefault(); // Mencegah submit form
    //     }
    // });
</script>
