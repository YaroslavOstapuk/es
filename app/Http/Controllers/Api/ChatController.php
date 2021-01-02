<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\ChatStoreRequest;
use App\Http\Requests\Chat\ChatUpdateRequest;
use App\Http\Resources\ChatResource;
use App\Models\Chat;
use App\Models\Group;

class ChatController extends Controller
{
    /**
     * @param Group $group
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Group $group)
    {
        $chats = Chat::whereGroupId($group->id)->whereType('other')->get();

        return ChatResource::collection($chats);
    }

    /**
     * @param Group $group
     * @return ChatResource
     */
    public function getPrimaryChat(Group $group)
    {
        $chat = Chat::whereGroupId($group->id)->whereType('primary')->first();

        return new ChatResource($chat);
    }

    /**
     * @param ChatStoreRequest $request
     * @param Group $group
     * @return ChatResource
     */
    public function store(ChatStoreRequest $request, Group $group)
    {
        $chat = Chat::create([
            'name' => $request->name,
            'description' => $request->description,
            'group_id' => $group->id,
        ]);

        return new ChatResource($chat);
    }

    /**
     * @param Chat $chat
     * @return ChatResource
     */
    public function show(Chat $chat)
    {
        return new ChatResource($chat);
    }

    /**
     * @param ChatUpdateRequest $request
     * @param Chat $chat
     * @return ChatResource
     */
    public function update(ChatUpdateRequest $request, Chat $chat)
    {
        $chat->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return new ChatResource($chat);
    }

    /**
     * @param Chat $chat
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Chat $chat)
    {
        $chat->delete();

        return response()->json([
            'message' => trans('system.delete.success')
        ]);
    }
}
