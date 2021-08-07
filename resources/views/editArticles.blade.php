@extends('layouts.master')

@section('content')
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Edit Article</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
      <div class="col-12"> 
        @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif

        @if(session()->has('message'))
          <div class="alert alert-success">
              {{ session()->get('message') }}
          </div>
        @endif

        @if(session()->has('error_message'))
          <div class="alert alert-danger">
              {{ session()->get('error_message') }}
          </div>
        @endif
        <div class="card">
          <div class="card-body">
            <form action="{{route('saveArticle',[$article->id])}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="articleTitle">Title</label>
                <input type="text" class="form-control" id="articleTitle" aria-describedby="articleTitle" placeholder="Enter title" name="title" value="{{$article->title}}">
              </div>
              <div class="form-group">
                <label for="articleDescription">Description</label>
                <textarea class="form-control" id="articleDescription" aria-describedby="articleDescription" placeholder="Description" name="description">{{$article->description}}</textarea>
              </div>
              <div class="form-group">
                <label for="articleTags">Tags</label>
                <input type="text" class="" id="articleTags" aria-describedby="articleTags" placeholder="Enter Tags" name="tags" value="{{$article->tags}}">
              </div>
              <div class="form-group">
                <label for="articleImage">Image</label>
                @if($article->image != '')
                  <br>
                  <img src="{{$article->image}}" width="200">
                  <br>
                  <br>
                @endif
                <input type="file" class="form-control" id="articleImage" aria-describedby="articleImage" name="image">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->

  <script>
    $("#articleTags").selectize({
      delimiter: ",",
      persist: false,
      create: function (input) {
        return {
          value: input,
          text: input,
        };
      },
    });
  </script>


      
@endsection
