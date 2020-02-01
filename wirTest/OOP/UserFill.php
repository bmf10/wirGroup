<?php

class UserFill
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function Fill()
    {
        $word = "Hi, I'm {$this->user->getName()}";
        $word .= ", I'm Live in {$this->user->getAddress()}";
        $word .= ", My Phone Number {$this->user->getPhone()}";

        echo $word;
    }
}
