

$(document).ready(function(){

    let current_template = null;
    // Loading table:
    $('#templates-table').DataTable({
        responsive : true,
        "order": [[ 0, "desc" ]]
        // paging: false,
    });

    $('#addContactModal').on('hidden.bs.modal', function () {
        window.location.reload();
    });

    $('#btn-add-contact').on('click', function () {
        $('#addContactModal .modal-title').text('New Tamplate');
        $('#addContactModal #add-template').text('Create');
        $('#add-template').data('submit', 'create');
    });

    $('#templates-table .template-option').click(function (){
        let option_type = $(this).data('option');
        current_template = $(this).data('templateid');
        switch (option_type) {
            case 'Edit':
                $('#addContactModal .modal-title').text('Update Tamplate');
                $('#addContactModal #add-template').text('Update');
                $('#add-template').data('submit', 'update');
                $('#addContactModal input').val($(this).parent().siblings('.template').text())
                $('#addContactModal').modal('show');
                break;
            case 'Delete':
                DeleteTemplate();
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

            if ($(this).data('submit') == 'create') {
                axios.post(homepath + '/templates/add_template', {template : template}).then(function(response){
                    Snackbar.show({
                        text: 'Yout template was added.',
                        actionTextColor: '#fff',
                        backgroundColor: '#1abc9c'
                    });
                    $('.wait-text').hide();
                    $('.spinner-upload').hide();
                    $('#add-template').show();
                    $('#template-input').val('');
                }).catch(function(error){
                    console.log(error);
                });
            } else if($(this).data('submit') == 'update') {
                axios.post(homepath + '/templates/update_template/' + current_template, {template : template}).then(function(response){
                    Snackbar.show({
                        text: 'Yout template was updated.',
                        actionTextColor: '#fff',
                        backgroundColor: '#1abc9c'
                    });
                    $('.wait-text').hide();
                    $('.spinner-upload').hide();
                    $('#add-template').show();
                }).catch(function(error){
                    console.log(error);
                });
            }

        }
    });

    $('#template-input').focus(function () {
        $(this).parents('.input-group:first').css('box-shadow', 'none')
    });

    function DeleteTemplate () {
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            // type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                axios.post(homepath + '/templates/delete_template/' + current_template).then(function(response){
                    $('[data-templateid="' + current_template + '"]').parents('tr:first').remove();
                    Snackbar.show({
                        text: 'Your template was deleted.',
                        actionTextColor: '#fff',
                        backgroundColor: '#1abc9c'
                    });
                }).catch(function(error){
                    console.log(error);
                });
            }
        });
    }
});


