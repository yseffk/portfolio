<?php

namespace App\Services\EntityServices\Eloquent\User\UseCase\Auth;

use App\Models\User;
use App\Services\EntityServices\Eloquent\EntityActionServiceInterface;
use App\Services\EntityServices\Eloquent\EntityServiceInterface;
use App\Services\EntityServices\Eloquent\User\Dto\UserDto;
use App\Services\EntityServices\Eloquent\User\Dto\UserRegisterDto;
use App\Services\EntityServices\Eloquent\User\UseCase\EntityUserAbstractService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 *
 */
class RegisterService extends EntityUserAbstractService
    implements
    EntityServiceInterface,
    EntityActionServiceInterface
{

    /**
     * @param array $arguments
     * @return mixed
     */
    public function execute(array $arguments)
    {
        return DB::transaction(function () use ($arguments) {
            /**
             * @var UserRegisterDto $dto
             * @var User $user
             */
            $dto = new $this->dto($arguments);
            if(empty($dto->password)){
                $dto->password = Str::random(6);
            }
            $dto->password = Hash::make($dto->password);

            $userArguments = [
                'name' => $dto->email,
                'email' => $dto->email,
                'password' => $dto->password,
            ];
            $user = $this
                ->abstract()
                ->entity()
                ->user()
                ->create($userArguments);

//            $userProfileArguments = [
//                'user_id' => $user->id,
//                'first_name' => $dto->first_name,
//                'last_name' => $dto->last_name,
//                'phone' => $dto->phone
//            ];
//
//            $this->abstract()
//                ->entity()
//                ->user()
//                ->profile()
//                ->create($userProfileArguments);

            $this->abstract()
                ->entity()
                ->role()
                ->setForUser($user->id, 'admin');

//            $user->load('profile');

            $token = $this->getTokenFromUser($user);
            $res = $this->tokenResponse($token);
            $res['user'] = $user;

            return $res;
        });
    }
}
