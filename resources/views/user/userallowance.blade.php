@extends('user.layouts.userlayout')
@section('content')
<main>
    <div class="container-fluid" style="margin-bottom:20px">
        <h1 class="mt-4" style="margin-bottom: 15px">User Requested</h1>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <input type="checkbox" class="userStatus btn" rel="{{$user->id}}" data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="danger" @if ($user->status==1)
                            checked
                                
                            @endif>
                        </td>
                        
                        <td>
                            
                               
                                    
                                <a class="dropdown-item"style="margin-right: 5px" href="javascript:void(0);" onclick="deleteRecord('{{$user->slug}}');"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                  
                               
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</main>

@section('custum-scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap2-toggle.js"></script>
@include('common.deletescript',array('route'=>'/admin/delete/user/'))
<script>
    $(document).ready( function () {
        $('#dataTable1').DataTable({
            "scrollY":        "400px",
            "scrollCollapse": true,
            "paging":         false
        });
     $('.userStatus').change(function() {
       
       var id=$(this).attr('rel');
       var token = '{{ csrf_token()}}';
   
       if ($(this).prop('checked')==true) {
           $.ajax({
              
               type:'post',
               url:'/admin/user/approve',
               data:{status:'1',id:id,_token:token},
               success:function(data){
                   swal('Success',"Status Enabled", "success",{
 button:false,
 timer: 2000,
});

               },
               error:function() {
                   
                   alert('Something Went Wrong Please Try Again!');
               }

           });
       }else{
           $.ajax({
               type:'post',
               url:'/admin/user/approve',
               data:{status:'0',id:id,_token:token},
               success:function(resp){
                   swal('Warning', "Status Disabled", "success",{
 button:false,
 timer: 2000,
});

                   

               },
               error:function(err) {
                alert('Something Went Wrong Please Try Again!');
               }

           })
       }
   });
    });
</script>
@endsection
@endsection
