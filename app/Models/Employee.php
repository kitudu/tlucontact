<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'ID';

    public function getDepartmentName($DepartmentID){
        return Department::find($DepartmentID)->DepartmentName;
    }
}
