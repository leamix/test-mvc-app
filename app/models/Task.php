<?php

namespace app\models;

final class Task
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
     * @var string
     */
    public $text;
    /**
     * @var string
     */
    public $picture_path;
    /**
     * @var string
     */
    public $status;
}
