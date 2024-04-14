<x-layout>
<main class="m-5">
    <h1 style="text-align: center; margin-bottom: 20px">THÔNG TIN TÀI KHOẢN</h1>

    @if (session('noti'))
        @if (session('notiStatus') == "success")
            <div class="alert alert-success" role="alert">
                {{ session('noti') }}
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                {{ session('noti') }}
            </div>
        @endif
    @endif

    <form name="editEmployeeForm" action="{{ route('user.update', $employee) }}" method="post" enctype="multipart/form-data" onsubmit="return validatePhoneNumber()">
        @csrf
        @method("PUT")
        <div style="display: flex; align-items: center; justify-content: center;">
            <div class="mb-3">
                    @if ($employee->Avatar == null)
                        <img src="{{ asset('img/default_avatar.jpeg') }}" style='width: 200px; height: 200px; object-fit: cover; border-radius: 10%; margin-bottom: 10px'>
                    @else 
                        <img src="{{ asset('storage/uploads/' . $employee->Avatar) }}" style='width: 200px; height: 200px; object-fit: cover; border-radius: 10%; margin-bottom: 10px'>
                    @endif
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: center;">
            <div class="mb-3" style="display: flex; align-items: center;">
                <input type="file" name="avatar" class="form-control" accept="image/jpeg, image/png, image/gif, image/webp" style="width: 240px">
                <button name="deleteAvatar" type="submit" class="btn btn-danger ms-2" onclick="return confirm('Bạn có chắc chắn muốn xóa ảnh đại diện?')"><i class="bi bi-trash3"></i></button>
            </div> 
        </div>

        <input type="hidden" name="id" value="<?= $employee->ID ?>">

        <div class="mb-3 mt-2">
            <a class="btn btn-secondary" href="{{ route('user.password') }}">Đổi mật khẩu</a>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Tên nhân viên</label>
            <input type="text" name ="name" class="form-control" value="<?= $employee->FullName ?>" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Tên người dùng</label>
            <input type="text" name ="username" class="form-control" value="<?= $user->Username ?>" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Vai trò tài khoản</label>
            <?php
                $role="";
                if ($user->Role == "Admin"){
                    $role = "Quản trị viên";
                } else {
                    $role = "Nhân viên";
                }
            ?>
            <input type="text" name ="role" class="form-control" value="<?= $role ?>" readonly>
        </div>
        
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" name ="address" class="form-control" value="<?= $employee->Address ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name ="email" class="form-control" value="<?= $employee->Email ?>" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" name ="phone" class="form-control" value="<?= $employee->MobilePhone ?>" required>
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Chức vụ</label>
            <input type="text" name ="position" class="form-control" value="<?= $employee->Position ?>" required>
        </div>

        <div class="mb-3">
        <label for='parentID' class='form-label'>Trực Thuộc Đơn Vị</label>
            <select name='parentID' class='form-select'>
                <option value='{{ $employee->DepartmentID }}'>(Đơn Vị Hiện Tại) {{ $employee->getDepartmentName($employee->DepartmentID) }}</option>

                @foreach ($departments as $department)
                    <option value='{{ $department->ID }}'>{{ $department->DepartmentName }}</option>
                @endforeach
            </select>
        </div>

        <button name="updateEmployee" type="submit" class="btn btn-secondary" style="background-color: #001373">Xác nhận</button>
    </form>
</main>

<script>
    function validatePhoneNumber() {
        var phoneNumber = document.forms["editDepartmentForm"]["phone"].value;
        var phoneNumberPattern = /^(0[1-9][0-9]{8,9})$/;
        if (!phoneNumberPattern.test(phoneNumber)) {
            alert("Số điện thoại không hợp lệ. Vui lòng nhập lại số điện thoại.");
            return false;
        } 
        return true;
    }
</script>

</x-layout>