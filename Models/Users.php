<?php

namespace Models;

use Core\Database;

/**
 * Class Users
 * @package Models
 */
class Users extends Database
{
    /**
     * @var
     */
    protected $table = 'users';

    /**
     * @var string
     */
    protected $model = 'Users';
}
