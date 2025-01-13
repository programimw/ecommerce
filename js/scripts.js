// Display an info toast with no title
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}


function isEmpty(val) {
    return (val == "" || val === undefined || val == null || val === false || val.length <= 0) ? true : false;
}


// Handle dismiss button click
$('[data-dismiss=modal]').on('click', clearModalContent);

// Handle clicking outside the modal or using the escape key or dismiss button
$('.modal').on('hidden.bs.modal', function () {
    clearModalContent.call(this);  // Call the clear function with the modal as the context
});

function clearModalContent() {
    var $modal = $(this);

    $modal
        .find("input,textarea,select")
        .val('')
        .end()
        .find("input[type=checkbox], input[type=radio]")
        .prop("checked", false)
        .end();

    // Unmount and remount the Stripe card element
    if (typeof cardElement !== 'undefined') {
        cardElement.unmount();  // Unmount the existing card element
        cardElement.mount('#card-element');  // Remount the card element to reset it
    }
}