@extends('user.layouts.userlayout')

@section('content')

<main>
   <div class="container" style="margin-top: 20px;">
    <div class="card">
        <div class="card-header">{{ __('Create Post') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('create.post') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label class="col-md-3 col-form-label ">{{ __('Title') }}</label>

                    <div class="col-md-8">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required  autofocus>

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label  class="col-md-3 col-form-label ">{{ __('Category') }}&nbsp;&nbsp;
                        <!-- Button trigger modal -->
<a type="button" style="curson:pointer" data-toggle="modal" data-target="#exampleModalCenter">
    
                        <i class="fa fa-plus-circle "></i>
                    </a></label>


  
                    <div class="col-md-8">
                        <select class="form-control js-example-basic-multiple" name="category[]" multiple="multiple" required>
                           @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                           @endforeach
                        </select>
                       

                        @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label  class="col-md-3 col-form-label ">{{ __('Tags') }}&nbsp;&nbsp;
                        <!-- Button trigger modal -->
<a type="button" style="curson:pointer" data-toggle="modal" data-target="#exampleModalCenterTag">
    
                        <i class="fa fa-plus-circle "></i>
                    </a></label>

                    <div class="col-md-8">
                        <select class="form-control js-example-basic-multiple" name="tags[]" multiple="multiple" required>
                            @foreach($tags as $tag)
                                 <option value="{{$tag->id}}">{{$tag->name}}</option>
                            @endforeach
                         </select>
                        @error('tags')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row">
                    <label  class="col-md-3 col-form-label">{{ __('Image') }}</label>

                    <div class="col-md-8">
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" required>

                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    
                    </div>
                </div>
                <div class="form-group row">
                    <label  class="col-md-3 col-form-label ">{{ __('Content') }}</label>

                    <div class="col-md-8">
                        <textarea   class="form-control @error('content') is-invalid @enderror" rows="10" name="content" required >{{ old('content') }} </textarea>

                        @error('content')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Create Post') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
   </div>
</main>



  
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Add New Category</h5>
          
        </div>
        <form action="{{route('add.category')}}" method="post">

        <div class="modal-body">
            {{ csrf_field() }}
            <input type="text" name="name" class="form-control" >
         
        
        </div>
        <div class="modal-footer">
          
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
      </div>
    </div>
  </div>

   <!-- Modal -->
   <div class="modal fade" id="exampleModalCenterTag" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Add New Tag</h5>
          
        </div>
        <form action="{{route('add.tag')}}" method="post">

        <div class="modal-body">
            {{ csrf_field() }}
            <input type="text" name="name" class="form-control" >
         
        
        </div>
        <div class="modal-footer">
          
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
      </div>
    </div>
  </div>

@endsection
@section('custum-scripts')
@include('common.alertswal')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
<script>
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
    CKEDITOR.replace( 'content' );
</script>
@endsection