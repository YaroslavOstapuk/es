<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\StoreImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UpdateRequest;
use App\Http\Resources\AccountResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use StoreImages;
    /**
     * @return AccountResource
     */
    public function me()
    {
        return new AccountResource(Auth::user());
    }

    /**
     * @param UpdateRequest $request
     * @return AccountResource
     */
    public function updateUserData(UpdateRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only(['email', 'name', 'surname']));

        if (!empty($request->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $this->storeNewPhoto($request, $user);

        return new AccountResource($user);
    }
}
