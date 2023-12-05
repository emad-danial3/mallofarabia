<?php

namespace App\Http\Services;

use App\Http\Repositories\ReviewsRepository;

class ReviewsService extends BaseServiceController
{
    private $ReviewsRepository;

    public function __construct(ReviewsRepository  $ReviewsRepository)
    {
        $this->ReviewsRepository = $ReviewsRepository;
    }

    public function getAll()
    {
        return $this->ReviewsRepository->getAll(['*'],[],['product','user']);
    }

    public function updateRow($updatedData , $id)
    {
        return  $this->ReviewsRepository->updateData(['id' => $id] ,$updatedData);
    }

    public function createRow($inputData)
    {
        return  $this->ReviewsRepository->create($inputData);
    }
}
