<x-layout>
    <main>
    <div class="container-fluid mb-3">
        <h1 class="mt-4 mb-3">MẬT KHẨU MỚI</h1>

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

        <form action="{{ route('user.updatePassword') }}" method="post" class="mt-5">
            @csrf
            @method('post')
            <div class="mb-3">
                <label for="oldPassword" class="form-label">Mật khẩu cũ</label>
                <input type="password" name ="oldPassword" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="newPassword" class="form-label">Mật khẩu mới</label>
                <input type="password" name ="newPassword" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" name ="confirmPassword" class="form-control" required>
            </div>

            <button name="updatePassword" type="submit" class="btn btn-secondary" style="background-color: #001373">Cập nhật mật khẩu</button>
        </form>
    </div>
    </main>
</x-layout>