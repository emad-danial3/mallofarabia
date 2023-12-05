<?php

namespace App\Http\Services;

use App\Http\Repositories\GeneralRepository;

class GeneralService extends BaseServiceController
{
    private $GeneralRepository;

    public function __construct(GeneralRepository $GeneralRepository)
    {
        $this->GeneralRepository = $GeneralRepository;
    }

    public function getFAQ()
    {
        return $this->GeneralRepository->getFAQ();
    }

    public function getStaticPages()
    {
        return $this->GeneralRepository->getStaticPages();
    }
    public function getBrochure()
    {
        return $this->GeneralRepository->getBrochure();
    }

    public function sharePagesCategory($base_page)
    {
        return $this->GeneralRepository->sharePagesCategory($base_page);
    }

    public function getSharePages($id)
    {
        return $this->GeneralRepository->sharePages($id);
    }

    public function getBanners()
    {
        return $this->GeneralRepository->getBanners();
    }

    public function getCountries()
    {
        return $this->GeneralRepository->getCountries();
    }
    public function getFirstScreens()
    {
        return $this->GeneralRepository->getFirstScreens();
    }

    public function getCities($id)
    {
        return $this->GeneralRepository->getCities($id);
    }

    public function getAreas($id)
    {
        return $this->GeneralRepository->getAreas($id);
    }

    public function getAccountTypes()
    {
        return $this->GeneralRepository->getAccountTypes();
    }
}
