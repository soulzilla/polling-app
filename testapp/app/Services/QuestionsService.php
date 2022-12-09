<?php

namespace App\Services;

use App\Models\Question;
use App\Repositories\QuestionRepository;

class QuestionsService
{
    /**
     * @param QuestionRepository $repository
     */
    public function __construct(private readonly QuestionRepository $repository)
    {
    }

    /**
     * @param array $data
     * @return Question
     */
    public function store(array $data): Question
    {
        return $this->repository->store($data);
    }

    /**
     * @param Question $question
     * @param array $data
     * @return Question
     */
    public function update(Question $question, array $data): Question
    {
        return $this->repository->update($question, $data);
    }

    /**
     * @param Question $question
     * @return bool|null
     */
    public function delete(Question $question): ?bool
    {
        return $this->repository->delete($question);
    }
}
