<aside class="col-lg-4">
    <!-- Widget [Search Bar Widget]-->
    <div class="widget search">
      <header>
        <h3 class="h6">Search the blog</h3>
      </header>
    <form action="{{route('blog.search.show')}}" method="post" class="search-form" role="search">
      {{ csrf_field() }}
        <div class="form-group">
          <input type="search" placeholder="What are you looking for?" name="search">
          <button type="submit" class="submit"><i class="icon-search"></i></button>
        </div>
      </form>
    </div>
    <!-- Widget [Latest Posts Widget]        -->
    <div class="widget latest-posts">
      <header>
        <h3 class="h6">Latest Posts</h3>
      </header>
      <div class="blog-posts">
        @foreach($latest as $blog)
            
        
      <a href="{{route('post.show',$blog->slug)}}">
          <div class="item d-flex align-items-center">
            <div class="image"><img src="{{asset('images/'.$blog->image)}}" alt="..." class="img-fluid"></div>
          <div class="title"><strong>{{Str::ucfirst($blog->title)}}</strong>
              <div class="d-flex align-items-center">
                <div class="views"><i class="icon-eye"></i>{{$blog->view}}</div>
              <div class="comments"><i class="icon-comment"></i>{{$blog->comment->count()}}</div>
              <div class="comments">|<i class="fa fa-thumbs-up"  style="padding-left:4px"></i>{{$blog->like->count()}}</div>
              </div>
            </div>
          </div></a>
          @endforeach
        </div>
    </div>
    <!-- Widget [Categories Widget]-->
    <div class="widget categories">
      <header>
        <h3 class="h6">Categories</h3>
      </header>
      @foreach ($categories as $category)
    <div class="item d-flex justify-content-between"><a href="{{route('blog.search',['slug'=>'category','id'=>$category->id])}}">{{Str::ucfirst($category->name)}}</a><span>{{$category->blogs->count()}}</span></div>
      @endforeach
    </div>
    <!-- Widget [Tags Cloud Widget]-->
    <div class="widget tags">       
      <header>
        <h3 class="h6">Tags</h3>
      </header>
      <ul class="list-inline">
        @foreach ($tags as $tag)
            
       
      <li class="list-inline-item"><a href="{{route('blog.search',['slug'=>'tag','id'=>$tag->id])}}" class="tag">#{{$tag->name}}</a></li>
       
        @endforeach
      </ul>
    </div>
  </aside>
