@extends('installer.layout')

@section('page_title')
License Check
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="offset-md-3 col-md-6">
            <h4 class="blue-text">License Check</h4>
            <form method="POST" action="{{ route('InstallLicenseSubmit') }}">
                @csrf
                <label for="code">License Code</label><br>
                <input id="code" type="text" name="code" placeholder="Enter your License Code">
                <br><br>
                <input type="submit" class="blue-bg" value="Next">
            </form>
        </div>
    </div>
</div>
@endsection