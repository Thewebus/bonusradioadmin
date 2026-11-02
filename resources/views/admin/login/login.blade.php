@extends('admin.layout.page-app')

@section('content')
    <div class="h-100">
        <div class="h-100 no-gutters row">
            <div class="d-none d-lg-block h-100 col-lg-5 col-xl-4">
                <div class="left-caption">
                    <img src="{{ asset('assets/imgs/mybonus_logo.png') }}" alt="{{ App_Name() }}" class="mb-login-logo">
                </div>
            </div>
            <div class="h-100 d-flex login-bg justify-content-center align-items-lg-center col-md-12 col-lg-7 col-xl-8">
                <div class="mx-auto col-sm-12 col-md-10 col-xl-8">
                    <div class="py-5">
                        <div class="login-card">
                        <img src="{{ asset('assets/imgs/mybonus_logo.png') }}" alt="{{ App_Name() }}" class="mb-login-logo-sm d-lg-none">
                        <h1 class="login-title">Welcome back, Admin</h1>
                        <p class="login-sub">Please sign in to your account.</p>

                        @php
                        $emailValue = Check_Admin_Access() == 0 ? 'admin@admin.com' : '';
                        $passwordValue = Check_Admin_Access() == 0 ? 'admin' : '';
                        @endphp

                        <form method="POST" id="login_form">
                            <div class="form-row mt-4">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label>Email</label>
                                        <input name="email" placeholder="Email here..." type="email" class="form-control" value="{{ $emailValue }}" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label>Password</label>
                                        <input name="password" placeholder="Password here..." type="password" class="form-control" value="{{ $passwordValue }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-6 text-center text-sm-left">
                                    <button class="btn btn-default mw-120" onclick="save_login()" type="button">Login</button>
                                </div>
                            </div>
                            @if(Check_Admin_Access() == 0)
                            <hr>
                            <h6>
                                If you cannot login, then
                                <a href="{{ route('admin.login') }}" class="btn-link" target="_blank">{{ __('Label.click_here') }}</a>
                            </h6>
                            @endif
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>
        function save_login() {
            $("#dvloader").show();
            var formData = new FormData($("#login_form")[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route("admin.save.login") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    get_responce_message(resp, 'login_form', '{{ route("admin.dashboard") }}');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown, textStatus);
                }
            });
        }

        // Press Enter Key & Save Form
        $('#login_form').keypress((e) => { 
            // Enter key corresponds to number 13 
            if (e.which === 13) { 
                save_login();
            } 
        })
    </script>
@endsection