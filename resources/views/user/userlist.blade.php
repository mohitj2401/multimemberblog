@extends('user.layouts.userlayout')
@section('content')
    <main>
        <div class="container-fluid" style="margin-bottom:20px">
            <h1 class="mt-4" style="margin-bottom: 15px">User Analytics</h1>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>User Email</th>
                            <th>No. of Post</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->blog()->count() }}</td>

                                <td>



                                    <a class="dropdown-item" style="margin-right: 5px" href="javascript:void(0);"
                                        onclick="deleteRecord('{{ $user->slug }}');"><i
                                            class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>


                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>

@section('custum-scripts')

    @include('common.deletescript',array('route'=>'/admin/delete/user/'))
@endsection
@endsection
