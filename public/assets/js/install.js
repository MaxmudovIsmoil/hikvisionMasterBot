function groupSet(groups) {
    return groups.map((data, i) => {
        const { name } = data;
        return `<span class="text-primary">${name}</span>; `;
    })
}

function locationSet(location) {
    let loc = location ? location : '';
    return `<div class="d-flex justify-content-between">
                <a href="${loc}" target="_blank">Havola</a>
                <p class="mb-0 js_copy_link" data-location="${loc}"><i class="fas fa-copy"> copy</i></p>
            </div>`;
}

$('body').delegate('.js_copy_link', 'click', function() {
    let $this = $(this);
    let icon = $this.find('i');
    let location = $this.data('location');
    navigator.clipboard.writeText(location);
    icon.removeClass('fas');
    icon.addClass('far');

    setTimeout(function () {
        icon.removeClass('far');
        icon.addClass('fas');
    }, 1000);
});
