@extends('installer.layout')

@section('page_title')
Database Details
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="offset-md-3 col-md-6">
            <h4 class="blue-text">Database Details</h4>
            <form method="POST" action="{{ route('InstallDatabaseSubmit') }}">
                @csrf
                <label for="DB_HOST">Database Host</label><br>
                <input id="DB_HOST" type="text" name="DB_HOST" placeholder="Enter Database Hostname" value="{{ env('DB_HOST', 'localhost') }}">
                <br>
                <label for="DB_PORT">Database Port</label><br>
                <input id="DB_PORT" type="text" name="DB_PORT" placeholder="Enter Database Port" value="{{ env('DB_PORT', '3306') }}">
                <br>
                <label for="DB_DATABASE">Database Name</label><br>
                <input id="DB_DATABASE" type="text" name="DB_DATABASE" placeholder="Enter Database Name" value="{{ env('DB_DATABASE', '') }}">
                <br>
                <label for="DB_USERNAME">Database Username</label><br>
                <input id="DB_USERNAME" type="text" name="DB_USERNAME" placeholder="Enter Database Username" value="{{ env('DB_USERNAME', '') }}">
                <br>
                <label for="DB_PASSWORD">Database Password</label><br>
                <input id="DB_PASSWORD" type="text" name="DB_PASSWORD" placeholder="Enter Database Password" value="{{ env('DB_PASSWORD', '') }}">
                <br><br>
                <input type="submit" class="blue-bg" value="Next">
            </form>
        </div>
    </div>
</div>
@endsection