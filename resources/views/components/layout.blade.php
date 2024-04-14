<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Bạ Điện Tử TLU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .card-text {
            margin: 5px;
            font-size: 14px;
        }

        .employee-card-text {
            margin: 3px;
            font-size: 12px;
        }
    </style>
</head>

<body>

<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" style="height: 100px">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">DANH BẠ ĐIỆN TỬ TLU</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link" aria-current="page" href="https://tlu.edu.vn">TRANG CHỦ</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="{{ route('department.index') }}">DANH BẠ ĐƠN VỊ</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="{{ route('employee.index') }}">DANH BẠ NHÂN VIÊN</a>
            </li>

        </ul>

        <div class="d-flex">
            @if (session()->has('login'))
                <a style="background-color: #001373; text-decoration: none" href="{{ route('user.detail', session("user")) }}" class="btn btn-primary mx-2">{{ session("user")->Username }} </a>
                <a href="{{ route('user.logout') }}" class="btn btn-danger">Đăng Xuất?</a>
            @else
                @if (!Request::is('user*'))
                    <a style="background-color: #001373" href="{{ route('user.index') }}" class="mx-2 btn btn-secondary">Đăng Nhập?</a>
                @endif
            @endif
        </div>

        </div>
    </div>
    </nav>
</header>

<main>
    @if (session()->has('user'))
        @if (session("user")->Role == "Admin")
            @if (url()->current() == url('/department') || url()->current() == url('/employee'))
            <div class="form-check form-switch mx-4" style="float: right;">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" {{ session('viewMode') == 'table' ? 'checked' : '' }}>
                <label class="form-check-label" for="flexSwitchCheckDefault">Chế Độ Bảng</label>
            </div>
            @endif
        @endif
    @endif
    
    <div class="container-fluid mt-4" id="viewContainer">
        {{ $slot }}
    </div>

    <!-- Bootstrap Modal for Delete Department Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">XÓA ĐƠN VỊ!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Hiện đang có <span id="employeeCount"></span> nhân viên trực thuộc đơn vị này.</p>
                    <p>Dữ liệu danh bạ của nhân viên trực thuộc sẽ bị xóa.</p>
                    <p>Bạn có chắc chắn muốn xóa đơn vị này không?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form id="deleteForm" action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modal for Delete Employee Confirmation -->
    <div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">XÓA NHÂN VIÊN!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="employeeID"></p>
                    <p>Bạn có chắc chắn muốn xóa danh bạ nhân viên.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form id="deleteEmployeeForm" action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>

<footer class="text-center text-lg-start bg-body-tertiary text-muted">
    <section class="" >
        <div class="text-center p-4">
            © 2024 TRƯỜNG ĐẠI HỌC THỦY LỢI
        </div>
    </section>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

// Switch Button
$('#flexSwitchCheckDefault').on('change', function() {
    var mode = this.checked ? 'table' : 'card';
    $.ajax({
        url: "{{ route('department.viewMode') }}",
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            mode: mode
        },
        success: function(response) {
            location.reload();
        }
    });
});

// Delete Employee Modal
const deleteEmployeeModal = document.getElementById('deleteEmployeeModal');

deleteEmployeeModal.addEventListener('shown.bs.modal', (event) => {
    const deleteButton = event.relatedTarget;
    const employeeId = deleteButton.getAttribute('data-employee-id');

    const deleteForm = document.getElementById('deleteEmployeeForm');
    deleteForm.action = '/employee/' + employeeId;
});

// Delete Department Modal
const deleteModal = document.getElementById('deleteModal');

deleteModal.addEventListener('shown.bs.modal', (event) => {
    const deleteButton = event.relatedTarget;
    const employeeCount = deleteButton.getAttribute('data-employee-count');
    const employeeCountSpan = document.getElementById('employeeCount');
    employeeCountSpan.textContent = employeeCount;

    const departmentId = deleteButton.getAttribute('data-department-id');
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = '/department/' + departmentId;
});
</script>
</body>

</html>