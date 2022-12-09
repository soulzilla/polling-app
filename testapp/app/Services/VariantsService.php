<?php

namespace App\Services;

use App\Models\Variant;
use App\Repositories\VariantRepository;

class VariantsService
{
    public function __construct(private readonly VariantRepository $repository)
    {
    }

    /**
     * @param array $data
     * @return Variant
     */
    public function store(array $data): Variant
    {
        return $this->repository->store($data);
    }

    /**
     * @param Variant $variant
     * @param array $data
     * @return Variant
     */
    public function update(Variant $variant, array $data): Variant
    {
        return $this->repository->update($variant, $data);
    }

    /**
     * @param Variant $variant
     * @return bool|null
     */
    public function delete(Variant $variant): ?bool
    {
        return $this->repository->delete($variant);
    }
}
