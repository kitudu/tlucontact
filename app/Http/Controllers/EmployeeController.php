<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        session()->forget('search');
        session()->forget('department');
        session()->forget('address');
        session()->forget('position');

        $employees = Employee::orderBy("ID", "desc")->paginate(9);

        // Advanced Search
        $departments = Department::orderBy("ID", "desc")->get();
        $addresses = Employee::distinct('Address')->pluck('Address');
        $positions = Employee::distinct('Position')->pluck('Position');
            
        if ($request->has('search')){
            session()->flash('search', $request->input('search'));
            session()->flash('department', $request->input('department'));
            session()->flash('address', $request->input('address'));
            session()->flash('position', $request->input('position'));

            $search = isset($_GET['search']) ? $_GET['search'] : "";
            $departmentID = isset($_GET['department']) ? $_GET['department'] : "";
            $address = isset($_GET['address']) ? $_GET['address'] : "";
            $position = isset($_GET['position']) ? $_GET['position'] : "";
    
            $query = Employee::query();
            if ($search != "") {
                $query->where('FullName', 'like', '%' . $search . '%');
            }

            if ($departmentID != "0") {
                $query->where('DepartmentID', $departmentID);
            }

            if ($address != "0") {
                $query->where('Address', $address);
            }

            if ($position != "0") {
                $query->where('Position', $position);
            }
            $employees = $query->orderBy("ID", "desc")->paginate(9);
        }

        if ($request->session()->has('viewMode')){
            $viewMode = $request->session()->get('viewMode');
            if ($viewMode == "table"){
                return view("employee.indexTableView", ["employees" => $employees, "departments" => $departments, "addresses" => $addresses, "positions" => $positions]);
            } else {
                return view("employee.index", ["employees" => $employees, "departments" => $departments, "addresses" => $addresses, "positions" => $positions]);
            }
        } 
        
        return view("employee.index", ["employees" => $employees, "departments" => $departments, "addresses" => $addresses, "positions" => $positions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $departments = Department::orderBy("ID", "desc")->get();
        return view("employee.add", ["departments" => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee = new Employee();
        $employee->FullName = $request->name;
        $employee->Address = $request->address;
        $employee->Email = $request->email;
        $employee->MobilePhone = $request->phone;
        $employee->Position = $request->position;
        $employee->DepartmentID = $request->parentID;

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/uploads', $filename);
            $employee->Avatar = $filename;
        } else {
            $employee->Avatar = null;
        }

        $emailExistence = Employee::where('Email', $request->email)->first();
        if ($emailExistence) {
            return redirect()->route('employee.create', ['noti' => 'Email đã được đăng ký. Vui lòng thử lại.', 'notiStatus' => 'danger']);
        }

        $employee->save();

        $user = new User();
        $user->EmployeeID = $employee->ID;
        $user->Role = $request->role;
        $user->Username = $employee->Email;
        $user->Password = bcrypt("danhbadientu@pass");
        $user->save();

        return redirect()->route('employee.index', ['noti' => 'Thêm nhân viên thành công', 'notiStatus' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee, Request $request)
    {
        $departments = Department::orderBy("ID", "desc")->get();
        $user = User::where('EmployeeID', $employee->ID)->first();
        return view("employee.edit", ["employee" => $employee, "departments" => $departments, "user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $departments = Department::orderBy("ID", "desc")->get();
        $user = User::where('EmployeeID', $employee->ID)->first();

        if ($request->has('deleteAvatar')) {
            $employee->Avatar = null;
            $employee->save();
            return redirect()->route("employee.edit", ["employee" => $employee, "departments" => $departments, "user" => $user])->with(["noti" => "Xóa ảnh đại diện thành công.", "notiStatus" => "success"]);
        } else {
            if ($request->email != $employee->Email) {
                $emailExistence = Employee::where('Email', $request->email)->first();
                if ($emailExistence) {
                    return redirect()->route('employee.edit', ['employee' => $employee, 'departments' => $departments, 'user' => $user])->with(["noti" => "Email đã được đăng ký. Vui lòng thử lại.", "notiStatus" => "danger"]);
                }
            }

            $employee->FullName = $request->name;
            $employee->Address = $request->address;
            $employee->Email = $request->email;
            $employee->MobilePhone = $request->phone;
            $employee->Position = $request->position;
            $employee->DepartmentID = $request->parentID;

            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/uploads', $filename);
                $employee->Avatar = $filename;
            } else {
                $employee->Avatar = $employee->Avatar;
            }

            $employee->save();

            $user = User::where('EmployeeID', $employee->ID)->first();
            $user->Role = $request->role;
            $user->save();

            return redirect()->route('employee.index', ['noti' => 'Cập nhật nhân viên thành công', 'notiStatus' => 'success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            User::where('EmployeeID', $employee->ID)->delete();
            $employee->delete();
            return redirect()->route('employee.index', ['noti' => 'Xóa nhân viên thành công', 'notiStatus' => 'success']);
        } catch (\Exception $e) {
            return redirect()->route('employee.index', ['noti' => 'Xóa nhân viên thất bại', 'notiStatus' => 'danger']);
        }
    }
}
