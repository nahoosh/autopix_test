<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Articles;
use App\Model\Comments;
use Auth;
use Validator;
use File;
use DB;
use Response;

/**
 *  @OA\Info(
 *      version="1.0.0",
 *      title="AutoPix API",
 *      description="AutoPix API Functions",
 *      @OA\Contact(
 *          email="nahoosh.rakhe@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      ),
 *      @OA\SecurityScheme(
 *          securityScheme="api_key",
 *          in="header",
 *          name="API Key",
 *          scheme="bearer"
 *      ),
 *  )

*  @OA\Server(
*      url="https://localhost/autopix/public/api/",
*      description="AutoPix API"
* )
*/
class APIController extends Controller
{
    public function makeResponse($result, $message, $code)
    {
        return [
            'flag' => true,
            'data' => $result,
            'message' => $message,
            'code' => $code
        ];
    }


    public function makeError($result, $message, $code)
    {
        return [
            'flag' => false,
            'data' => $result,
            'message' => $message,
            'code' => $code
        ];
    }


    /**  
     * @OA\Get(  
     *   tags={"Articles Functions"},
     *   path="/listArticles",  
     *   description="List articles.",  
     *   operationId="listArticles",  
     *   @OA\Response(  
     *       response=200,  
     *       description="Response",
     *       @OA\JsonContent(
     *           @OA\Schema(
     *               ref="#/components/schemas/apiResponse"
     *           ),
     *           example={"flag":true,"data":"Your data","message":"Message","code":"200"}
     *       ),
     *  ),
     *   @OA\Response(response="403", description="Unauthorized")
     * )  
     */
    public function listArticles()
    {
        $articles = Articles::get();

        foreach($articles as $article)
        {
            $article->UserName = $article->UserName;
        }

        return Response::json($this->makeResponse(array('articles' => $articles), array('message' => "Articles listed successfully."), 1));
    }

    /**  
     * @OA\Post(  
     *   tags={"Articles Functions"},
     *   path="/viewArticle",  
     *   description="View article.",  
     *   operationId="viewArticle",   
     *   
     *   @OA\RequestBody(  
     *       request="body",
     *       description="Article ID",  
     *       required=true,
     *       @OA\JsonContent(  
     *           @OA\Schema(
     *               ref="#/components/schemas/createUserRequest"
     *           ),
     *           example={"id": "1"} 
     *       )
     *   ),  
     *   @OA\Response(  
     *       response=200,  
     *       description="Response",
     *       @OA\JsonContent(
     *           @OA\Schema(
     *               ref="#/components/schemas/apiResponse"
     *           ),
     *           example={"flag":true,"data":"Your data","message":"Message","code":"200"}
     *       ),
     *  ),
     *   @OA\Response(response="403", description="Unauthorized")
     * )  
     */
    public function viewArticle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            // return response()->json(array("Error"=>"Email already exists."));
            return $this->makeError(array(), array('error' => $validator->errors()), 0);
        }

        $id = $request->id;
        
        $article = Articles::where('id',$id)->first();

        $article->UserName = $article->UserName;

        if(!$article)
        {
            return $this->makeError(array(), array('error' => 'Article not found!'), 0);
        }

        return Response::json($this->makeResponse(array('article' => $article), array('message' => "Article fetched successfully."), 1));
    }

    /**  
     * @OA\Post(  
     *   tags={"Articles Functions"},
     *   path="/viewArticleForUser",  
     *   description="View article For User.",  
     *   operationId="viewArticleForUser",   
     *   
     *   @OA\RequestBody(  
     *       request="body",
     *       description="Article ID",  
     *       required=true,
     *       @OA\JsonContent(  
     *           @OA\Schema(
     *               ref="#/components/schemas/createUserRequest"
     *           ),
     *           example={"user_id": "1"} 
     *       )
     *   ),  
     *   @OA\Response(  
     *       response=200,  
     *       description="Response",
     *       @OA\JsonContent(
     *           @OA\Schema(
     *               ref="#/components/schemas/apiResponse"
     *           ),
     *           example={"flag":true,"data":"Your data","message":"Message","code":"200"}
     *       ),
     *  ),
     *   @OA\Response(response="403", description="Unauthorized")
     * )  
     */
    public function viewArticleForUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            // return response()->json(array("Error"=>"Email already exists."));
            return $this->makeError(array(), array('error' => $validator->errors()), 0);
        }

        $id = $request->user_id;
        
        $articles = Articles::where('users_id',$id)->get();

        foreach($articles as $article)
        {
            $article->UserName = $article->UserName;
        }

        if(!$articles)
        {
            return $this->makeError(array(), array('error' => 'Articles not found!'), 0);
        }

        return Response::json($this->makeResponse(array('articles' => $articles), array('message' => "Articles fetched successfully."), 1));
    }

    /**  
     * @OA\Post(  
     *   tags={"Articles Functions"},
     *   path="/saveArticle",  
     *   description="Save article.",  
     *   operationId="saveArticle",   
     *   
     *   @OA\RequestBody(  
     *       request="body",
     *       description="Article ID",  
     *       required=true,
     *       @OA\JsonContent(  
     *           @OA\Schema(
     *               ref="#/components/schemas/createUserRequest"
     *           ),
     *           example={"id": "1","title":"Article Title","tags":"new,sample","description":"Article description..."} 
     *       )
     *   ),  
     *   @OA\Response(  
     *       response=200,  
     *       description="Response",
     *       @OA\JsonContent(
     *           @OA\Schema(
     *               ref="#/components/schemas/apiResponse"
     *           ),
     *           example={"flag":true,"data":"Your data","message":"Message","code":"200"}
     *       ),
     *  ),
     *   @OA\Response(response="403", description="Unauthorized"),
     *   security={{"api_key":{}}}
     * )  
     */
    public function saveArticle(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'       =>  'required',
            'title'       =>  'required',
            'tags'   =>  'required',
            'description'   =>  'required'
        ]);

        if ($validator->fails()) {
            // return response()->json(array("Error"=>"Email already exists."));
            return $this->makeError(array(), array('error' => $validator->errors()), 0);
        }

        $id = $request->id;

        $article = Articles::find($id);

        if($article->users_id == Auth('api')->user()->id)
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
            return Response::json($this->makeResponse(array('article' => $article), array('message' => "Article fetched successfully."), 1));
        }
        else
        {
            return $this->makeError(array(), array('error' => 'You are not authorised to edit this article.'), 0);
        }
    }
}
