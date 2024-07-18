
$(document).ready(function(){
    $('.js_user_profile').on('click', function(event){
        event.stopPropagation();
        let ul = $('.ul-profile');
        ul.toggle();
        ul.removeClass('d-none');
    });

    $(document).on('click', function(){
        $('.ul-profile').hide();
    });

    $('.ul-profile').on('click', function(event){
        event.stopPropagation();
    });

    $('.jsProfileBtn').on('click', function(){
        let profileModal = $('#profileModal');
        profileModal.modal('show');
    });
});

$(document).on('submit', '.js_profile_form', function (e) {
    e.preventDefault();
    let form = $(this);
    let modal = form.closest('#profileModal');
    $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: form.serialize(),
        dataType: 'JSON',
        success: (response) => {
            // console.log('response: ', response);
            if (response.success) {
                modal.modal('hide');
                $('#successModal').modal('show');
                setTimeout(function() {
                    $('#successModal').modal('hide');
                    // window.location.reload();
                }, 1500);
            }
        },
        error: (response) => {
            console.log('error: ', response);
            if (response.responseJSON && response.responseJSON.errors) {
                let errors = response.responseJSON.errors;
                handleFieldError(form, errors, 'username');
            }
        }
    });
});
