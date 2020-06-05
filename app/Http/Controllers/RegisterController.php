<?php


namespace App\Http\Controllers;

use App\Services\RegisterService;
use Rakit\Validation\Validator;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{
    /**
     * @var RegisterService
     */
    private RegisterService $registerService;
    /**
     * @var Request
     */
    private Request $request;
    /**
     * @var Validator
     */
    private Validator $validator;

    public function __construct(Request $request, RegisterService $registerService, Validator $validator)
    {
        $this->registerService = $registerService;
        $this->request = $request;
        $this->validator = $validator;
    }

    public function show()
    {
        return $this->view('register.twig');
    }


    public function register()
    {
        $data = [
            'name' => $this->request->request->get('name'),
            'surname' => $this->request->request->get('surname'),
            'email' => $this->request->request->get('email'),
            'password' => $this->request->request->get('password'),
        ];


        $validation = $this->validator->validate($data, [
            'name' => 'required|min:1|max:70',
            'surname' => 'required|min:1|max:70',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validation->fails()) {
            return $this->unprocessableEntity($validation->errors()->firstOfAll());
        }

        $user = $this->registerService->store($data);

        return $this->created(['user' => $user]);
    }
}