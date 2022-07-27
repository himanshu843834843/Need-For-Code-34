<?php

namespace App\Models;

use App\Helpers\Constants\BaseConstants;
use App\Queries\TeacherScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory, TeacherScopes;

    protected $table = "teacher";
    public function isActive(){
        return ($this->status == BaseConstants::ACTIVE);
    }
}
