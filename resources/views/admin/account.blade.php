@extends('admin.layout')

@section('addonCSS')
<link href="{{ asset('css/admin.css?v='.env('APP_VERSION')) }}" rel="stylesheet">
@endsection

@section('addonJS')
<script>
    let change_password_check = document.getElementById('change_password')
    change_password_check.addEventListener('change', () => {
        document.querySelector('.change_password_box').classList.toggle('d-none')
    })
</script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="page_title">Account Update</h3>
            <form action="{{ route('AdminAccountUpdate') }}" method="post">
                @csrf 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Enter your Name</label>
                            <div class="field">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Enter your Email</label>
                            <div class="field">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required autocomplete="email">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="change_password" id="change_password">
                            <label class="form-check-label m-0" for="change_password">I want to change my Password</label>
                        </div>
                    </div>
                </div>
                <div class="row change_password_box d-none">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="current_password">Enter current Password</label>
                            <div class="field">
                                <input id="current_password" type="password" class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}" name="current_password" autocomplete="current-password">
                                @if ($errors->has('current_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="new_password">Enter new Password</label>
                            <div class="field">
                                <input id="new_password" type="password" class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" name="new_password" autocomplete="new-password">
                                @if ($errors->has('new_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="confirm_password">Confirm new Password</label>
                            <div class="field">
                                <input id="confirm_password" type="password" class="form-control{{ $errors->has('confirm_password') ? ' is-invalid' : '' }}" name="confirm_password" autocomplete="new-password">
                                @if ($errors->has('confirm_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 menu-form">
                        <button class="blue-bg" type="submit">Change Details</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
