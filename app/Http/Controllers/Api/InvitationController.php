<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invitation\InvitationRequest;
use App\Models\Chat;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    /**
     * @param InvitationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function invitation(InvitationRequest $request)
    {
        $user = User::whereEmail($request->email)->first();
        $chat = Chat::findOrFail($request->chat_id);

        if ($user) {
            $user->chats()->attach($chat);

            return response()->json([
                'status' => 'ok'
            ]);
        }

        Invitation::create([
            'email' => $request->email,
            'chat_id' => $request->chat_id,
        ]);

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
