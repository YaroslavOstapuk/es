<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\StoreImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Group\GroupStoreRequest;
use App\Http\Requests\Group\GroupSubscribeRequest;
use App\Http\Requests\Group\GroupUpdateRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\UserResource;
use App\Models\Chat;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    use StoreImages;
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $user = auth()->user();

        return GroupResource::collection($user->groups);
    }

    /**
     * @param GroupStoreRequest $request
     * @return GroupResource
     */
    public function store(GroupStoreRequest $request)
    {
        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => Group::GROUP_ACTIVE
        ]);

        $group->setSlug($request);

        $group->users()->attach(auth()->user()->id, ['role_id' => User::ROLE_AUTHOR]);

        $this->storeMainPhoto($request, $group);

        $primaryChat = Chat::create([
            'name' => 'Загальний чат',
            'description' => 'Чат для всіх учасників цієї групи',
            'group_id' => $group->id,
            'type' => 'primary',
        ]);

        return new GroupResource($group);
    }

    /**
     * @param Group $group
     * @return GroupResource
     */
    public function show(Group $group)
    {
        return new GroupResource($group);
    }

    /**
     * @param Group $group
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function users(Group $group)
    {
        return UserResource::collection($group->users);
    }

    /**
     * @param Request $request
     * @param Group $group
     * @return GroupResource
     */
    public function update(GroupUpdateRequest $request, Group $group)
    {
        $group->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $this->storeMainPhoto($request, $group);

        return new GroupResource($group);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|void
     */
    public function searchGroup(Request $request)
    {
        $query = $request->q;

        if (!$query || strlen($query) < 2) {
            return;
        }

        $groups = Group::where('name', 'LIKE', '%' . $query . '%')->get();

        return GroupResource::collection($groups);
    }

    /**
     * @param GroupSubscribeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(GroupSubscribeRequest $request)
    {
        $group = Group::with('users')->findOrFail($request->group_id);

        if (!$group->hasUser(Auth::user())) {
            $group->users()->attach(Auth::user());

            return response()->json([
                'status' => 'ok'
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unSubscribe(Request $request)
    {
        $group = Group::with('users')->where('slug', $request->slug)->firstOrFail();

        if ($group->hasUser(Auth::user())) {
            $group->users()->detach(Auth::user());

            return response()->json([
                'status' => 'ok'
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }

    /**
     * @param Group $group
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return response()->json([
            'message' => trans('system.delete.success')
        ]);
    }
}
