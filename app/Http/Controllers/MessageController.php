<!-- <?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Message;
use App\Models\User;
use App\Http\Resources\AuthorMessagesResource;
use App\Http\Resources\MessageDataResource;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Post = Message::orderBy('created_at', 'desc')->get();
        $post_arr = $Post->map(function ($item, $key) {
            return new MessageDataResource($item);
        });
        return response()->json($post_arr, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validResult = $request->validate([
                "message" => "required|string",
                'user_id' => 'required|uuid'
            ]);
            $message = Message::create($request->all());
            return response()->json(['message' => "Successfully create message!"], 201);
        } catch (ValidationException $exception) {
            $errorMessage =
                $exception->validator->getMessageBag()->getMessages();
            return response()->json(['message' => $errorMessage], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return response()->json(new MessageDataResource($message), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMessageRequest  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        $message->update($request->all());
        return response()->json([
            'message' => 'successful update'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return response()->json(null, 204);
    }
    public function getUserMessages(Request $request, User $user)
    {
        return response()->json(new AuthorMessagesResource($user));
    }
} -->
