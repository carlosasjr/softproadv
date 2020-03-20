<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function getProfiles($id);
    public function getProfilesNotIn($user);
    public function deleteAddress($id);
    public function deleteContact($id);
}
