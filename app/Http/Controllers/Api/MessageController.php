<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\StoreImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Message\MessageStoreRequest;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use StoreImages;

    /**
     * @param Chat $chat
     * @return MessageResource
     */
    public function index(Chat $chat)
    {
        $messages = Message::with('sender', 'media')
            ->whereChatId($chat->id)
            ->get();

        return MessageResource::collection($messages);
    }

    /**
     * @param MessageStoreRequest $request
     * @param Chat $chat
     * @return MessageResource
     */
    public function store(MessageStoreRequest $request, Chat $chat)
    {
        $message = Message::create([
            'message' => $request->message,
            'chat_id' => $chat->id,
            'sender_id' => auth()->user()->id,
        ]);

        $this->storePhotos($request, $message);

        $message->load('sender', 'media');

        return new MessageResource($message);
    }

    /**
     * @param Request $request
     * @param Message $message
     * @return MessageResource
     */
    public function update(Request $request, Message $message)
    {
        $message->update([
            'message' => $request->message,
        ]);

        $this->storePhotos($request, $message);

        $message->load('sender', 'media');

        return new MessageResource($message);
    }

    /**
     * @param Message $message
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return response()->json([
            'message' => trans('system.delete.success')
        ]);
    }
}
