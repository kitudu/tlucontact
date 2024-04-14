<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session('login')) {
            return redirect()->route('department.index');
        }
    
        return view('user.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        if ($request->has("deleteAvatar")) {
            $employee->Avatar = null;
            $employee->save();
            return redirect()->route('user.detail')->with(["noti" => "Xóa ảnh đại diện thành công", "notiStatus" => "success"]);
        } else {
            $username = $request->username;
            if ($username != session("user")->Username) {
                $user = User::where("Username", $username)->first();
                if ($user) {
                    return redirect()->route('user.detail')->with(["noti" => "Tên người dùng đã tồn tại", "notiStatus" => "danger"]);
                }
            }

            if ($request->email != $employee->Email) {
                $emailExistence = Employee::where('Email', $request->email)->first();
                if ($emailExistence) {
                    return redirect()->route('user.detail')->with(["noti" => "Email đã được đăng ký. Vui lòng thử lại.", "notiStatus" => "danger"]);
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
                $employee->Avatar = null;
            }

            $employee->save();

            $user = User::where('EmployeeID', $employee->ID)->first();
            $user->Username = $request->username;
            $user->save();

            session('user')->Username = $request->username;

            return redirect()->route('user.detail')->with(["noti" => "Cập nhật tài khoản thành công", "notiStatus" => "success"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function login(Request $request)
    {
    if ($request->isMethod("post")) {
        $username = $request->username;
        $password = $request->password;

        $user = User::where("Username", $username)->first();

        if (!$user) {
            return redirect()->route("user.index")->with(["noti" => "Tài khoản không tồn tại", "notiStatus" => "danger"]);
        }

        if (!password_verify($password, $user->Password)){
            return redirect()->route("user.index")->with(["noti" => "Mật khẩu không chính xác", "notiStatus" => "danger"]);
        }

        session(["login" => true]);
        session(["user" => $user]);;
        return redirect()->route("department.index");
    }

    }

    public function logout()
    {
        session()->flush();
        return redirect()->route("user.index");
    }

    public function detail()
    {
        $employeeID = session("user")->EmployeeID;
        $employee = Employee::find($employeeID);
        $departments = Department::All();

        return view("user.detail", ["employee" => $employee, "user" => session("user"), "departments" => $departments]);
    }

    public function password(){
        return view("user.updatePassword");
    }

    public function updatePassword(){
        $oldPassword = request("oldPassword");
        $newPassword = request("newPassword");
        $confirmPassword = request("confirmPassword");

        $user = session("user");

        if (!password_verify($oldPassword, $user->Password)){
            return redirect()->route("user.password")->with(["noti" => "Mật khẩu cũ không chính xác", "notiStatus" => "danger"]);
        }

        if ($newPassword != $confirmPassword){
            return redirect()->route("user.password")->with(["noti" => "Mật khẩu mới không khớp", "notiStatus" => "danger"]);
        }

        $user->Password = bcrypt($newPassword);
        $user->save();

        return redirect()->route("user.detail")->with(["noti" => "Cập nhật mật khẩu thành công", "notiStatus" => "success"]);
    }
}
