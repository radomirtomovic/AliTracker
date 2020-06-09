<?php


namespace App\Services;


use App\Core\Http\Session;
use App\Exceptions\EmailNotVerifiedException;
use App\Exceptions\InvalidPasswordException;
use App\Models\User;
use Carbon\Carbon;

class UserService
{
    /**
     * @var PasswordHash
     */
    private PasswordHash $passwordHash;
    /**
     * @var Session
     */
    private Session $session;

    public function __construct(PasswordHash $passwordHash, Session $session)
    {
        $this->passwordHash = $passwordHash;
        $this->session = $session;
    }

    public function login(array $data)
    {
        $user = User::query()
            ->where('email', '=', $data['email'])
            ->firstOrFail();
        if (!$this->passwordHash->verify($data['password'], $user->password)) {
            throw new InvalidPasswordException();
        }

        if ($user->email_verified_at === null) {
            throw new EmailNotVerifiedException();
        }
        $this->session->regenerate();
        $this->session->set('isLoggedIn', true);
        $this->session->set('user', $user);

        return $user;
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

    public function update()
    {}

    public function delete()
    {}
}