
@if(session()->pull('success'))


<script>
    $(document).ready(function(){
        swal({
  title: "Succes!",
  text: "Record Added Successfuly!",
  icon: "success",
  buttons: false,
  timer: 2000,
});
    });
   
</script>
@endif

@if(session()->pull('nopermission'))


<script>
    $(document).ready(function(){
        swal({
  title: "Ooops..!",
  text: "You have no permission to access",
  icon: "error",
  buttons: false,
  timer: 2000,
});
    });
   
</script>
@endif



@if(session()->pull('failed'))


<script>
    $(document).ready(function(){
        swal({
  title: "Cancelled",
  text: "This Record is in use in other modules",
  icon: "error",
  buttons: false,
  timer: 2000,
});
    });
   
</script>
@endif
