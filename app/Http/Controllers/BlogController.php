<?php


namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Tag;
use App\Models\Category;
use File;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        if(auth()->user()->role!="admin"){
            $post=Blog::where('user_id',auth()->user()->id)->get();
        }else{
            $post=Blog::latest()->get();
        }
       
        $data['title']="View Post";
        $data['posts']=$post;
        $data['active_class']="posts";
        return view('user.viewpost',$data);
    }

    public function show()
    {
        $data['title']="Create Post";
        $data['active_class']="posts";
        $data['tags']=Tag::latest()->get();
        $data['categories']=Category::latest()->get();
        return view('user.createpost',$data);
    }

    public function edit($slug)
    {
        
        $data['title']="Edit Post";
        $data['post']=Blog::where('slug',$slug)->first();
        $data['tags']=Tag::all();
        $data['categories']=Category::all();
        $data['active_class']="posts";

        return view('user.editpost',$data);
    }
    public function store(Request $request)
    {
       
        $user=auth()->user();
       $request->validate([
        'title' => 'required|max:255',
        
        'tags' => 'required',
        'category'=> 'required',
        'image' => 'image|mimes:jpeg,png,jpg|max:1024',
        'content' => 'required|min:50',
       ],);
        $slug = Str::of($request->title)->slug('-');
        
        for($i=0;Blog::where('slug',$slug)->count()>0;$i++){
            $slug=$slug.rand(10,100);

        }
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);
        $blog=new Blog;
        $blog->image=$imageName;
       
        $blog->slug=$slug;
        $blog->title=$request->title;
        $blog->content=$request->content;
        
        $blog->tags=json_encode($request->tags);

        $blog->category=json_encode($request->category);
        $user->blog()->save($blog);
        foreach($request->tags as $tag){
            $blog->tags()->attach($tag); 
        }
        foreach($request->category as $cary){
            $blog->category()->attach($cary); 
        }
        

        return redirect()->route('post.admin.view');
    }

    public function delete($slug)
    {
      
      /**
       * Delete the questions associated with this quiz first
       * Delete the quiz
       * @var [type]
       */
        $record = Blog::where('slug', $slug)->first();
        
            try{
            
                File::delete('images/'.$record->image);
                $record->comment()->delete();
                $record->tags()->detach();
                $record->category()->detach();

                 $record->delete();
                
                $response['status'] = 1;
                $response['message'] = 'Record Deleted Successfully';
              } catch ( \Illuminate\Database\QueryException $e) {
                         $response['status'] = 0;
                   
                    $response['message'] =  'This Record is in use in other modules';
               }
               return json_encode($response);
        
       
    }

    public function update($slug,Request $request)
    {
        if($request->has('image')){
            $request->validate([
                'title' => 'required|max:255',
                
                'tags' => 'required',
                'category'=> 'required',
                'image' => 'image|mimes:jpeg,png,jpg|max:1024',
                'content' => 'required|min:50',
                ]);
        
                
                $imageName = time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('images'), $imageName);

                

                $blog= Blog::where('slug',$slug)->first();
                File::delete('images/'.$blog->image);
                $title=$blog->title;
                $blog->image=$imageName;
                if($title!=$request->title){
                    $slug = Str::of($request->title)->slug('-');
                
                    for($i=0;Blog::where('slug',$slug)->count()>0;$i++){
                        $slug=$slug.rand(10,100);
            
                    }
                   
                   
                    $blog->slug=$slug;
                    $title=$request->title;
                }
                
                $blog->title=$title;
                $blog->content=$request->content;
                $blog->tags()->detach();
                $blog->category()->detach();

                $blog->category=json_encode($request->category);
                $blog->tags=json_encode($request->tags);
                $blog->save();
                foreach($request->tags as $tag){
                    $blog->tags()->attach($tag); 
                }
                foreach($request->category as $catey){
                    $blog->category()->attach($catey); 
                }
                return redirect()->route('post.admin.view');
        
        }else{
            $request->validate([
                'title' => 'required|max:255',
                
                'tags' => 'required',
                'category'=> 'required',
                
                'content' => 'required|min:50',
                ]);
        
                $blog= Blog::where('slug',$slug)->first();
                $title=$blog->title;
                $blog->tags()->detach();
                $blog->category()->detach();

                if($title!=$request->title){
                    $slug = Str::of($request->title)->slug('-');
                
                    for($i=0;Blog::where('slug',$slug)->count()>0;$i++){
                        $slug=$slug.rand(10,100);
            
                    }
                   
                   
                    $blog->slug=$slug;
                    $title=$request->title;
                }
                
                $blog->title=$title;
                $blog->content=$request->content;
                $blog->tags=json_encode($request->tags);

        $blog->category=json_encode($request->category);
                $blog->save();
                foreach($request->tags as $tag){
                    $blog->tags()->attach($tag); 
                }
                foreach($request->category as $cegory){
                    $blog->category()->attach($cegory); 
                }
                return redirect()->route('post.admin.view');
           
        }
    }

    public function addTag(Request $request)
    {
        $tag=new Tag;
        $tag->name=$request->name;
        $tag->save();
        try{
            
            $tag->save();

            $request->session()->push('success', 'yes');
          } catch ( \Illuminate\Database\QueryException $e) {
            $request->session()->push('failed', 'yes');
           }
           return redirect()->back();
    }

    public function addCategory(Request $request)
    {
        $category=new Category;
        $category->name=$request->name;
        $category->save();
        try{
            
            $category->save();
            $request->session()->push('success', 'yes');
           
          } catch ( \Illuminate\Database\QueryException $e) {
                    
            $request->session()->push('failed', 'yes');

           }
           
          
           return redirect()->back();
    }



    // public function getDatatable($slug = '')
    // {
        

    //     $records=Blog::all();

    //     return Datatables::of($records)
    //     ->addColumn('action', function ($records) {
    //      $link_data='<div class="dropdown">
    //      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            
    //      </button>
    //      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    //           <a class=" dropdown-item" style="margin-right: 5px" href=""><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
    //        <a class="dropdown-item"style="margin-right: 5px" href="javascript:void(0);" onclick="delete1();"><i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
           
    //      </div>
    //    </div>';
    //         return $link_data;
    //         })
    //      ->editColumn('title', function($records) {
         
    //       return $records->title;
    //     })
    //      ->editColumn('image', function($records){
    //         return '<img src="'.$records->image.'" height="60" width="60" />';
    //     })
    //      ->editColumn('tags', function($records){
    //         return $records->tags;
    //     })
    //     ->editColumn('category', function($records){
    //       return $records->category;
    //     })
    //     ->editColumn('content', function($records){
    //         return $records->content;
    //       })
       

        

        
    //     ->removeColumn('id')
    //     ->removeColumn('created_at')
    //     ->removeColumn('updated_at')
    //     // ->addAction('action',['printable' => false])

    //     ->make();
    // }


}
