<?php

namespace App\Models;

use App\Queries\StudentScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory, StudentScopes;

    protected $table = "student";
    public function isActive(){
        return ($this->status == BaseConstants::ACTIVE);
    }
}
