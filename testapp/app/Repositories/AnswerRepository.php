<?php

namespace App\Repositories;

use App\Models\Answer;

class AnswerRepository
{
    /**
     * @param int $variant_id
     * @return Answer|bool
     */
    public function store(int $variant_id): Answer|bool
    {
        $user_id = auth()->user()->id;

        if (Answer::query()->where([
            'variant_id' => $variant_id,
            'user_id' => $user_id
        ])->exists()) {
            return false;
        }

        $answer = new Answer();
        $answer->user_id = $user_id;
        $answer->variant_id = $variant_id;
        $answer->save();

        return $answer;
    }

    /**
     * @param Answer $answer
     * @param int $variant_id
     * @return bool|Answer
     */
    public function update(Answer $answer, int $variant_id): bool|Answer
    {
        if ($answer->user_id != auth()->user()->id) {
            return false;
        }

        $answer->variant_id = $variant_id;
        $answer->save();

        return $answer;
    }

    /**
     * @param Answer $answer
     * @return bool|null
     */
    public function delete(Answer $answer): ?bool
    {
        if ($answer->user_id != auth()->user()->id) {
            return false;
        }
        return $answer->delete();
    }
}
