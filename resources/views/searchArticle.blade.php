@extends('layouts.master')

@section('content')
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Search Articles</h1>
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
            <form action="{{route('searchResult')}}" method="post">
              @csrf
              <div class="form-group">
                <label for="articleTitle">Title</label>
                <input type="text" class="form-control" id="articleTitle" aria-describedby="articleTitle" placeholder="Enter search term" name="title">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->
      
@endsection
