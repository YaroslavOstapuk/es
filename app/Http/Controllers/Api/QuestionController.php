<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\StoreImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\QuestionStoreRequest;
use App\Http\Requests\Question\QuestionUpdateRequest;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionSimpleResource;
use App\Models\Group;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    use StoreImages;

    /**
     * @param Group $group
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Group $group)
    {
        $questions = Question::with('media', 'user')->whereGroupId($group->id)->orderByDesc('created_at')->get();

        return QuestionSimpleResource::collection($questions);
    }

    /**
     * @param QuestionStoreRequest $request
     * @param Group $group
     * @return QuestionResource
     */
    public function store(QuestionStoreRequest $request, Group $group)
    {
        $question = Question::create([
            'title' => $request->title,
            'descriptions' => $request->descriptions,
            'status' => Question::EVENT_NEW,
            'group_id' => $group->id,
            'user_id' => auth()->user()->id,
        ]);

        $this->storePhotos($request, $question);

        $question->load('user', 'media');

        return new QuestionResource($question);
    }

    /**
     * @param Request $request
     * @param Question $question
     * @return QuestionResource
     */
    public function changeStatus(Request $request, Question $question)
    {
        $question->update([
            'status' => $request->status,
        ]);

        return new QuestionResource($question);
    }

    /**
     * @param Question $question
     * @return QuestionResource
     */
    public function show(Question $question)
    {
        $question->load('user', 'media');

        return new QuestionResource($question);
    }

    /**
     * @param QuestionUpdateRequest $request
     * @param Question $question
     * @return QuestionResource
     */
    public function update(QuestionUpdateRequest $request, Question $question)
    {
        $question->update([
            'title' => $request->title,
            'descriptions' => $request->descriptions,
        ]);

        $this->storePhotos($request, $question);

        $question->load('user', 'media');

        return new QuestionResource($question);
    }

    /**
     * @param Question $question
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return response()->json([
            'message' => trans('system.delete.success')
        ]);
    }
}
