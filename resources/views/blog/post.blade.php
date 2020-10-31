 @extends('blog.layout.bloglayouts')
 @section('content')
     
 

        <!-- Latest Posts -->
        <main class="post blog-post col-lg-8"> 
          <div class="container">
            <div class="post-single">
            <div class="post-thumbnail"><img src="{{asset('images/'.$post->image)}}" alt="{{$post->title}}" class="img-fluid"></div>
              <div class="post-details">
                <div class="post-meta d-flex justify-content-between">
                  <div class="category">
                    <?php $category_ids=json_decode($post->category);
                        $category_posts=App\Models\Category::whereIn('id',$category_ids)->get();
                  ?>
                  @foreach($category_posts as $category)
                    <a href="{{route('blog.search',['slug'=>'category','id'=>$category->id])}}">{{$category->name}}</a>
                  @endforeach
                   
                  </div>
                </div>
              <h1>{{Str::ucfirst($post->title)}}<a href="#"><i class="fa fa-bookmark-o"></i></a></h1>
                <div class="post-footer d-flex align-items-center flex-column flex-sm-row"><a href="#" class="author d-flex align-items-center flex-wrap">
                    
                <div class="title"><span>{{$post->user->name}}</span></div></a>
                  <div class="d-flex align-items-center flex-wrap">       
                    <div class="date"><i class="icon-clock"></i> {{$post->created_at->diffForHumans()}}</div>
                  <div class="views"><i class="icon-eye"></i> {{$post->view?$post->view:0}}</div>
                  <div class="comments meta-last"><i class="icon-comment"></i>{{$comments->count()}}</div>
                  </div>
                  <div class="comments meta-last">|<i class="fa fa-thumbs-up" style="padding-left:5px "></i>{{$post->like->count()}}</div>
                </div>
                <div class="post-body" style="word-break: break-all;">
                  
                {!!$post->content!!}
                  
                </div>

                <div style="margin:20px">
                <p style="color: #9055A2;font-size:18px;"> 
                  @guest 
                    
                      
                      <a class="not-auth"><i class="fa fa-thumbs-up" style="color:black;font-size:35px;" ></i></a>
                   
                  @else 
                    @if($post->like()->where('user_id',auth()->user()->id)->get()->count()>0) 
                    <a href="{{route('add.dislike',$post->slug)}}"> <i class="fa fa-thumbs-up" style="color:#9055A2;font-size:35px;" ></i></a>
                    @else 
                      <a href="{{route('add.like',$post->slug)}}"><i class="fa fa-thumbs-up" style="color:black;font-size:35px;" ></i></a>
                    @endif
                  @endguest
                  
                 
                {{$post->like()->count()}}</p>
                 
                </div>
                <div class="post-tags">
                  <?php $tag_ids=json_decode($post->tags);
                        $tag_posts=App\Models\Tag::whereIn('id',$tag_ids)->get();
                  ?>
                  @foreach($tag_posts as $tag)
                    <a href="{{route('blog.search',['slug'=>'tag','id'=>$tag->id])}}" class="tag">#{{$tag->name}}</a>
                  @endforeach
                </div>
                
                <div class="post-comments">
                  <header>
                    <h3 class="h6">Post Comments<span class="no-of-comments">({{$comments->count()}})</span></h3>
                  </header>
                  @foreach ($comments as $comment)
                      
                 
                  <div class="comment">
                    <div class="comment-header d-flex justify-content-between" style="margin-left: 55px;">
                      <div class="user d-flex align-items-center">
                        
                      <div class="title"><strong>{{Str::ucfirst($comment->name)}}</strong><span class="date">{{$comment->created_at->diffForHumans()}}</span></div>
                      </div>
                    </div>
                    <div class="comment-body">
                      <p>{{$comment->body}}</p>
                    </div>
                  </div>

                  @endforeach
                </div>
                <div class="add-comment">
                  <header>
                    <h3 class="h6">Leave a reply</h3>
                  </header>
                <form action="{{route('add.comment',$post->slug)}}" class="commenting-form" method="POST">
                  {{ csrf_field() }}
                    <div class="row">
                      <div class="form-group col-md-6">
                      <input type="text" name="name" id="username" placeholder="Name" class="form-control  @error('name') is-invalid @enderror" @guest @else value="{{auth()->user()->name}}" disabled @endguest>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                      </div>
                      <div class="form-group col-md-6">
                        <input type="email" name="email"  placeholder="Email Address (will not be published)" class="form-control  @error('email') is-invalid @enderror"  @guest @else value="{{auth()->user()->email}}" disabled @endguest>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                      </div>
                      <div class="form-group col-md-12">
                        <textarea name="body" id="usercomment" placeholder="Type your comment" class="form-control"  @error('body') is-invalid @enderror></textarea>
                        @error('body')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                      </div>
                      <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-secondary">Submit Comment</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </main>
    @section('custum_script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @guest 

    <script>
      $(document).load(function () {
        <?php 
        $post->view=$post->view+1;
        $post->save();
        ?>
       });

      </script>
    
    
    
    @endguest
    <script>
      $(".not-auth").click(function (e) {
        swal({
  title: "Login For Like?",
  text: "Once Login, you will be able to like this Post!",
  icon: "warning",
  buttons: true,
  buttons: ["Cancel", "Login"],

  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    window.location="/login";
  }
});
       });
      
    </script>
    @endsection
 @endsection