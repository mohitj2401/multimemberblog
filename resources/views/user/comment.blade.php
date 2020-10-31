@extends('user.layouts.userlayout')
@section('content')
<main>
    <div class="container-fluid" style="margin-bottom:20px">
        <h1 class="mt-4" style="margin-bottom: 15px">Posts</h1>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Post Title</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Comment Body</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($comments as $comment)
                    <tr>
                        <td>{{$comment->blog->title}}</td>
                        <td>{{$comment->name}}</td>
                        <td>{{$comment->email}}</td>
                        <td>{{$comment->body}}</td>
                        <td>
                            
                               
                                    
                                <a class="dropdown-item"style="margin-right: 5px" href="javascript:void(0);" onclick="deleteRecord({{$comment->id}})"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                  
                               
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</main>

@section('custum-scripts')

@include('common.deletescript',array('route'=>'/user/delete/comments/'))
@endsection
@endsection
