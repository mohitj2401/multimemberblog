@extends('user.layouts.userlayout')
@section('content')
<main>
    <div class="container-fluid" style="margin-bottom:20px">
        <h1 class="mt-4" style="margin-bottom: 15px">Posts</h1>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Tags</th>
                        <th>category</th>
                        <th>Image</th>

                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td>{{$post->title}}</td>
                        <td style="word-break: break-all;"><p>{!!$post->content!!}</p></td>
                        <?php $tags=json_decode($post->tags);
                        $tag_name=App\Models\Tag::whereIn('id',$tags)->get()->pluck('name');
                        ?>
                        <td>{{collect($tag_name)->implode(' ,')}}</td>

                        <?php $category=json_decode($post->category);
                        $category_name=App\Models\Category::whereIn('id',$category)->get()->pluck('name');
                        ?>
                        <td>{{collect($category_name)->implode(' ,')}}</td>
                        <td><img src="{{asset('images/'.$post->image)}}" alt="" height="100" width="100"></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                   
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                     <a class=" dropdown-item" style="margin-right: 5px" href="{{route('edit.post',$post->slug)}}"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
                                   
                                <a class="dropdown-item"style="margin-right: 5px" href="javascript:void(0);" onclick="deleteRecord('{{$post->slug}}');"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                  
                                </div>
                              </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</main>

@section('custum-scripts')

@include('common.deletescript',array('route'=>'/delete/post/'))
  
@endsection
@endsection
