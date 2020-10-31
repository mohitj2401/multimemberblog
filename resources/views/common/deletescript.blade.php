
<script>


function deleteRecord(slug) {
        swal({
            title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this imaginary file!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
  closeModal:false,
})
.then((willDelete) => {
    

      if (willDelete) {

            var token = '{{ csrf_token()}}';

          route = '{{$route}}'+slug;  

        $.ajax({

            url:route,

            type: 'post',

            data: {_method: 'delete', _token :token},

            success:function(msg){



                result = $.parseJSON(msg);
                
                if(typeof result == 'object')

                {

                    status_message = 'deleted';

                    status_symbox = 'success';

                    status_prefix_message = '';

                    if(!result.status) {

                        status_message = 'sorry}';

                        status_prefix_message = 'cannot_delete_this_record_as\n';

                        status_symbox = 'info';

                    }

                    swal(status_message+"!", status_prefix_message+result.message, status_symbox,{
  button:false,
  timer: 2000,
}).then((value) => {
  location.reload(true);
});

                }

                else {
                  
                swal("Deleted'!", "Your record has been deleted", "success",{
  button:false,
  timer: 2000,
}).then((value) => {
  location.reload(true);
});

                }

                

            }

        });
      }else {
        swal("cancelled", "your_record_is_safe :)", "error",{
          button:false,
  timer: 2000,
        });
  }
});

}

</script>