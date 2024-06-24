
function delete_function(deleteModal, $this, table) {
    $.ajax({
        type: "POST",
        url: $this.attr('action'),
        data: $this.serialize(),
        success: (response) => {
            if(!response.success) {
                deleteModal.find('.js_message').addClass('d-none')
                deleteModal.find('.js_danger').html(response.error)
            }
            console.log('res', response)
            if(response.success) {
                table.draw();
                deleteModal.modal('hide');
            }
        },
        error: (response) => {
            console.log('error:', response);
        }
    });
}


$(document).ready(function(){

    var deleteModal = $(document).find('#deleteModal')

    $(document).on("click", ".js_delete_btn", function () {

        let name = $(this).data('name')
        let url = $(this).data('url')
        deleteModal.find('.modal-title').html(name)

        let form = deleteModal.find('#js_modal_delete_form')
        form.attr('action', url);
        deleteModal.modal('show');
    });


    $('#deleteModal button[data-dismiss="modal"]').click(function() {

        deleteModal.find('.js_message').removeClass('d-none')
        deleteModal.find('.js_danger').html('');

    })


});



/** ================================================================================== **/
