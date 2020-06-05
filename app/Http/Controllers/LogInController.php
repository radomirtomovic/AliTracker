<?php


namespace App\Http\Controllers;


use App\Exceptions\EmailNotVerifiedException;
use App\Exceptions\InvalidPasswordException;
use App\Services\LogInService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rakit\Validation\Validator;
use Symfony\Component\HttpFoundation\Request;

class LogInController extends Controller
{
    /**
     * @var LogInService
     */
    private LogInService $logInService;
    /**
     * @var Request
     */
    private Request $request;
    /**
     * @var Validator
     */
    private Validator $validator;

    public function __construct(Request $request, LogInService $logInService, Validator $validator)
    {
        $this->logInService = $logInService;
        $this->request = $request;
        $this->validator = $validator;
    }

    public function show()
    {
        return $this->view('login.twig');
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
            $user = $this->logInService->login($data);
            return $this->ok(['user' => $user]);
        } catch (ModelNotFoundException | InvalidPasswordException $e) {
            return $this->unauthorized(['message' => 'Invalid email or password']);
        } catch (EmailNotVerifiedException $e) {
            return $this->badRequest(['message' => 'Email is not verified']);
        } catch (\Throwable $e) {
            return $this->serverError(['message' => 'Server error']);
        }
    }
}