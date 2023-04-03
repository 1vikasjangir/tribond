$(document).ready(function() {
    /*************
     * Toltip placement on icons
     * ******************/
    $(function() {
        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        })
    });

    /***********
     * Hide alert message
     * ****************/
    $(".alert").animate({
        opacity: 0
    }, 5000).hide('slow');

    /***********
     * Tinymce editor integration on blog module
     * ****************/

    tinymce.init({
        selector: 'textarea#editor',
        skin: 'bootstrap',
        // plugins: 'quickbars, lists, link, image, media, code, directionality, emoticons, fullscreen, hr, autosave, insertdatetime, pagebreak, preview, print',
        // toolbar: 'h1 h2 h3 h4 h5 h6 bold italic strikethrough hr blockquote bullist numlist backcolor | link image media code insertdatetime | pagebreak removeformat help | directionality emoticons restoredraft fullscreen preview print',
        menubar: false,
        // default_link_target: '_blank',
        // link_default_protocol: 'https',
        setup: (editor) => {
            // Apply the focus effect
            editor.on("init", () => {
                editor.getContainer().style.transition =
                    "border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out";
            });
            editor.on("focus", () => {
                (editor.getContainer().style.boxShadow = "0 0 0 .2rem rgba(0, 123, 255, .25)"),
                (editor.getContainer().style.borderColor = "#80bdff");
            });
            editor.on("blur", () => {
                (editor.getContainer().style.boxShadow = ""),
                (editor.getContainer().style.borderColor = "");
            });
        },
    });

});
