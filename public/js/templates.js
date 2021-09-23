

$(document).ready(function(){

    // Loading table:
    $('#templates-table').DataTable({
        responsive : true,
        // paging: false,
    });

    $('#templates-table .template-option').click(function (){
        let option_type = $(this).data('option');
        switch (option_type) {
            case 'Chat':
                window.location = homepath + '/campaigns/contact_campaign/' + $(this).data('campaignid');
                break;
            case 'Properties':
                window.open(homepath + '/campaigns/properties/' + $(this).data('campaignid'), '_blank');
                break;
            case 'Delete':
                console.log("Delete");
                break;
            default:
                break;
        }
    });

    $('#add-template').click(function(){
        var _this = this;
        let template = $('#template-input').val();
        if ($('#template-input').val() == "") {
            $('#template-input').parents('.input-group:first').css('box-shadow', '0px 0px 1px 1px red');
        }else {
            $('#add-template').hide()
            $('.wait-text').show();
            $('.spinner-upload').css('display', 'inline-block');

            axios.post(homepath + '/templates/add_template', {template : template}).then(function(response){
                window.location.reload();
            }).catch(function(error){
                console.log(error);
            });
        }
    });

    $('#template-input').focus(function () {
        $(this).parents('.input-group:first').css('box-shadow', 'none')
    });

    function UploadNextStep() {

        $('#upload-next-btn').hide()
        $('.wait-text').show();
        $('.spinner-upload').css('display', 'inline-block');

        let formData = new FormData();
        formData.append('file', csv_upload.cachedFileArray[0]);

        axios.post(homepath + '/campaigns/files/temporary_upload',  formData, { headers : {'Content-Type': 'multipart/form-data'}}).then(function(response){
            window.location.href = homepath + '/campaigns/preparefile';
        }).catch(function(error){
            console.log(error);
        });
    }

});


