<?php


namespace App\Services;


use App\Core\Config\Configuration;
use App\Core\Config\DirectoryLoader;
use App\Core\Http\DefaultSession;
use App\Core\Http\Session;
use App\Exceptions\EmailNotVerifiedException;
use App\Exceptions\InvalidPasswordException;
use App\Exceptions\InvalidRouteException;
use App\Models\User;

class LogInService
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
}