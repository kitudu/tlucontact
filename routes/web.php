<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Models\Department;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get("/employee", [EmployeeController::class, "index"])->name("employee.index");
Route::get("/employee/create", [EmployeeController::class, "create"])->name("employee.create");
Route::post("/employee", [EmployeeController::class, "store"])->name("employee.store");
Route::get("/employee/{employee}", [EmployeeController::class, "show"])->name("employee.show");
Route::get("/employee/{employee}/edit", [EmployeeController::class, "edit"])->name("employee.edit");
Route::put("/employee/{employee}", [EmployeeController::class, "update"])->name("employee.update");
Route::delete("/employee/{employee}", [EmployeeController::class, "destroy"])->name("employee.destroy");

// Route::resource('employee', EmployeeController::class);


Route::get("/department", [DepartmentController::class, "index"])->name("department.index");
Route::get("/department/create", [DepartmentController::class, "create"])->name("department.create");
Route::post("/department", [DepartmentController::class, "store"])->name("department.store");
Route::get("/department/{department}", [DepartmentController::class, "show"])->name("department.show");
Route::get("/department/{department}/edit", [DepartmentController::class, "edit"])->name("department.edit");
Route::put("/department/{department}", [DepartmentController::class, "update"])->name("department.update");
Route::delete("/department/{department}", [DepartmentController::class, "destroy"])->name("department.destroy");

// Route::resource('department', DepartmentController::class);

Route::get("/user", [UserController::class, "index"])->name("user.index");
Route::post("/user/login", [UserController::class, "login"])->name("user.login");
Route::get("/user/logout", [UserController::class, "logout"])->name("user.logout");
Route::get("/user/detail", [UserController::class, "detail"])->name("user.detail");
Route::put("/user/{employee}", [UserController::class, "update"])->name("user.update");
Route::get("/user/password", [UserController::class, "password"])->name("user.password");
Route::post("/user/updatePassword", [UserController::class, "updatePassword"])->name("user.updatePassword");

Route::post('department/viewMode', function (Request $request) {
    $mode = $request->input('mode');
    $request->session()->put('viewMode', $mode);
})->name('department.viewMode');





