<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table = 'tblaccounts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password'];
}