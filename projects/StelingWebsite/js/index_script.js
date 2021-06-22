$(document).ready(function() {

    toggle_email_form(true);

    $('#contact_us_button').click(function() {

        var input_name = $('#contact_us_name').val();
        var input_email = $('#contact_us_email').val();
        var input_message = $('#contact_us_message').val();

        $.ajax({
            url: 'php/send_email.php',
            type: 'POST',
            data: {
                name: input_name,
                email: input_email,
                message: input_message,
            },
            success: function (result) {
                
                $('#contact_us_name').css("border-color", "#2196F3");
                $('#contact_us_email').css("border-color", "#2196F3");
                $('#contact_us_message').css("border-color", "#2196F3");

                if (result == "ERR_invalid_name") {
                    $('#contact_us_name').css("border-color", "red");
                    return;
                } else if (result == "ERR_invalid_email") {
                    $('#contact_us_email').css("border-color", "red");
                    return;
                } else if (result == "ERR_length_message") {
                    $('#contact_us_message').css("border-color", "red");
                    return;
                }

                if(result) {
                    toggle_email_form(false);
                } else {
                    alert('Napaka pri pošiljanju sporočila! Prosimo poskusite pozneje.');
                    toggle_email_form(true);
                }
            }
        });
        
    });

    function toggle_email_form(toggle_state) {

        var header_text = $('#contact_us_text');
        var name_input = $('#contact_us_name');
        var email_input = $('#contact_us_email');
        var message_input = $('#contact_us_message');
        var submit_button = $('#contact_us_button');
        var submitted_state_text = $('#submitted_email_form');

        if (toggle_state) {

            header_text.show();
            name_input.show();
            email_input.show();
            message_input.show();
            submit_button.show();
            submitted_state_text.hide();

        } else {
            
            header_text.hide();
            name_input.hide();
            email_input.hide();
            message_input.hide();
            submit_button.hide();
            submitted_state_text.show();

        }

    }

    $('.start_page_first_logo').click(function() {
        $('html, body').animate({
            scrollTop: $(".start_page_content div:nth-child(2)").offset().top
        }, 1000);
    });

    $('#gmaps_map').addClass('scrolloff'); // set the pointer events to none on doc ready
    $('#gmaps_id').on('click', function () {
        $('#gmaps_map').removeClass('scrolloff'); // set the pointer events true on click
        $('.gmaps_overlay').hide();
    });

    // you want to disable pointer events when the mouse leave the canvas area;

    $("#gmaps_map").mouseleave(function () {
        $('#gmaps_map').addClass('scrolloff'); // set the pointer events to none when mouse leaves the map area
        $('.gmaps_overlay').show();
    });

});