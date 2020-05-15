@extends('installer.layout')

@section('page_title')
Mail Details
@endsection

@section('addonJS')
<script>
$("#addDomain").click(function(){
    $("#addDomain").before('<input type="text" name="domain[]" placeholder="Enter Domain">');
});
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="offset-md-3 col-md-6">
            <h4 class="blue-text">IMAP Mail Details</h4>
            <form method="POST" action="{{ route('InstallMailSubmit') }}">
                @csrf
                <label for="domain">Domain(s)</label><br>
                <input id="domain" type="text" name="domain[]" placeholder="Enter Domain">
                <div class="addIcons" id="addDomain">+</div>
                <br>
                <label for="IMAP_HOST">Mail Host</label><br>
                <input id="IMAP_HOST" type="text" name="IMAP_HOST" placeholder="Enter your Mail Host" value="{{ env('IMAP_HOST', 'localhost') }}">
                <br>
                <label for="IMAP_PORT">Mail Port</label><br>
                <input id="IMAP_PORT" type="text" name="IMAP_PORT" placeholder="Enter your Mail Port" value="{{ env('IMAP_PORT', '465') }}">
                <br>
                <label for="IMAP_ENCRYPTION">Mail Encryption</label><br>
                <input id="IMAP_ENCRYPTION" type="text" name="IMAP_ENCRYPTION" placeholder="Enter your Mail Encryption" value="{{ env('IMAP_ENCRYPTION', 'ssl') }}">
                <br>
                <label for="IMAP_VALIDATE_CERT">Enable SSL Check?</label><br>
                <select name="IMAP_VALIDATE_CERT">
                    <option value="false">No</option>
                    <option value="true">Yes</option>
                </select>
                <br>
                <label for="IMAP_USERNAME">Mail Username</label><br>
                <input id="IMAP_USERNAME" type="text" name="IMAP_USERNAME" placeholder="Enter your Mail Username" value="{{ env('IMAP_USERNAME', '') }}">
                <br>
                <label for="IMAP_PASSWORD">Mail Password</label><br>
                <input id="IMAP_PASSWORD" type="text" name="IMAP_PASSWORD" placeholder="Enter your Mail Password" value="{{ env('IMAP_PASSWORD', '') }}">
                <br><br>
                <input type="submit" class="blue-bg" value="Next">
            </form>
        </div>
    </div>
</div>
@endsection