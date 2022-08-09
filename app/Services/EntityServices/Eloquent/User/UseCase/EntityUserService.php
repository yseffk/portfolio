<?php

namespace App\Services\EntityServices\Eloquent\User\UseCase;

class EntityUserService extends EntityUserAbstractService
{
   public function profile(): EntityUserProfileService
   {
       return $this
           ->abstract()
           ->entity()
           ->profile();
   }

   public function address(): EntityUserAddressService
   {
       return $this
           ->abstract()
           ->entity()
           ->address();
   }

}
