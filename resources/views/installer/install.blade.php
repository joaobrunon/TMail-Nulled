@extends('installer.layout')

@section('page_title')
Welcome
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="offset-md-3 col-md-6">
            <h4 class="blue-text">TMail Installer</h4>
            <p>This installer will guide you through various installation process and will need you to create Database & Email account from your control panel. It will ask for various details which you will get from your control panel after creating Database and email account. Incase if you are not familiar on how to proceed watch the tutorial video here</p>
            <p><iframe width="560" height="315" src="https://www.youtube.com/embed/QcIeTlGNJqo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
            <a href="{{ route('InstallLicense') }}"><button type="button" class="primary-btn blue-bg">Proceed</button></a>
        </div>
    </div>
</div>
@endsection