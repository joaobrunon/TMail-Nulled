@extends('installer.layout')

@section('page_title')
App Details
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="offset-md-3 col-md-6">
            <h4 class="blue-text">Admin Account Details</h4>
            <form method="POST" action="{{ route('InstallAdminSubmit') }}">
                @csrf
                <label for="name">Name</label><br>
                <input id="name" type="text" name="name" placeholder="Enter Name of Admin">
                <br>
                <label for="email">EMail ID</label><br>
                <input id="email" type="text" name="email" placeholder="Enter email ID of Admin">
                <br>
                <label for="password">Password</label><br>
                <input id="password" type="password" name="password" placeholder="Enter password">
                <br>
                <label for="password_confirmation">Confirm Password</label><br>
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Enter same password again">
                <br><br>
                <input type="submit" class="blue-bg" value="Next">
            </form>
        </div>
    </div>
</div>
@endsection