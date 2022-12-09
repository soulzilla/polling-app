<?php

namespace App\Repositories;

use App\Models\Survey;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class SurveyRepository
{
    /**
     * @param int $id
     * @return Survey
     */
    public function getById(int $id): Survey
    {
        /** @var Survey $survey */
        $survey = Survey::query()->with(['questions.variants'])->find($id);
        if (!$survey) {
            throw new NotFoundHttpException();
        }

        return $survey;
    }

    /**
     * @param array $data
     * @return Survey
     */
    public function store(array $data): Survey
    {
        $survey = new Survey();
        $survey->fill($data);
        if (!$survey->save()) {
            throw new UnprocessableEntityHttpException();
        }

        return $survey;
    }

    /**
     * @param Survey $survey
     * @param array $data
     * @return Survey
     */
    public function update(Survey $survey, array $data): Survey
    {
        $survey->fill($data);
        if (!$survey->save()) {
            throw new UnprocessableEntityHttpException();
        }

        return $survey;
    }

    /**
     * @param Survey $survey
     * @return bool|null
     */
    public function delete(Survey $survey): ?bool
    {
        return $survey->delete();
    }
}
