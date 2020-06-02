<?php


namespace App\Http\Controllers;


class RegisterController extends Controller
{
    function show(){
        return $this->view('register.twig');
    }
}