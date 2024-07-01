$(document).on('change', '.js_role', function () {
    let role = $(this).val();
    let divLogin = $(document).find('.js_div_login');
    if (role === '2') {
        divLogin.removeClass('d-none');
    }
    else {
        divLogin.addClass('d-none');
    }
})
