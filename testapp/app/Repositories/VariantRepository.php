<?php

namespace App\Repositories;

use App\Models\Variant;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class VariantRepository
{
    /**
     * @param array $data
     * @return Variant
     */
    public function store(array $data): Variant
    {
        $variant = new Variant();
        $variant->fill($data);
        if (!$variant->save()) {
            throw new UnprocessableEntityHttpException();
        }

        return $variant;
    }

    /**
     * @param Variant $variant
     * @param array $data
     * @return Variant
     */
    public function update(Variant $variant, array $data): Variant
    {
        $variant->fill($data);
        if (!$variant->save()) {
            throw new UnprocessableEntityHttpException();
        }

        return $variant;
    }

    /**
     * @param Variant $variant
     * @return bool|null
     */
    public function delete(Variant $variant): ?bool
    {
        return $variant->delete();
    }
}
