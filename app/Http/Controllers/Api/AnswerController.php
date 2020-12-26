<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\StoreImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Answer\AnswerStoreRequest;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    use StoreImages;

    /**
     * @param Question $question
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Question $question)
    {
        $answers = Answer::with('user', 'media')
            ->whereQuestionId($question->id)
            ->orderByDesc('created_at')
            ->get();

        return AnswerResource::collection($answers);
    }

    /**
     * @param AnswerStoreRequest $request
     * @param Question $question
     * @return AnswerResource
     */
    public function store(AnswerStoreRequest $request, Question $question)
    {
        $answer = Answer::create([
            'message' => $request->message,
            'user_id' => auth()->user()->id,
            'question_id' => $question->id,
        ]);

        $this->storePhotos($request, $answer);

        $answer->load('user', 'media');

        return new AnswerResource($answer);
    }

    /**
     * @param Answer $answer
     * @return AnswerResource
     */
    public function show(Answer $answer)
    {
        $answer->load('user', 'media');

        return new AnswerResource($answer);
    }

    /**
     * @param Request $request
     * @param Answer $answer
     * @return AnswerResource
     */
    public function update(Request $request, Answer $answer)
    {
        $answer->update([
            'message' => $request->message,
        ]);

        $this->storePhotos($request, $answer);

        $answer->load('user', 'media');

        return new AnswerResource($answer);
    }

    /**
     * @param Answer $answer
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();

        return response()->json([
            'message' => trans('system.delete.success')
        ]);
    }
}
