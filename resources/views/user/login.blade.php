<x-layout>

    <div class="container-fluid h-custom my-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="{{ asset('img/logo.webp') }}" class="img-fluid" alt="">
            </div>

            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <h1 class="mb-4">ĐĂNG NHẬP TÀI KHOẢN</h1>

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

                <form name="loginForm" action="{{ route('user.login') }}" method="post">
                    @csrf
                    <div class="form-outline mb-4">
                        <label class="form-label mt-2" for="username">Tên người dùng</label>
                        <input type="text" name="username" class="form-control form-control-lg"
                        placeholder="Vui lòng nhập tên người dùng" required />
                    </div>

                    <div class="form-outline mb-3">
                        <label class="form-label mt-2" for="password">Mật khẩu</label>
                        <input type="password" name="password" class="form-control form-control-lg"
                        placeholder="Vui lòng nhập mật khẩu" required />
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" class="btn btn-secondary btn-lg"
                        style="padding-left: 2.5rem; padding-right: 2.5rem; background-color: #001373;">Xác Nhận</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

</x-layout>