@extends('admin.layout')

@section('addonCSS')
<link href="{{ asset('css/admin.css?v='.env('APP_VERSION')) }}" rel="stylesheet">
@endsection

@section('addonJS')
<script src="{{ asset('js/admin/update.js') }}?v={{ env('APP_VERSION') }}" defer></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="page_title">Software Update</h3>
            <div id="update-progress">

            </div>
            @if(isset($manual) && $manual)
            <div class="d-none" id="manual" link="{{ route('AdminApplyUpdate') }}">TRUE</div>
            @else
            <p class="description_details">
                @if($update)
                <strong>Update Available!</strong> 
                <br>Click on below button to update your website. <br>Please make sure you had created a backup before applying update.
                <br><br><br><a class="blue-bg normal-button" id="update-button" link="{{ route('AdminApplyUpdate') }}">Update TMail</a>
                @else 
                You're on Latest version of TMail!
                @endif
            </p>
            <br><br><br>
            <div class="description_box_title">
                <h3>Manual Software Update</h3>
            </div>
            <br>
            <form method="POST" action="{{ route('AdminUpdateManual') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" id="update" name="update" required>
                <br><br>
                <button type="submit" class="btn btn-primary blue-purple-bg normal-button">
                    {{ __('Submit') }}
                </button>
            </form>
            @endif
        </div>
    </div>
@endsection
