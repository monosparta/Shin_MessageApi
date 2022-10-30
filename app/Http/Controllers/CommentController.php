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
        try {
            $comment = Comment::orderBy('created_at', 'desc')->get();
            $comment_arr = $comment->map(function ($item, $key) {
                return new CommentDataResource($item);
            });
            return response()->json($comment_arr, 200);
        } catch (ValidationException $exception) {
            $error_comment =
                $exception->validator->getMessageBag()->getMessages();
            return response()->json(
                [
                    'success' => false,
                    'message' => $error_comment
                ],
                500
            );
        }
    }


    public function store(Request $request)
    {
        try {
            $validResult = $request->validate([
                "message" => "required|string",
                'user_id' => 'required|uuid'
            ]);
            $comment = Comment::create($request->all());
            return response()->json(['success' => true, 'message' => "Successfully create message!"], 201);
        } catch (ValidationException $exception) {
            $error_comment =
                $exception->validator->getMessageBag()->getMessages();
            return response()->json(
                [
                    'success' => false,
                    'message' => $error_comment
                ],
                500
            );
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
            'success' => true,
            'message' => 'Successfully update.'
        ], 200);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'success' => true,
            'message' => 'Successfully delete.'
        ], 200);
    }
    public function getUserComments(Request $request, User $user)
    {
        return response()->json(new AuthorCommentsResource($user));
    }
}
