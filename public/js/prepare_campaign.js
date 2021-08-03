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

});


/*<div class="pl-2 pr-2 single-select">
    <div class="form-group">
        <label for="">First Select</label>
        <select class="form-control" name="" id="">
            <option selected disabled value="">Select...</option>

        </select>
    </div>
</div> */