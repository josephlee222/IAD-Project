//Common animation classes for all pages with animations

$(document).ready(function() {
    if ($(".slidein-right").length) {
        anime({
            targets: '.slidein-right',
            right: 0,
            opacity: 1,
        });
    }

    if ($(".slidein-left").length) {
        anime({
            targets: '.slidein-left',
            left: 0,
            opacity: 1,
        });
    }

    if ($(".slidein-up").length) {
        anime({
            targets: '.slidein-up',
            top: 0,
            opacity: 1,
        });
    }
})