<?php


namespace App\Http\Controllers;


use App\Core\Http\Session;
use App\Exceptions\EmailNotVerifiedException;
use App\Exceptions\InvalidPasswordException;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rakit\Validation\Validator;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class AuthController extends Controller
{
    /**
     * @var Request
     */
    private Request $request;
    /**
     * @var UserService
     */
    private UserService $userService;
    /**
     * @var Validator
     */
    private Validator $validator;
    /**
     * @var Session
     */
    private Session $session;

    public function __construct(Request $request, UserService $userService, Validator $validator, Session $session)
    {
        $this->request = $request;
        $this->userService = $userService;
        $this->validator = $validator;
        $this->session = $session;
    }

    public function show()
    {
        if ($this->request->getPathInfo() === '/login' && $this->session->get('isLoggedIn')) {
            return $this->redirect('/');
        }

        return $this->view('auth.twig');
    }


    public function logIn()
    {
        $data = [
            'email' => $this->request->request->get('email'),
            'password' => $this->request->request->get('password')
        ];

        $this->validate($this->validator->validate($data, [
            'email' => 'required|email|max:150',
            'password' => 'required'
        ]));


        try {
            $user = $this->userService->login($data);
            return $this->ok(['user' => $user]);
        } catch (ModelNotFoundException | InvalidPasswordException $e) {
            return $this->unauthorized(['message' => 'Invalid email or password']);
        } catch (EmailNotVerifiedException $e) {
            return $this->badRequest(['message' => 'Email is not verified']);
        } catch (Throwable $e) {
            return $this->serverError(['message' => 'Server error']);
        }
    }


    public function register()
    {
        $data = [
            'name' => $this->request->request->get('name'),
            'surname' => $this->request->request->get('surname'),
            'email' => $this->request->request->get('email'),
            'password' => $this->request->request->get('password'),
        ];


        $this->validate($this->validator->validate($data, [
            'name' => 'required|min:1|max:70',
            'surname' => 'required|min:1|max:70',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|min:8',
        ]));

        try {
            $user = $this->userService->store($data);
            return $this->created(['user' => $user]);
        } catch (Throwable $e) {
            dd($e->getCode());
        }
    }

    public function logout()
    {
        $this->session->remove('user');
        $this->session->remove('isLoggedIn');

        return $this->redirect('/login');
    }
}