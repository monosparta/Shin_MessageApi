<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Http\Resources\AuthorCommentsResource;
use App\Http\Resources\CommentDataResource;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Post = Comment::orderBy('created_at', 'desc')->get();
        $post_arr = $Post->map(function ($item, $key) {
            return new CommentDataResource($item);
        });
        return response()->json($post_arr, 200);
    }


    public function store(Request $request)
    {
        try {
            $validResult = $request->validate([
                "message" => "required|string",
                'user_id' => 'required|uuid'
            ]);
            $comment = Comment::create($request->all());
            return response()->json(['message' => "Successfully create message!"], 201);
        } catch (ValidationException $exception) {
            $errorComment =
                $exception->validator->getMessageBag()->getMessages();
            return response()->json(['message' => $errorComment], 400);
        }
    }
    public function show(Comment $comment)
    {
        return response()->json(new CommentDataResource($comment), 200);
    }

    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->all());
        return response()->json([
            'message' => 'successful update'
        ], 200);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(null, 204);
    }
    public function getUserComments(Request $request, User $user)
    {
        return response()->json(new AuthorCommentsResource($user));
    }
}
