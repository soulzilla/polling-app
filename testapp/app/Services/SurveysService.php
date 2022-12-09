<?php

namespace App\Services;

use App\Models\Survey;
use App\Repositories\SurveyRepository;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\SimpleCache\InvalidArgumentException;

class SurveysService
{
    /**
     * @param SurveyRepository $repository
     */
    public function __construct(private readonly SurveyRepository $repository)
    {
    }

    /**
     * @param int $id
     * @return Survey
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    public function getById(int $id): Survey
    {
        if (!cache()->has('survey-' . $id)) {
            cache()->set('survey-' . $id, $this->repository->getById($id));
        }

        return cache()->get('survey-' . $id);
    }

    /**
     * @param array $data
     * @return Survey
     */
    public function store(array $data): Survey
    {
        return $this->repository->store($data);
    }

    /**
     * @param Survey $survey
     * @param array $data
     * @return Survey
     */
    public function update(Survey $survey, array $data): Survey
    {
        return $this->repository->update($survey, $data);
    }

    /**
     * @param Survey $survey
     * @return bool|null
     */
    public function delete(Survey $survey): ?bool
    {
        return $this->repository->delete($survey);
    }
}
