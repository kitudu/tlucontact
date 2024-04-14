<x-layout>
<main class="m-5">
    <h1 style="text-align: center; margin-bottom: 20px">CẬP NHẬT THÔNG TIN ĐƠN VỊ</h1>
    
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

    <form name="editDepartmentForm" action="{{ route('department.update', $department) }}" method="post" enctype="multipart/form-data" onsubmit="return validatePhoneNumber()">
        @csrf
        @method("PUT")
        <div style="display: flex; align-items: center; justify-content: center;">
            <div class="mb-3">
                    @if ($department->Avatar == null)
                        <img src="{{ asset('img/default_department.png') }}" style='width: 200px; height: 200px; object-fit: cover; border-radius: 10%; margin-bottom: 10px'>
                    @else 
                        <img src="{{ asset('storage/uploads/' . $department->Avatar) }}" style='width: 200px; height: 200px; object-fit: cover; border-radius: 10%; margin-bottom: 10px'>
                    @endif
            </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: center;">
            <div class="mb-3" style="display: flex; align-items: center;">
                <input type="file" name="avatar" class="form-control" accept="image/jpeg, image/png, image/gif, image/webp" style="width: 240px">
                <button name="deleteAvatar" type="submit" class="btn btn-danger ms-2" onclick="return confirm('Bạn có chắc chắn muốn xóa ảnh đại diện?')"><i class="bi bi-trash3"></i></button>
            </div> 
        </div>

        <input type="hidden" name="id" value="<?= $department->ID ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Tên đơn vị</label>
            <input type="text" name ="name" class="form-control" value="<?= $department->DepartmentName ?>" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" name ="address" class="form-control" value="<?= $department->Address ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name ="email" class="form-control" value="<?= $department->Email ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" name ="phone" class="form-control" value="<?= $department->Phone ?>" required>
        </div>

        <div class="mb-3">
        <label for='parentID' class='form-label'>Trực Thuộc Đơn Vị</label>
            <select name='parentID' class='form-select'>
                @if ($department->ParentDepartmentID == null)
                    <option value='0'>Không Trực Thuộc Đơn Vị</option>
                @else
                    <option value='{{ $department->ParentDepartmentID }}'>(Đơn Vị Hiện Tại) {{ $department->getParentDepartmentName($department->ParentDepartmentID) }}</option>
                    <option value='0'>Không Trực Thuộc Đơn Vị</option>
                @endif
                
                @foreach ($departments as $department)
                    <option value='{{ $department->ID }}'>{{ $department->DepartmentName }}</option>
                @endforeach
            </select>
        </div>

        <button name="updateDepartment" type="submit" class="btn btn-secondary" style="background-color: #001373">Xác nhận</button>
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