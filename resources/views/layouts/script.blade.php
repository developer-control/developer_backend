<script>
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
<script type="module" src="{{ asset('firebase.js') }}"></script>
