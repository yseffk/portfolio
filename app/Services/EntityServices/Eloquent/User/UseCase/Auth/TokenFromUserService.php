<?php

namespace App\Services\EntityServices\Eloquent\User\UseCase\Auth;

use App\Models\User;
use App\Services\EntityServices\Eloquent\EntityActionServiceInterface;
use App\Services\EntityServices\Eloquent\EntityServiceInterface;
use App\Services\EntityServices\Eloquent\User\UseCase\EntityUserAbstractService;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

/**
 *
 */
class TokenFromUserService extends EntityUserAbstractService
    implements
    EntityServiceInterface,
    EntityActionServiceInterface
{

    /**
     * @param array $arguments
     * @return array
     */
    public function execute(array $arguments): array
    {
        $token = false;
        $social = $arguments['social'];
        $redirectUrl = route('auth.login-social-callback',['social' => $social]);
        $request = Socialite::driver($social)->redirectUrl($redirectUrl)->stateless();
        /** @var User $user */
        if(isset($arguments['token'])){
            $response = $request->userFromToken($arguments['token']);
        }else{
            $response = $request->user();
        }
        if(isset($response->id)){
            $user = $this->userRepository->findByEmail($response->email);
            if(!$user){
                $nameRes = explode(' ', $response->name);
                $data = [
                    'first_name' => $nameRes[0],
                    'last_name' => (isset($nameRes[1])) ?? '',
                    'email' => $response->email,
                    'password' => Str::random(6),
                    'phone' => '',
                ];

                $user = $this->abstract()
                    ->action()
                    ->register($data);
            }
            $user->social()
                ->updateOrCreate(['user_id' => $user->id, 'type' => $social,],
                    [
                        'sub_id' => $response->id,
                        'token' => $response->token,
                        'refresh_token' => $response->refreshToken,
                    ]
                );

            $token =  $this->getTokenFromUser($user);

        }

        if (!$token) {
            $this->exception('Authentication error', 'user::auth.failed', 401);
        }
        return $this->tokenResponse($token);


    }
}
