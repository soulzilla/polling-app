<?php

namespace App\Services;

use App\Models\Answer;
use App\Repositories\AnswerRepository;

class AnswersService
{
    /**
     * @param AnswerRepository $repository
     */
    public function __construct(private readonly AnswerRepository $repository)
    {
    }

    /**
     * @param int $variant_id
     * @return Answer
     */
    public function store(int $variant_id): Answer
    {
        return $this->repository->store($variant_id);
    }

    /**
     * @param Answer $answer
     * @param int $variant_id
     * @return Answer
     */
    public function update(Answer $answer, int $variant_id): Answer
    {
        return $this->repository->update($answer, $variant_id);
    }

    /**
     * @param Answer $answer
     * @return bool|null
     */
    public function delete(Answer $answer): ?bool
    {
        return $this->repository->delete($answer);
    }
}
