<?php

namespace App\Http\Repositories;

interface UserRepository
{
    public function isFreeUser($id);
    public function getUserAdress($id);
    public function updateUser($id ,$data);
    public function UserAddressUpdate($id ,$data);
    public function findUserByEmail($email);
    public function findUserByEmailOrPhone($emailorphone);
    public function getAccountParent($id);
    public function getAccountTypeAndName($user_id);
    public function getMyNetwork($user_id);
    public function getMyAddresses($conditions);
    public function getUserFavourites($conditions);
    public function addProductToFavourites($product,$add);
    public function addUserAddress($product,$add);
    public function getMyMainAddresse($conditions);
    public function getMyCashbackLevel($mytotalPaidOrderThisQuarter);
    public function getUserTotalOrders($conditions);
    public function getMySalesLeaderLevel($myTeamMembersActivesCount,$myNewMembersActivesCount,$myTeamTotalSales);
    public function getMyNextSalesLeaderLevel($level_id);
    public function getMyNextCashbackLevel($level_id);
    public function getMyTeamGeneration($user_id,$generation,$new=false);
    public function getMyParents($user_id);
    public function checkINewOrNot($user_id);
    public function deleteUserAddress($conditions);
    public function getAllUsers($inputData);
}
