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
            <div class="input-group mb-2">
                <!-- <input type="text" class="form-control" placeholder="Tìm kiếm nhân viên" name="search"> -->
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

    <div style="display: flex; flex-wrap: wrap;">

    @foreach($employees as $employee)
        <div class="card mx-2 mb-4" style="width: calc(33.33% - 16px);">
            <div style="display: flex; align-items: center; justify-content: center; height: 200px;">
                @if ($employee->Avatar == null)
                    <img style="width: 200px; height: 100%; object-fit: cover; border-radius: 2%" src="{{ asset('img/default_avatar.jpeg') }}" class="card-img-top" alt="">
                @else
                    <img style="width: 200px; height: 100%; object-fit: cover; border-radius: 2%" src="{{ asset('storage/uploads/' . $employee->Avatar) }}" class="card-img-top" alt="">
                @endif

                <div class="card-body">
                <h5 class="card-title">{{ $employee->FullName }}</h5>
                <p class="employee-card-text">Địa Chỉ: {{ $employee->Address }}</p>
                <p class="employee-card-text">Email: {{ $employee->Email }}</p>
                <p class="employee-card-text">Liên Hệ: {{ $employee->MobilePhone }}</p>
                <p class="employee-card-text">Chức Vụ: {{ $employee->Position }}</p>
                <p class="employee-card-text">Trực Thuộc Đơn Vị: {{ $employee->getDepartmentName($employee->DepartmentID) }}</p>

                @if (session()->has('user'))
                    @if (session("user")->Role == "Admin")
                    <div style="display: inline-block;">
                        <a href="{{ route('employee.edit', $employee) }}" class="btn btn-warning mx-1 mt-1"><i class="bi bi-pen-fill"></i></a>
                    </div>
                    <div style="display: inline-block;">
                        <form>
                            <button id="deleteButton" type="button" class="btn btn-danger mx-1 mt-1" data-employee-id="{{ $employee->ID }}" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal"><i class="bi bi-trash-fill"></i></button>
                        </form>
                    </div>
                    @endif
                @endif

            </div>
            </div>
        </div>
    @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $employees->withQueryString()->links() }}
    </div>

</div>

</x-layout>