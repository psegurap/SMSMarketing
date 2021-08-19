$(document).ready(function(){
    let selects_container = $('#form-selects');

    for (const key in db_columns) {

        let single_select = document.createElement('div');
        single_select.classList.add('pl-2','pr-2', 'single-select');

        let form_group = document.createElement('div');
        form_group.classList.add('form-group', 'p-2');

        let label = document.createElement('label');
        label.innerHTML = db_columns[key];

        let select = document.createElement('select');
        select.addEventListener('change', function(){
            if($(this).val() != '' || $(this).val() != null){
                $(this).css('box-shadow', 'none');
            }
        });
        select.classList.add('form-control');
        select.setAttribute('name', key);

        let disabled_option = document.createElement('option');
        disabled_option.setAttribute('selected', '');
        disabled_option.setAttribute('disabled', '');
        disabled_option.innerHTML = "Select...";
        select.append(disabled_option);

        for (const key_column in columns_name) {
            let option = document.createElement('option');
            option.setAttribute('value', columns_name[key_column]);

            option.innerHTML = columns_name[key_column];
            select.append(option);
        }

        form_group.append(label);
        form_group.append(select);
        single_select.append(form_group);
        selects_container.append(single_select);

    }

    $('#create-campaign-btn').click(function(){
        let isValidated = validateSelects();
        let input_value = $('#campaign_name').val() != '' ? $('#campaign_name').val() : false;

        if (!input_value) {
            Snackbar.show({
                text: "Insert campaign's name",
                pos: 'top-right'
            });
        }

        if(isValidated && input_value){

            $('#create-campaign-btn').hide()
            $('.wait-text').show();
            $('.spinner-upload').css('display', 'inline-block');

            let selects_matched = prepareSelectObject();

            swal({
                title: 'Please Wait!',
                text: 'This might take a few seconds.',
                padding: '2em',
                onOpen: function () {
                  swal.showLoading()
                }
            });

            axios.post(homepath + '/campaigns/store_csv_values', {selects_matched : selects_matched, campaign_name : input_value } ).then(function(response){
                swal.close();
                window.location.href = homepath + '/campaigns';
            }).catch(function(error){
                swal.close();
                Snackbar.show({
                    text: "There was an error.",
                    pos: 'top-right'
                });
                console.log(error);
            });
        }
    });

    function validateSelects(){
        let selects = $('#form-selects').find('select');
        isValidated = true;
        selects.map(function(){
            if ($(this).val() == '' || $(this).val() == null) {
                $(this).css('box-shadow', '0px 0px 3px 2px red');
                isValidated = false;
            }
        });
        return isValidated;
    }

    function prepareSelectObject (){
        let columns_matched = {};

        let selects = $('#form-selects').find('select');
        isValidated = true;
        selects.map(function(){
            let name = $(this).attr('name');
            columns_matched[name] = $(this).val();
        });
        return columns_matched;
    }

});