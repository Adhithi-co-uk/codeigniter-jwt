<?php

namespace Modules\Auth\Entities;

use CodeIgniter\Entity\Entity;

class Role extends Entity
{
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
}
