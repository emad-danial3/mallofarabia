<?php

namespace App\Http\Repositories;

interface GeneralRepository
{
    public function getFAQ();
    public function getStaticPages();
    public function getBrochure();
    public function sharePagesCategory($base_page);
    public function sharePages($id);
    public function getBanners();
    public function getCountries();
    public function getFirstScreens();
    public function getCities($id);
    public function getAreas($id);
    public function getAccountTypes();
}
