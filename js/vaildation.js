// Vaildation classes to check when filling up various forms

$(document).ready(function() {
    $( ".vaildate-text" ).change(function() {
        var text_value = $(this).val();
        var vaildation_icon = $(this).parent().find(".label-div").find("#vaildation");
        if (text_value == "" || text_value == null || text_value.length < 4) {
            vaildation_icon.html("close");
            vaildation_icon.css('color', 'red');
        } else {
            vaildation_icon.html("done");
            vaildation_icon.css('color', 'white');
        }
    });

    $( ".vaildate-number" ).change(function() {
        var number_value = $(this).val();
        var vaildation_icon = $(this).parent().find(".label-div").find("#vaildation");
        if (number_value == "" || number_value == null || isNaN(number_value)) {
            vaildation_icon.html("close");
            vaildation_icon.css('color', 'red');
        } else {
            vaildation_icon.html("done");
            vaildation_icon.css('color', 'white');
        }
    });

    $( ".vaildate-phone" ).change(function() {
        var phone_value = $(this).val();
        var vaildation_icon = $(this).parent().find(".label-div").find("#vaildation");
        if (phone_value == "" || phone_value == null || phone_value.length != 8 || isNaN(phone_value)) {
            vaildation_icon.html("close");
            vaildation_icon.css('color', 'red');
        } else {
            vaildation_icon.html("done");
            vaildation_icon.css('color', 'white');
        }
    });

    $( ".vaildate-email" ).change(function() {
        var vaildation_icon = $(this).parent().find(".label-div").find("#vaildation");
        if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($(this).val())) {
            //Vaild email address
            vaildation_icon.html("done");
            vaildation_icon.css('color', 'white');
        } else {
            //Invaild email address
            vaildation_icon.html("close");
            vaildation_icon.css('color', 'red');
        }
    });
})