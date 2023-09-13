jQuery(document).ready(function($) {
    // Target the form by its ID or any other selector.
    var form = $('#your-profile'); // Change 'your-form-id' to the actual ID of your form.

    // Add the enctype attribute to enable file uploads.
    form.attr('enctype', 'multipart/form-data');
});
