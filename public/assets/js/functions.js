function formClear(form) {
    $(form).find('input[type="text"]').val('');
    $(form).find('input[name="_method"]').remove();
    $('select option').prop('selected', false);
}

function handleFieldError(form, errors, errorKey) {
    let element = form.find(`.js_${errorKey}`);
    if (errors[errorKey]) {
        element.addClass('is-invalid');
        element.siblings('.invalid-feedback').html(errors[errorKey][0]);
    }
}


$(document).on('input', 'input', function () {
    $(this).removeClass('is-invalid');
})


$(document).on('change', '.jsCheckAll', function () {
    let isChecked = $(this).is(':checked');
    $('.jsCheckOne').prop('checked', isChecked);
})
