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

    <div style="display: flex; flex-wrap: wrap;">

    @foreach($departments as $department)
        <div class="card mx-2 mb-4" style="width: calc(33.33% - 16px);">
            <div style="display: flex; align-items: center; justify-content: center; height: 200px;">
                @if ($department->Avatar == null)
                    <img style="width: 200px; height: 100%; object-fit: cover; border-radius: 2%" src="{{ asset('img/default_department.png') }}" class="card-img-top" alt="">
                @else
                    <img style="width: 200px; height: 100%; object-fit: cover; border-radius: 2%" src="{{ asset('storage/uploads/' . $department->Avatar) }}" class="card-img-top" alt="">
                @endif

                <div class="card-body">
                <h5 class="card-title">{{ $department->DepartmentName }}</h5>
                <p class="card-text">Địa Chỉ: {{ $department->Address }}</p>
                <p class="card-text">Email: {{ $department->Email }}</p>
                <p class="card-text">Liên Hệ: {{ $department->Phone }}</p>
                <p class="card-text">Đơn Vị: {{ $department->getParentDepartmentName($department->ParentDepartmentID) }}</p>

                @if (session()->has('user'))
                    @if (session("user")->Role == "Admin")
                    <div style="display: inline-block;">
                        <a href="{{ route('department.edit', $department) }}" class="btn btn-warning mx-1 mt-1"><i class="bi bi-pen-fill"></i></a>
                    </div>
                    <div style="display: inline-block;">
                        <form>
                            <?php
                                $employees = \App\Models\Employee::where('DepartmentID', $department->ID)->get();
                                $count = count($employees);
                            ?>
                            <button id="deleteButton" type="button" class="btn btn-danger mx-1 mt-1" data-department-id="{{ $department->ID }}" data-employee-count="{{ $count }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi bi-trash-fill"></i></button>
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
        {{ $departments->withQueryString()->links() }}
    </div>

</div>

</x-layout>