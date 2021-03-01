//Common admin panel JS functions in here
$(document).ready(function() {
    $(".logout").click(function() {
        // Long ass thing to make sure the logout will not break even if teacher move it to another folder
        document.cookie = "session_username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=" + window.location.pathname.substring(window.location.pathname.indexOf("/"), window.location.pathname.lastIndexOf("/")) + ";";
        document.cookie = "session_password=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=" + window.location.pathname.substring(window.location.pathname.indexOf("/"), window.location.pathname.lastIndexOf("/")) + ";";
        $(location).attr('href', './admin_login.php');
    })

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

    if ($(".stagger").length) {
        anime({
            targets: '.stagger',
            top: 0,
            opacity: 1,
            delay: anime.stagger(100)
        });
    }
})