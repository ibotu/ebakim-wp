<script>
    jQuery(document).ready(function($) {


        // // Preview image on file input change
        // $('.imageInput').on('change', function() {
        //     let this_instance = $(this);
        //     let input = $(this)[0];
        //     if (input.files && input.files[0]) {
        //         let reader = new FileReader();
        //         reader.onload = function(e) {
        //             $('.imagePreview').attr('src', e.target.result);
        //         }
        //         reader.readAsDataURL(input.files[0]);
        //         this_instance.closest('.main_image_container').find('.clear-button').css({
        //             opacity: 1,
        //             visibility: 'visible'
        //         });
        //     }
        // });



        if ($('.this_datatable').length > 0) {
            $('.this_datatable').DataTable({
                responsive: true,
                order: [
                    [0, "desc"]
                ], // Order by ID in descending order (latest on top)
                paging: true,
                searching: true,
                ordering: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search patients...",
                    lengthMenu: "Show _MENU_ entries per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        }
    });
</script>