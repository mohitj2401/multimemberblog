<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\Blog;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth;


class HomeController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {  
        $data['post']=Blog::whereNotNull('title')->latest()->paginate(6);
        $data['latest']=Blog::latest()->limit(3)->get();
        $data['categories']=Category::limit(5)->get();
        // $data['categories']=Category::has('blogs','>',2)
        $data['tags']=Tag::limit(5)->get();
        $data['title']="Blog";
        $data['active_class']="blog";
        return view('blog.blog',$data);
    }

    public function searchBlog(Request $request)
    {   
       
        $search='%'.$request->search.'%';
        $data['search']=$request->search;
        $data['post']=Blog::where('title','like',$search)->paginate(6);
        $data['latest']=Blog::latest()->limit(3)->get();
        $data['categories']=Category::limit(5)->get();
        $data['tags']=Tag::limit(5)->get();
        $data['title']="Blog";
        $data['active_class']="blog";
        return view('blog.search',$data);
    }
    public function searchBlogbyuser($slug)
    {   
       
        $user=User::where('slug',$slug)->first();
        
        $data['search']=$user->name;
        $data['post']=$user->blog()->whereNotNull('title')->paginate(6);
        $data['latest']=Blog::latest()->limit(3)->get();
        $data['categories']=Category::limit(5)->get();
        $data['tags']=Tag::limit(5)->get();
        $data['title']="Blog";
        $data['active_class']="blog";
        return view('blog.userpost',$data);
    }
    
    public function searchArtributeBlog($slug,$id)
    {   
       
        if($slug=="tag"){
            $tag=Tag::find($id);
            $data['search']=$tag->name;

            $data['post']=$tag->blogs()->whereNotNull('title')->paginate(6);
        }
        if($slug=="category"){
            $category=Category::find($id);
            $data['search']=$category->name;

            $data['post']=$category->blogs()->whereNotNull('title')->paginate(6);
        }
        
        $data['latest']=Blog::latest()->limit(3)->get();
        $data['categories']=Category::limit(5)->get();
        $data['tags']=Tag::limit(5)->get();
        $data['title']="Blog";
        $data['active_class']="blog";
        return view('blog.tagsorcategory',$data);
    }
    
    public function show($slug)
    {  
        $data['post']=Blog::where('slug',$slug)->first();
        $data['title']= Str::ucfirst($data['post']->title);
        $data['active_class']="post";
        $data['comments']=$data['post']->comment;
        $data['categories']=Category::limit(5)->get();
        $data['tags']=Tag::limit(5)->get();
        $data['latest']=Blog::latest()->limit(3)->get();
        
        return view('blog.post',$data);
    }


    public function addcomment($slug,Request $request)
    {
        
        if(Auth::check()){
            $request->validate([
                
                
                'body' => 'required|max:255',
                
                
                ]);
                $name=auth()->user()->name;
                $email=auth()->user()->email;
        }else{
            $request->validate([
                'name' => 'required|min:2',
                
                'body' => 'required|max:255',
                'email'=> 'required|max:255',
                
                ]);

                $name=$request->name;
                $email=$request->email;
        }
            $post=Blog::where('slug',$slug)->first();

            $comment = new Comment;

            
            $comment->name=$name;
            $comment->email=$email;
            $comment->body=$request->body;
            $post->comment()->save($comment);
           
            return redirect()->route('post.show',$post->slug);
    }




    public function addlike($slug,Request $request)
    {
        
        if(Auth::check()){
           
        
            $post=Blog::where('slug',$slug)->first();

            $comment = new Like;

            
            
            $comment->user_id=auth()->user()->id;
            
            $post->like()->save($comment);
           
            return redirect()->route('post.show',$post->slug);
        }
    }

    public function removelike($slug,Request $request)
    {
        
        if(Auth::check()){
           
        
            $post=Blog::where('slug',$slug)->first();

           
            
            
            $post->like()->where('user_id',auth()->user()->id)->delete();
            
           
           
            return redirect()->route('post.show',$post->slug);
        }
    }
}
