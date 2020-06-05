<?php


namespace App\Services;


use App\Core\Http\Session;
use App\Models\User;
use Carbon\Carbon;

class RegisterService
{
    /**
     * @var PasswordHash
     */
    private PasswordHash $passwordHash;

    public function __construct(PasswordHash $passwordHash)
    {
        $this->passwordHash = $passwordHash;
    }

    public function store(array $data)
    {
        $user = new User([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => $this->passwordHash->hash($data['password']),
            'email_verified_at' => Carbon::now(),
        ]);
        
        $user->saveOrFail();

        return $user;
    }
}