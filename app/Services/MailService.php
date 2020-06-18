<?php


namespace App\Services;
use Swift_Message;

class MailService
{
    private $email;
    public function __construct(Swift_Message $email)
    {
        $this->email=$email;
    }
    public function verification(){
        $from = require_once __DIR__ .  "../../.env";
        $this->email->setSubject("Verification");
        $this->email->addFrom("");

    }
}













