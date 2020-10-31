
<script>


function addRecord() {
        
            var token = '{{ csrf_token()}}';

          route = '{{$route}}';  

        $.ajax({

            url:route,

            type: 'post',

            data: {_method: 'post', _token :token},

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
     
}

</script>