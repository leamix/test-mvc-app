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
     * @var int
     */
    public $created_at;
    /**
     * @var string
     */
    public $status;

    public function getCreatedAt()
    {
        return date('d.m.Y', (int)$this->created_at);
    }
}
