<?php

namespace app\models;

final class User
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $email;
    /**
     * @var int
     */
    public $is_admin;
}
