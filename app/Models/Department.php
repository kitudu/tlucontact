<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID';

    public function getParentDepartmentName($ParentDepartmentID){
        if($ParentDepartmentID == null){
            return "Không Trực Thuộc Đơn Vị";
        }
        return Department::find($ParentDepartmentID)->DepartmentName;
    }
}
