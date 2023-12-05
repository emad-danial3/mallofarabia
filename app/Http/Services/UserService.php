<?php

namespace App\Http\Services;

use App\Http\Repositories\ForgotPasswordRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\IUserRepository;
use App\Http\Repositories\UserRepository;
use App\Libraries\MediaController;
use App\Libraries\UploadImagesController;
use App\Mail\RegistrationEmail;
use App\Mail\RestPassword;
use App\SendMessage\SendMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService extends BaseServiceController
{
    private $UserRepository;
    private $OrderRepository;
    private $ForgotPasswordRepository;
    private $MediaController;

    public function __construct(UserRepository $userRepository, OrderRepository $OrderRepository, ForgotPasswordRepository $ForgotPasswordRepository, UploadImagesController $MediaController)
    {
        $this->UserRepository           = $userRepository;
        $this->OrderRepository          = $OrderRepository;
        $this->ForgotPasswordRepository = $ForgotPasswordRepository;
        $this->MediaController          = $MediaController;
    }

    public function isFreeUser($user_id)
    {
        return $this->UserRepository->isFreeUser($user_id);
    }

    public function getUserAddress($conditions)
    {
        return $this->UserRepository->getMyAddresses($conditions);
    }
    public function getUserFavourites($conditions)
    {
        return $this->UserRepository->getUserFavourites($conditions);
    }
    public function addProductToFavourites($product,$add)
    {
        return $this->UserRepository->addProductToFavourites($product,$add);
    }
    public function addUserAddress($product,$add)
    {
        return $this->UserRepository->addUserAddress($product,$add);
    }

    public function UserAddressUpdate($id, $data)
    {
        return $this->UserRepository->UserAddressUpdate($id, $data);
    }

    public function getMyMainAddresse($conditions)
    {
        return $this->UserRepository->getMyMainAddresse($conditions);
    }

    public function getMyCashbackLevel($mytotalPaidOrderThisQuarter)
    {
        return $this->UserRepository->getMyCashbackLevel($mytotalPaidOrderThisQuarter);
    }

    public function getUserTotalOrders($conditions)
    {
        return $this->UserRepository->getUserTotalOrders($conditions);
    }

    public function getMyOrders($user_id)
    {
        return $this->OrderRepository->getMyOrder($user_id);
    }

    public function userIsActiveInCurrentMonth($user_id)
    {
        return $this->OrderRepository->userIsActiveInCurrentMonth($user_id);
    }

    public function checkUserDeserveGift($user_id, $created_at)
    {
        return $this->OrderRepository->checkUserDeserveGift($user_id, $created_at);
    }

    public function getMyTeamTotalSales($team, $period = 'month')
    {
        return $this->OrderRepository->getMyTeamTotalSales($team,$period);
    }

    public function userHasReceivedGift($id)
    {
        return $this->OrderRepository->userHasReceivedGift($id);
    }

    public function getUsersActiveSalesTeam($team)
    {
        return $this->OrderRepository->getUsersActiveSalesTeam($team);
    }

    public function getUsersNotActiveSalesTeam($team)
    {
        return $this->OrderRepository->getUsersNotActiveSalesTeam($team);
    }

    public function getMySalesLeaderLevel($myTeamMembersActivesCount, $myNewMembersActivesCount, $myTeamTotalSales)
    {
        return $this->UserRepository->getMySalesLeaderLevel($myTeamMembersActivesCount, $myNewMembersActivesCount, $myTeamTotalSales);
    }

    public function getMyNextSalesLeaderLevel($level_id)
    {
        return $this->UserRepository->getMyNextSalesLeaderLevel($level_id);
    }

    public function getMyNextCashbackLevel($level_id)
    {
        return $this->UserRepository->getMyNextCashbackLevel($level_id);
    }

    public function getMyTeamGeneration($user_id, $generation, $new = false)
    {
        return $this->UserRepository->getMyTeamGeneration($user_id, $generation, $new);
    }

    public function getMyParents($user_id)
    {
        return $this->UserRepository->getMyParents($user_id);
    }
    public function checkINewOrNot($user_id)
    {
        return $this->UserRepository->checkINewOrNot($user_id);
    }

    public function deleteUserAddress($conditions)
    {
        return $this->UserRepository->deleteUserAddress($conditions);
    }

    public function getAddressInfo($inputData): array
    {
        return [
            "address"          => $inputData['address'],
            "city"             => $inputData['city'],
            "area"             => $inputData['area'],
            "building_number"  => $inputData['building_number'],
            "floor_number"     => $inputData['floor_number'],
            "apartment_number" => $inputData['apartment_number'],
            "landmark"         => $inputData['landmark'],
        ];
    }

    public function userHasDiscount($created_for_user_id)
    {
//        $is_free=$this->isFreeUser($created_for_user_id);
//        if ($is_free)
//            return 0;

        //   return $this->OrderRepository->isFirstOrder($created_for_user_id);

        $user = $this->UserRepository->find($created_for_user_id, ['stage']);

        if (!empty($user) && $user->stage == 3)
            return 1;


        return 0;
    }

    public function updateUser($created_for_user_id)
    {
        $data = ['stage' => 2];
        return $this->UserRepository->updateUser($created_for_user_id, $data);
    }

    public function resetPassword($emailorphone)
    {
        $userRow = $this->UserRepository->findUserByEmailOrPhone($emailorphone);
        if (!empty($userRow) && $userRow->stage >= 1) {
            $user_id        = $userRow->id;
            $activationCode = substr(str_shuffle("0123456789"), 0, 4);
            $expiry_date    = Carbon::now()->addMinutes(30);
            $data           = [
                'subject'     => 'Rest Password',
                'code'        => $activationCode,
                'expiry_date' => $expiry_date,
                'user_id'     => $user_id
            ];
            $this->ForgotPasswordRepository->createRestPassword($data);
            $maill = Mail::to($userRow['email'])->send(new RestPassword($data));
            //   dd($maill);
            // send Email
            // Mail::to($email)->send(new RestPassword($data));
            return $userRow;
        }
        return 0;
    }

    public function setNewPasswor($emailorphone,$newPassword): int
    {
        $userRow = $this->UserRepository->findUserByEmailOrPhone($emailorphone);
        if (!empty($userRow) && $userRow->stage >= 1) {
            $password =  Hash::make($newPassword);
            $userRow->update(['password' => $password,'initial_password' => $newPassword]);
            return 1;
        }
        return 0;
    }

    public function checkValidateCode($emailorphone,$code): int
    {
        $userRow = $this->UserRepository->findUserByEmailOrPhone($emailorphone);
        if (!empty($userRow) && $userRow->stage >= 1) {
            $user_id        = $userRow->id;
            $current_date    = Carbon::now();
            $data=[
              'now'=>$current_date,
              'code'=>$code,
              'user_id'=>$user_id
            ];
          $valid= $this->ForgotPasswordRepository->checkValidateCode($data);
          if(!empty($valid)){
              return  1;
          }
          return 0;
        }
        return 0;
    }

    public function updateUserProfile($userData, $user_id)
    {
        return $this->UserRepository->updateUser($user_id, $userData);
    }

    public function getMyNetwork($user_id)
    {
        return $this->UserRepository->getMyNetwork($user_id);
    }

    public function myCommission($user_id, $filterData)
    {
        return $this->UserRepository->getMyCommission($user_id, $filterData);
    }

    public function createUser($userData)
    {
        $userData['initial_password'] = $userData['password'];
        $userData['password']         = Hash::make($userData['password']);
//        $userData['account_id']       = $this->createAccountId($userData['nationality_id']);
        $userData['account_id'] = rand(1000000000, 9999999999);
        return $this->UserRepository->create($userData);
    }

    private function createPassword()
    {
        return substr(str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890'), 0, 6);
    }

    private function createAccountId($nationality_id)
    {
        return '100' . substr($nationality_id, -7);
    }

    public function sendRegistrationEmail($userData)
    {
        try {
            //send Email
            $emailData = [
                "subject"   => "Congratulation Mail",
                "email"     => $userData['email'],
                "password"  => $userData['initial_password'],
                "full_name" => $userData['full_name'],
            ];
            // send Email
            Mail::to($userData['email'])->send(new RegistrationEmail($emailData));
        }
        catch (Exception $e) {

        }
    }

    public function sendRegistrationMessage($userData)
    {
        try {
            $messageText = 'Hello ' . $userData['full_name'] . ', \n User Name:' . $userData['email'] . ' \n Password:\n  ' . $userData['initial_password'] . ' \n Download the Application from Google play or APP store';
            $messageText = str_replace(' ', '%20', $messageText);
            SendMessage::sendMessage($userData['phone'], $messageText);
        }
        catch (Exception $e) {

        }
    }



    public function getAllUsers($inputData)
    {
        return $this->UserRepository->getAllUsers($inputData);
    }

    public function updateUserRow($updatedData, $id)
    {
        if (isset($updatedData['front_id_image'])) {
            $updatedData['front_id_image'] = $this->MediaController->UploadImage($updatedData['front_id_image'], 'images');
        }
        if (isset($updatedData['password'])) {
            $updatedData['initial_password'] = $updatedData['password'];
            $updatedData['password']         = Hash::make($updatedData['password']);
        }
        if (isset($updatedData['back_id_image'])) {
            $updatedData['back_id_image'] = $this->MediaController->UploadImage($updatedData['back_id_image'], 'images');
        }
        return $this->UserRepository->updateUser($id, $updatedData);

    }

    public function getAllUsersWithOutPagination()
    {
        return $this->UserRepository->getAll(['id', 'full_name', 'initial_password', 'front_id_image', 'back_id_image', 'account_id', 'nationality_id', 'email', 'phone','created_at']);
    }

    public function getUser($id)
    {
        return $this->UserRepository->find($id, ['*'], ['notificationUnReadCount']);
    }

    public function findCustomDataIds($ids, $column)
    {
        return $this->UserRepository->findCustomDataByIds($ids, $column);
    }

}
