<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Blog;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title']="Dashboard";
        $data['active_class']="dashboard";

       return view('user.index',$data);
    }

    public function getComment()
    {
        $data['title']="Analysis";
        $data['active_class']="analysis";
        if(auth()->user()->role!="admin"){
            $posts_id=Blog::where('user_id',auth()->user()->id)->get()->pluck('id');
            $comment=Comment::whereIn('blog_id',$posts_id)->get();
        }else{
            
            $comment=Comment::latest()->get();
        }
        
        $data['comments']=$comment;
        return view('user.comment',$data);
    }

    public function deleteComment($id,Request $request)

    {
        $comment=Comment::find($id);
        
        try{
            
            $comment->delete();
            
            $response['status'] = 1;
            $response['message'] = 'Record Deleted Successfully';
          } catch ( \Illuminate\Database\QueryException $e) {
                     $response['status'] = 0;
               
                $response['message'] =  'This Record is in use in other modules';
           }
           return json_encode($response);
    }

    public function getView()
    {   
        if(auth()->user()->role!="admin"){
            $post=Blog::where('user_id',auth()->user()->id)->get();
        }else{
            $post=Blog::latest()->get();
        }
       
        $data['title']="Views Post";
        $data['posts']=$post;
        $data['active_class']="analysis";
        return view('user.view',$data);
    }


    public function getUsers(Request $request)
    {
        if(auth()->user()->role!="admin"){
            $request->session()->push('nopermission', 'yes');
            return redirect()->route('user.panel');
        }
        $users=User::where('role',"student")->get();
        
        $data['title']="Users";
        $data['users']=$users;
        $data['active_class']="users";
        return view('user.userlist',$data);
    }
    public function getUserApprove(Request $request,$id=null)
    {
        if(auth()->user()->role!="admin"){
            $request->session()->push('nopermission', 'yes');
            return redirect()->route('user.panel');
        }
        if($request->isMethod('post')){
            $record=User::where('id',$request->id)->first();
            $record->status=$request->status;
            $record->save();
           
            
        }

        $users=User::all();
        
        $data['title']="Approve Users";
        $data['users']=$users;
        $data['active_class']="users";
        return view('user.userallowance',$data);
    }


    public function deleteUsers($slug)
    {
        if(auth()->user()->role!="admin"){
            $request->session()->push('nopermission', 'yes');
            return redirect()->route('user.panel');
        }
        
        $record=User::where('slug',$slug)->first();
        
        try{
            
            foreach($record->blog as $post){
                $post->comment()->delete();
                $post->tags()->detach();
                $post->category()->detach();
                $post->delete();
            }


            $record->delete();
            
            $response['status'] = 1;
            $response['message'] = 'Record Deleted Successfully';
          } catch ( \Illuminate\Database\QueryException $e) {
                     $response['status'] = 0;
               
                $response['message'] =  'This Record is in use in other modules';
           }
           return json_encode($response);
    }
}
