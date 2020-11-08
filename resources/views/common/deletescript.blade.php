<script>
    function deleteRecord(slug) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                closeModal: false,
            })
            .then((willDelete) => {


                if (willDelete) {

                    var token = '{{ csrf_token() }}';

                    route = '{{ $route }}' + slug;

                    $.ajax({

                        url: route,

                        type: 'post',

                        data: {
                            _method: 'delete',
                            _token: token
                        },

                        success: function(msg) {



                            swal("Deleted'!", "Your record has been deleted", "success", {
                                button: false,
                                timer: 2000,
                            }).then((value) => {
                                $('#datatable').DataTable().ajax.reload()
                            });





                        }

                    });
                } else {
                    swal("cancelled", "your_record_is_safe :)", "error", {
                        button: false,
                        timer: 2000,
                    });
                }
            });

    }

</script>
