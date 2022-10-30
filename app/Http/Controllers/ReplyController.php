<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\UpdateReplyRequest;
use App\Http\Resources\CommentRepliesResource;
use Illuminate\Validation\ValidationException;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function store(Request $request)
    {
        // return $request;
        try {
            $validResult = $request->validate([
                "message" => "required|string",
                'comment_id' => 'required|uuid',
                'user_id' => 'required|uuid'
            ]);
            $comment = Reply::create($request->all());
            return response()->json(['success' => true, 'message' => "Successfully reply message!"], 201);
        } catch (ValidationException $exception) {
            $errorReply =
                $exception->validator->getMessageBag()->getMessages();
            return response()->json(['message' => $errorReply], 400);
        }
    }

    public function show(Request $request, Comment $comment)
    {
        // return $comment;
        return response()->json(new CommentRepliesResource($comment), 200);
    }

    public function update(Request $request, Reply $reply)
    {
        $reply->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Successfully update.'
        ], 200);
    }

    public function destroy(Reply $reply)
    {
        $reply->delete();
        return response()->json([
            'success' => true,
            'message' => 'Successfully delete.'
        ], 200);
    }
}
