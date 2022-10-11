<?php
namespace App\Actions;

class CreateUserApiToken
{
    public function handle() : string
    {
        $user = auth()->user();
        $token = $user->createToken('token')->plainTextToken;
        $user->api_token = $token;
        $user->save();
        return $token;
    }
}
