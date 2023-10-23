<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index(Request $request) {
        try{
            $query = Post::query();
        $perPage =2;
        $page = $request->input('page', 1);
        $search = $request->input('search');

        if($search){
            $query->whereRaw("titre LIKE '%" . $search . "%'");
        }
        $total = $query->count();
        $result = $query->offset(($page - 1) * $page)->limit($perPage)->get();
            return response()->json([
                'status_code'=> 200,
                'status_message' => 'les posts ont ete recupere',
                'current_page' =>$page,
                'last_page' =>ceil($total / $perPage),
                'items'=> $result,
            ]);
        }catch (Exception $e) {
            return response()->json($e);
       }
    }

    public function update(EditPostRequest $request, Post $post){

        try{
            $post->titre = $request->titre;
            $post->description = $request->description;
            if($post->user_id == auth()->user()->id){
                $post->save();
            }else{
                return response()->json([
                    'status_code'=> 422,
                    'status_message' => 'vous n etes pas l auteur de ce post',
                    'data' => $post
                ]);
            }
             

             return response()->json([
                'status_code'=> 200,
                'status_message' => 'le post a ete modifier',
                'data' => $post
            ]);
        }catch (Exception $e) {
            return response()->json($e);
       }
    }

    public function store(CreatePostRequest $request)
    {
       try {
        $post = new Post();
        $post->titre= $request->titre;
        $post->description= $request->description;
        $post->user_id = auth()->user()->id;

        $post->save();

        return response()->json([
            'status_code'=> 200,
            'status_message' => 'le post a ete ajoute',
            
        ]);
       } catch (Exception $e) {
            return response()->json($e);
       }
    }

    public function delete(Post $post){
        try{
            if($post){
                if($post->user_id == auth()->user()->id){
                    $post->delete();
                }else{
                    return response()->json([
                        'status_code'=> 422,
                        'status_message' => 'vous n etes pas l auteur de ce post',
                        
                    ]);
                }
                
            return response()->json([
                'status_code'=> 200,
                'status_message' => 'ce post est supprime',

                'data' => $post
            ]);
            }else{
                return response()->json([
                    'status_code'=> 422,
                    'status_message' => 'enregistrement introuvqable',
                    'data' => $post
                ]);
            }
        }catch (Exception $e) {
            return response()->json($e);
       }
    }
}
