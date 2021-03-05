//Common admin panel JS functions in here
$(document).ready(function() {
    //If the user decides to logout from the admin panel
    $(".logout").click(function() {
        // Long ass thing to make sure the logout will not break even if teacher move it to another folder
        var path = window.location.pathname.substring(window.location.pathname.indexOf("/"), window.location.pathname.lastIndexOf("/"))
        document.cookie = "session_username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=" + path + ";";
        document.cookie = "session_password=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=" + path + ";";
        $(location).attr('href', './admin_login.php');
    })

    //Code for the expendable filter card found on admin_view_all.php
    $(".card-expendable").click(function() {
        // Function for expendable card
        if($("#expendable").css('display') == 'none') {
            $(".card-expendable-icon").html("arrow_drop_down");
            $("#expendable").slideToggle();
            anime({
                targets: '#expendable',
                opacity: 1
            })
        } else {
            $(".card-expendable-icon").html("arrow_drop_up");
            anime({
                targets: '#expendable',
                opacity: 0
            })
            $("#expendable").slideToggle();
            
        }
    })

    //Stagger animeJS animation for list
    if ($(".stagger").length) {
        anime({
            targets: '.stagger',
            top: 0,
            opacity: 1,
            delay: anime.stagger(100)
        });
    }
})