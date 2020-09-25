<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class User extends Entity
{
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'user_sessions' => true,
    ];

    protected $_hidden = [
        'password',
    ];
}
