@extends('layouts.master')

@section('content')
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">List Articles</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
      <div class="col-12"> 
        <div class="card">
          <div class="card-body">
          <div class="w-100 text-right">
            <a href="{{route('addNewArticleForm')}}" class="btn btn-primary">Add Article</a>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Tags</th>
                <th scope="col">Created By</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($articles as $article)
                <tr>
                  <td>{{$article->id}}</td>
                  <td>{{$article->title}}</td>
                  <td>{!! $article->TagNames !!}</td>
                  <td>{{$article->UserName}}</td>
                  <td>{{date("d/m/Y", strtotime($article->created_at))}}</td>
                  <td>
                    <a href="{{route('viewArticle', [$article->id])}}" class="btn btn-info">View</a> 
                    @if($article->users_id == Auth::id() || Auth::user()->role == 'Admin')
                      <a href="{{route('editArticle', [$article->id])}}" class="btn btn-info">Edit</a>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- /.container-fluid -->


      
@endsection
