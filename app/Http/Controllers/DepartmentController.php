<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = Department::orderBy("ID", "desc")->paginate(9);

        if ($request->has('search')) {
            $departments = Department::where('DepartmentName', 'like', '%' . $request->search . '%')->orderBy("ID", "desc")->paginate(9);
        }

        if ($request->session()->has('viewMode')){
            $viewMode = $request->session()->get('viewMode');
            if ($viewMode == "table"){
                return view("department.indexTableView", ["departments" => $departments]);
            } else {
                return view("department.index", ["departments" => $departments]);
            }
        } 
        
        return view("department.index", ["departments" => $departments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::orderBy("ID", "desc")->get();
        return view("department.add" , ["departments" => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $departmentNewName = Department::where("DepartmentName", $request->name)->first();
        if ($departmentNewName){
            return redirect()->route("department.create", ["noti" => "Tên đơn vị đã tồn tại.", "notiStatus" => "danger"]);
        } else {
            $department = new Department();
            $department->DepartmentName = $request->name;
            $department->Address = $request->address;
            $department->Email = $request->email;
            $department->Phone = $request->phone;
            $department->ParentDepartmentID = $request->parentID;
    
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename);
                $department->Avatar = $filename;
            } else {
                $department->Avatar = null;
            }
    
            if ($department->ParentDepartmentID == 0) {
                $department->ParentDepartmentID = null;
            }
    
            $department->save();
    
            return redirect()->route("department.index", ["noti" => "Thêm đơn vị thành công.", "notiStatus" => "success"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department, Request $request)
    {
        $departments = Department::orderBy("ID", "desc")->get();
    
        return view("department.edit", ["department" => $department, "departments" => $departments]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $departments = Department::orderBy("ID", "desc")->get();

        if ($request->has('deleteAvatar')) {
            $department->Avatar = null;
            $department->save();
            return redirect()->route("department.edit", ["department" => $department->ID, "noti" => "Xóa ảnh đại diện thành công.", "notiStatus" => "success"]);
        }
        
        else {
            if ($request->name != $department->DepartmentName) {
                $departmentName = Department::where("DepartmentName", $request->name)->first();
                if ($departmentName) {
                    return redirect()->route("department.edit", ["department" => $department, "noti" => "Tên đơn vị đã tồn tại.", "notiStatus" => "danger"]);
                }
            }

            $department->DepartmentName = $request->name;
            $department->Address = $request->address;
            $department->Email = $request->email;
            $department->Phone = $request->phone;
            $department->ParentDepartmentID = $request->parentID;

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename);
                $department->Avatar = $filename;
            } else {
                $department->Avatar = $department->Avatar;
            }

            if ($department->ParentDepartmentID == 0) {
                $department->ParentDepartmentID = null;
            }

            $department->save();

            return redirect()->route("department.index", ["noti" => "Cập nhật đơn vị thành công.", "notiStatus" => "success"]);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        try {
            $employeeIds = Employee::where('DepartmentID', $department->ID)->pluck('ID');
        
            User::whereIn('EmployeeID', $employeeIds)->delete();
        
            Employee::whereIn('ID', $employeeIds)->delete();
        
            Department::where('ParentDepartmentID', $department->ID)->update(['ParentDepartmentID' => null]);
        
            $department->delete();
        
            return redirect()->route("department.index", ["noti" => "Xóa đơn vị thành công.", "notiStatus" => "success"]);
        } catch (\Exception $e) {
            return redirect()->route("department.index", ["noti" => "Xóa đơn vị thất bại. Vui lòng thử lại.", "notiStatus" => "danger"]);
        }
    }
}
