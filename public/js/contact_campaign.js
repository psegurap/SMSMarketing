

$(document).ready(function(){

    // $('#alertModal').modal({
    //     backdrop: 'static',
    //     keyboard: false
    // });

    $('#return-to-campaigns').click(function(){
        window.location.href = homepath + '/campaigns';
    });

    if (campaign['contacts'].length == 0) {
        $('#alertModal').find('.modal-text').text("This campaign has been fully contacted. Press 'OK' to return to campaigns.");
        $('#alertModal').modal('show');
    }

    
    
    let contacts = campaign['contacts'];

    $('#send-message').click(function(){
        if (contacts.length > 0) {
            SendMessage($(contacts).get(0));
            contacts.shift();
            if (contacts.length >= 1) {
                ChangeContact();
            }
        }else{
            $('#alertModal').find('.modal-text').text("This campaign has been fully contacted. Press 'OK' to return to campaigns.");
            $('#alertModal').modal('show');
        }

    });

    function SendMessage(contact_info){
        let initial_message = 'Hey ' + contact_info['first_name'] + ", did you get my voicemail?"
        axios.post(homepath + '/campaigns/contact_campaign/send_message', {contact_info : contact_info, text_details : initial_message} ).then(function(response){
            console.log(response.data);
        }).catch(function(error){
            console.log(error);
        });
    }

    function ChangeContact() {
        let contact = $(contacts).get(0);
        let mail_address = $(contact['mail_addresses']).get(0);
        let property = $(contact['properties']).get(0);

        // Contact Name
        $('.campaign-contact-name').text(contact['first_name'] + " " + contact['last_name']);
        $('.campaign-contact-email').text(contact['email_address']);
        $('.campaign-contact-phone').text(contact['phone_number']);

        // Dates
        $('.campaign-contact-created').text(contact['created_at']);
        $('.campaign-contact-updated').text(contact['updated_at']);

        // Mail Address
        $('.campaign-mail-street').text(mail_address['mail_street_address']);
        $('.campaign-mail-city-state').text(mail_address['mail_city'] + ", " + mail_address['mail_state']);
        $('.campaign-mail-zip').text(mail_address['mail_zip_code']);

        // Target Property
        $('.campaign-property-street').text(property['property_street_address']);
        $('.campaign-property-city').text(property['property_city']);
        $('.campaign-property-state').text(property['property_state']);
        $('.campaign-property-zip').text(property['property_zip_code']);
    }

});


