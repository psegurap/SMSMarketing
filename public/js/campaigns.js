

$(document).ready(function(){
    //Initialize upload with preview pluging
    let csv_upload = new FileUploadWithPreview('csv_upload');

    // Loading table:

    $('#campaigns-table').DataTable({
        responsive : true,
        paging: false,
    });

    $('#campaigns-table .campaign-option').click(function (){
        let option_type = $(this).data('option');
        switch (option_type) {
            case 'Chat':
                window.location = homepath + '/campaigns/contact_campaign/' + $(this).data('campaignid');
                break;
            case 'Properties':
                console.log("Properties");
                break;
            case 'Delete':
                console.log("Delete");
                break;
            default:
                break;
        }
    });

    $('#upload-next-btn').click(function(){
        if (csv_upload.currentFileCount > 0) {
            UploadNextStep();
        }
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


