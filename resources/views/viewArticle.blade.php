@extends('layouts.master')

@section('content')
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Article</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
      <div class="col-12"> 
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <label class="w-100 font-weight-bold">Title</label>
                {{$article->title}}
              </div>

              <div class="col-12">
                <label class="w-100 font-weight-bold">Desctiption</label>
                {{$article->description}}
              </div>

              <div class="col-12">
                <label class="w-100 font-weight-bold">Tags</label>
                {!!$article->TagNames!!}
              </div>
            
              <div class="col-12">
                <label class="w-100 font-weight-bold">Image</label>
                @if($article->image != '')
                  <br>
                  <img src="{{$article->image}}" width="200">
                  <br>
                  <br>
                @endif
              </div>

              <div class="col-12">
                <label class="w-100 font-weight-bold">Comments</label>
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
                <form action="{{route('addComment',[$article->id])}}" method="post">
                  @csrf
                  <div class="form-group">
                    <label for="articleTitle">Add Comment</label>
                    <input type="text" class="form-control" id="articleTitle" aria-describedby="articleTitle" placeholder="Enter comment" name="comment">
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <br>
                <label class="w-100 h3">Previous Comments</label>
                <div class="h-50 overflow-auto">
                    @foreach($article->CommentDetails as $comment)
                      {{$comment->comment}}
                      <br>
                      - {{ $comment->UserName }}
                      <br>
                      <small>{{ date("d M Y H:i:A", strtotime($comment->created_at))}}</small>
                      <br><br>
                    @endforeach
                </div>
              </div>           
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
