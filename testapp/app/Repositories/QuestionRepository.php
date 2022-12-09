<?php

namespace App\Repositories;

use App\Models\Question;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class QuestionRepository
{
    /**
     * @param array $data
     * @return Question
     */
    public function store(array $data): Question
    {
        $question = new Question();
        $question->fill($data);
        if (!$question->save()) {
            throw new UnprocessableEntityHttpException();
        }

        return $question;
    }

    /**
     * @param Question $question
     * @param array $data
     * @return Question
     */
    public function update(Question $question, array $data): Question
    {
        $question->fill($data);
        if (!$question->save()) {
            throw new UnprocessableEntityHttpException();
        }

        return $question;
    }

    /**
     * @param Question $question
     * @return bool|null
     */
    public function delete(Question $question): ?bool
    {
        return $question->delete();
    }
}
