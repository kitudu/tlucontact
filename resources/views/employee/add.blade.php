<x-layout>
<main class="m-5">
    <h1 style="text-align: center; margin-top: 20px">THÊM MỚI DANH BẠ NHÂN VIÊN</h1>

    @if (request()->get('noti'))
        @if (request()->get('notiStatus') == "success")
            <div class="alert alert-success" role="alert">
                <?= $_GET['noti'] ?>
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                <?= $_GET['noti'] ?>
            </div>
        @endif
    @endif

    <form name="addEmployeeForm" action="{{ route('employee.store') }}" method="post" enctype="multipart/form-data" onsubmit="return validatePhoneNumber()">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên nhân viên</label>
            <input type="text" name ="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" name ="address" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name ="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" name ="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Chức vụ</label>
            <input type="text" name ="position" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Vai trò tài khoản</label>
            <select name="role" class="form-select">
                <option value="User">Người dùng</option>
                <option value="Admin">Quản trị viên</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">Ảnh đại diện</label>
            <input type="file" name="avatar" class="form-control" accept="image/jpeg, image/png, image/gif, image/webp">
        </div>

        <div class="mb-3">
            <label for='parentID' class='form-label'>Trực Thuộc Đơn Vị</label>
            <select name='parentID' class='form-select'>
                @foreach($departments as $department)
                    <option value='{{ $department->ID }}'>{{ $department->DepartmentName }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-secondary" style="background-color: #001373">Xác nhận</button>
    </form>
</main>

<script>
    function validatePhoneNumber() {
        var phoneNumber = document.forms["addEmployeeForm"]["phone"].value;
        var phoneNumberPattern = /^(0[1-9][0-9]{8,9})$/;
        if (!phoneNumberPattern.test(phoneNumber)) {
            alert("Số điện thoại không hợp lệ. Vui lòng nhập lại số điện thoại.");
            return false;
        } 
        return true;
    }
</script>
</x-layout>
