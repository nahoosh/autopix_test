<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Articles;
use App\Model\Comments;
use Auth;
use Validator;
use File;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function listArticles()
    {
        if(Auth::User()->role == 'Admin')
        {
            $articles = Articles::get();
        }
        else
        {
            $articles = Articles::where('users_id',Auth::id())->get();
        }

        return view('listArticles', compact('articles'));
    }

    public function editArticle($id)
    {
        if(Auth::User()->role == 'Admin')
        {
            $article = Articles::where('id',$id)->first();
        }
        else
        {
            $article = Articles::where('users_id',Auth::id())->where('id',$id)->first();
        }

        if(!$article)
        {
            return redirect()->back()->with('message', 'You are not authorised to edit this article.');
        }

        return view('editArticles', compact('article'));
    }

    public function viewArticle($id)
    {
        $article = Articles::where('id',$id)->first();

        if(!$article)
        {
            return redirect()->back()->with('message', 'Article not found.');
        }

        return view('viewArticle', compact('article'));
    }

    public function addNewArticleForm()
    {
        return view('addNewArticle');
    }

    public function addNewArticle(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'       =>  'required',
            'tags'   =>  'required',
            'description'   =>  'required',
            'image'     => 'max:10000|mimes:jpg,jpeg,png,bmp,tiff'
        ]);

         if($validator->fails()) {
            return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator);
        }

        $data = array();

        $file = $request->file('image');
        if($file)
        {
            $document_file = rand() . '.' . $file->getClientOriginalExtension();
            $path = public_path().'/storage/images';
            File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
            $file->move($path, $document_file);
            $data['image'] = env('APP_URL').'/storage/images/'.$document_file;
        }

        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['tags'] = $request->tags;
        $data['users_id'] = Auth::id();
        $data['created_at'] = now();
        
        Articles::insert($data);
        return redirect()->back()->with('message', 'Article Saved.');
    }

    public function saveArticle(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title'       =>  'required',
            'tags'   =>  'required',
            'description'   =>  'required',
            'image'     => 'max:10000|mimes:jpg,jpeg,png,bmp,tiff'
        ]);

         if($validator->fails()) {
            return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator);
        }

        $article = Articles::find($id);

        if($article->users_id == Auth::id())
        {
            $file = $request->file('image');
            if($file)
            {
                $document_file = rand() . '.' . $file->getClientOriginalExtension();
                $path = public_path().'/storage/images';
                File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
                $file->move($path, $document_file);
                $article->image = env('APP_URL').'/storage/images/'.$document_file;
            }

            $article->title = $request->title;
            $article->description = $request->description;
            $article->tags = $request->tags;
            $article->updated_at = now();
            $article->save();
            return redirect()->back()->with('message', 'Article Saved.');
            // $article->title = $request->title;
        }
        else
        {
            return redirect()->back()->with('error_message', 'You are not authorised to edit this article.');
        }
    }

    public function addComment(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'comment'       =>  'required'
        ]);

         if($validator->fails()) {
            return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator);
        }

        $newComment = array(
            'user_id' => Auth::id(),
            'article_id' => $id,
            'comment' => $request->comment,
            'created_at' => now()
        );

        Comments::insert($newComment);

        return redirect()->back()->with('message', 'Comment Saved.');
    }

    public function searchArticles()
    {
        return view('searchArticle');
    }

    public function searchResult(Request $request)
    {
        if($request->title == '')
        {
            return redirect()->back()->with('error_message', 'Search field is required.');
        }

        $articles = Articles::query()
                ->where('title', 'LIKE', "%{$request->title}%") 
                ->orWhere('tags', 'LIKE', "%{$request->title}%") 
                ->get();
        return view('listArticles', compact('articles'));
    }
}
