<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'register'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password'];

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}
