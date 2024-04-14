<x-layout>

<div class="container-fluid">
    <h1 class="my-3">DANH BẠ NHÂN VIÊN</h1>

    @if (request()->get('noti'))
        @if (request()->get('notiStatus') == "success")
            <div class="alert alert-success" role="alert">
                {{ request()->get('noti') }}
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                {{ request()->get('noti') }}
            </div>
        @endif
    @endif

    @if (session()->has('user'))
        @if (session("user")->Role == "Admin")
            <a href="{{ route('employee.create') }}" class="btn btn-secondary m-3" style="background-color: #001373">Thêm Nhân Viên</a>
        @endif
    @endif

    <div class="container-fluid">
        <form action="{{ route('employee.index') }}" method="get">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Tìm kiếm nhân viên" name="search" value="{{ session('search') }}">
                <button class="btn btn-secondary" type="submit" style="background-color: #001373">Tìm Kiếm</button>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <select class="form-select" name="department">  
                        <option value="0">--- Tất cả đơn vị ---</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->ID }}" {{ session('department') == $department->ID ? 'selected' : '' }}>
                                {{ $department->DepartmentName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <select class="form-select" name="address">
                        <option value="0">--- Tất cả địa chỉ ---</option>
                        @foreach($addresses as $address)
                            <option value="{{ $address }}" {{ session('address') == $address ? 'selected' : '' }}>
                                {{ $address }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <select class="form-select" name="position">
                        <option value="0">--- Tất cả chức vụ ---</option>
                        @foreach($positions as $position)
                            <option value="{{ $position }}" {{ session('position') == $position ? 'selected' : '' }}>
                                {{ $position }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </form>
    </div>

    <div style="display: flex; flex-wrap: wrap;" class="mt-4">

        <table class="table">
        <thead>
            <tr>
            <th scope="col">Tên Nhân Viên</th>
            <th scope="col">Địa Chỉ</th>
            <th scope="col">Email</th>
            <th scope="col">Liên Hệ</th>
            <th scope="col">Chức Vụ</th>
            <th scope="col">Trực Thuộc Đơn Vị</th>
            <th scope="col">Cập Nhật Danh Bạ</th>
            <th scope="col">Xóa Danh Bạ</th>
            </tr>
        </thead>
        @foreach($employees as $employee)
            <tbody>
                <tr>
                <th scope="row">{{ $employee->FullName }}</th>
                <td>{{ $employee->Address }}</td>
                <td>{{ $employee->Email }}</td>
                <td>{{ $employee->MobilePhone }}</td>
                <td>{{ $employee->Position }}</td>
                <td>{{ $employee->getDepartmentName($employee->DepartmentID) }}</td>
                @if (session()->has('user'))
                    @if (session("user")->Role == "Admin")
                    <td>
                        <a href="{{ route('employee.edit', $employee) }}" class="btn btn-warning mx-1 mt-1"><i class="bi bi-pen-fill"></i></a>
                    </td>
                    <td>
                        <button id="deleteButton" type="button" class="btn btn-danger mx-1 mt-1" data-employee-id="{{ $employee->ID }}" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal"><i class="bi bi-trash-fill"></i></button>
                    </td>
                    @endif
                @endif
                </tr>
            </tbody>
        @endforeach
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $employees->withQueryString()->links() }}
    </div>

</div>
</x-layout>