$(document).ready(function() {
    if ($(".stagger").length) {
        anime({
            targets: '.stagger',
            top: 0,
            opacity: 1,
            delay: anime.stagger(100)
        });
    }

    $(".animate-enlarge").hover(function() {
        $(this).css('position', 'relative');
        $(this).css('z-index', 1000);

        anime({
            targets: this,
            scale: 1.15
        })
    }, function() {
        $(this).css('z-index', 1);
        anime({
            targets: this,
            scale: 1
        })
    })
})