<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Group;

class EventController extends Controller
{
    /**
     * @param Group $group
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Group $group)
    {
        $events = Event::whereGroupId($group->id)->orderByDesc('id')->get();

        return EventResource::collection($events);
    }

    /**
     * @param EventStoreRequest $request
     * @param Group $group
     * @return EventResource
     */
    public function store(EventStoreRequest $request, Group $group)
    {
        $event = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_at' => $request->start_at,
            'expire_at' => $request->expire_at,
            'group_id' => $group->id,
        ]);

        return new EventResource($event);
    }

    /**
     * @param Event $event
     * @return EventResource
     */
    public function show(Event $event)
    {
        return new EventResource($event);
    }

    /**
     * @param EventUpdateRequest $request
     * @param Event $event
     * @return EventResource
     */
    public function update(EventUpdateRequest $request, Event $event)
    {
        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_at' => $request->start_at,
            'expire_at' => $request->expire_at
        ]);

        return new EventResource($event);
    }

    /**
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'message' => trans('system.delete.success')
        ]);
    }
}
