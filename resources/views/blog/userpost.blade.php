 @extends('blog.layout.bloglayouts')
 @section('content')
     
 
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
          <div class="container">
            <div class="row">
            <h1 style="margin-bottom: 50px">Blog from {{$search}}...</h1>
            @if($post->count()==0)
            <div class="container">
           <center> <p style="margin: 10px">There is No result found for this user</p></center>
          </div>
           @endif
            
             @foreach ($post as $blog)
                 
             
              <div class="post col-xl-6">
                <div class="post-thumbnail"><a href="{{route('post.show',$blog->slug)}}"><img src="{{asset('images/'.$blog->image)}}" alt="..." class="img-fluid"></a></div>
                <div class="post-details">
                  <div class="post-meta d-flex justify-content-between">
                    <div class="date meta-last">{{$blog->created_at->toFormattedDateString()}}</div>
                    <?php ?>
                    <div class="category"><a href="{{route('blog.search',['slug'=>'category','id'=>$blog->category()->first()->id])}}">{{$blog->category()->first()->name}}</a></div>
                  </div><a href="{{route('post.show',$blog->slug)}}">
                  <h3 class="h4">{{Str::ucfirst($blog->title)}}</h3></a>
                  <div style="word-break: break-all;">
                    <p class="text-muted" >{!!Str::of($blog->content)->limit(90, ' ...')!!}</p>
                  </div>
                  <div class="post-footer d-flex align-items-center"><a href="{{route('blog.user.show',$blog->user->slug)}}" class="author d-flex align-items-center flex-wrap">
                      
                  <div class="title"><span>{{$blog->user->name}}</span></div></a>
                    <div class="date"><i class="icon-clock"></i> {{$blog->created_at->diffForHumans()}}</div>
                    <div class="comments meta-last"><i class="icon-comment"></i>{{$blog->comment->count()}}</div>
                    <div class="comments meta-last">|<i class="fa fa-thumbs-up" style="padding-left:5px "></i>{{$blog->like->count()}}</div>
                  </div>
                </div>
              </div>
              @endforeach
              
            </div>
           <center> {!! $post->links('pagination::bootstrap-4') !!}</center>
            <!-- Pagination -->
           
          </div>
        </main>
     
 @endsection
  