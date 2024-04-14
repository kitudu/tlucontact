<x-layout>

<div class="container-fluid">
    <h1 class="my-3">DANH BẠ ĐƠN VỊ</h1>

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
            <a href="{{ route('department.create') }}" class="btn btn-secondary m-3" style="background-color: #001373">Thêm Đơn Vị</a>
        @endif
    @endif

    <div class="container-fluid">
        <form action="" method="get">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Tìm kiếm đơn vị" name="search">
                <button class="btn btn-secondary" type="submit" style="background-color: #001373">Tìm Kiếm</button>
            </div>
        </form>
    </div>

    <div style="display: flex; flex-wrap: wrap;" class="mt-4">

        <table class="table">
        <thead>
            <tr>
            <th scope="col">Tên Đơn Vị</th>
            <th scope="col">Địa Chỉ</th>
            <th scope="col">Email</th>
            <th scope="col">Liên Hệ</th>
            <th scope="col">Trực Thuộc Đơn Vị</th>
            <th scope="col">Cập Nhật Danh Bạ</th>
            <th scope="col">Xóa Danh Bạ</th>
            </tr>
        </thead>
        @foreach($departments as $department)
            <tbody>
                <tr>
                <th scope="row">{{ $department->DepartmentName }}</th>
                <td>{{ $department->Address }}</td>
                <td>{{ $department->Email }}</td>
                <td>{{ $department->Phone }}</td>
                <td>{{ $department->getParentDepartmentName($department->ParentDepartmentID) }}</td>
                @if (session()->has('user'))
                    @if (session("user")->Role == "Admin")
                    <td>
                        <a href="{{ route('department.edit', $department) }}" class="btn btn-warning mx-1 mt-1"><i class="bi bi-pen-fill"></i></a>
                    </td>
                    <td>
                        <?php
                            $employees = \App\Models\Employee::where('DepartmentID', $department->ID)->get();
                            $count = count($employees);
                        ?>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-department-id="{{ $department->ID }}" data-employee-count="{{ $count }}"><i class="bi bi-trash-fill"></i></button>
                    </td>
                    @endif
                @endif
                </tr>
            </tbody>
        @endforeach
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $departments->withQueryString()->links() }}
    </div>

</div>
</x-layout>