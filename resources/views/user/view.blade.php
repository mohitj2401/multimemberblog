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
                        <th>View</th>
                        
                    </tr>
                </thead>

                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td>{{$post->title}}</td>
                        <td>{{$post->view}}</td>
                       
                       

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</main>


@endsection
