@extends('installer.layout')

@section('page_title')
Welcome
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="offset-md-3 col-md-6">
            <h4 class="blue-text">TMail Installation Completed!</h4>
            <p>TMail Installation successfully completed. Please visit the website to get started.</p>
            <a href="{{ route('home') }}"><button type="button" class="primary-btn blue-bg">Visit Website</button></a>
        </div>
    </div>
</div>
@endsection