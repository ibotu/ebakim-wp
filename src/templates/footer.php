<script>
    jQuery(document).ready(function($) {
        if ($('.this_datatable').length > 0) {
            $('.this_datatable').DataTable({
                responsive: true,
                order: [[ 0, "desc" ]], // Order by ID in descending order (latest on top)
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