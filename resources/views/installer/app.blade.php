@extends('installer.layout')

@section('page_title')
Website Details
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="offset-md-3 col-md-6">
            <h4 class="blue-text">Website Details</h4>
            <form method="POST" action="{{ route('InstallAppSubmit') }}">
                @csrf
                <label for="APP_NAME">Website Name</label><br>
                <input id="APP_NAME" type="text" name="APP_NAME" placeholder="Enter your Website Name" value="{{ env('APP_NAME', 'TMail') }}">
                <br>
                <label for="APP_URL">Website URL</label><br>
                <input id="APP_URL" type="text" name="APP_URL" placeholder="Enter your Website URL" value="{{ env('APP_URL', '') }}">
                <br><br>
                <input type="submit" class="blue-bg" value="Next">
            </form>
        </div>
    </div>
</div>
@endsection