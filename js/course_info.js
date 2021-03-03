//Specific JS file for course_info.php

$(document).ready(function() {
    //stagger animation for slide in up in the courses card
    if ($(".stagger").length) {
        anime({
            targets: '.stagger',
            top: 0,
            opacity: 1,
            delay: anime.stagger(100)
        });
    }

    //Scale animation when course card is hovering over card
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