@extends('user.layouts.userlayout')
@section('content')

<main>
   <div class="container" style="margin-top: 20px;">
    <div class="card">
        <div class="card-header">{{ __('Edit Post') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('update.post',$post->slug) }}" enctype="multipart/form-data">
               
                @csrf

                <div class="form-group row">
                    <label class="col-md-2 col-form-label ">{{ __('Title') }}</label>

                    <div class="col-md-8">
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{$post->title}}" required  autofocus>

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label  class="col-md-2 col-form-label ">{{ __('Category') }}</label>

                    <div class="col-md-8">
                        <select class="form-control js-example-basic-multiple" name="category[]" multiple="multiple">
                            @foreach($categories as $category)
                                 <option value="{{$category->id}}"
                                    @if(in_array($category->id,json_decode($post->category))) selected @endif>{{$category->name}}</option>
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
                    <label  class="col-md-2 col-form-label ">{{ __('Tags') }}</label>

                    <div class="col-md-8">
                        <select class="form-control js-example-basic-multiple" name="tags[]" multiple="multiple">
                            @foreach($tags as $tag)
                                 <option value="{{$tag->id}}"
                                    @if(in_array($tag->id,json_decode($post->tags))) selected @endif>{{$tag->name}}</option>
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
                    <label  class="col-md-2 col-form-label">{{ __('Image') }}</label>
                    <div class="col-md-4">
                        <img src="{{asset('images/'.$post->image)}}" alt="" height="60", width="60">
                    </div>
                    <div class="col-md-4">
                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">

                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    
                    </div>
                </div>
                <div class="form-group row">
                    <label  class="col-md-2 col-form-label ">{{ __('Content') }}</label>

                    <div class="col-md-8">
                        <textarea   class="form-control @error('content') is-invalid @enderror" rows="10" name="content" required >{!!$post->content!!} </textarea>

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
                            {{ __('Edit Post') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
   </div>
</main>
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