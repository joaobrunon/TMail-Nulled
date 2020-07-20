@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-3 tm-sidebar">
            <div class="tm-ads">
                {!! isset($AD_SPACE_5) ? $AD_SPACE_5 : '' !!}
            </div>
            <div id="actions-flip" class="tm-actions">
                <div class="front">
                    <div class="tm-mailid">
                        <div class="row current-id">
                            <div class="col-10">
                                <input type="text" value="{{ session('tm_current_mail') }}" id="current-id" spellcheck="false">
                            </div>
                            <div class="col-2"><i class="fas fa-chevron-down"></i></div>
                        </div>
                        <div class="row all-ids">
                            <div class="col-10">
                                @foreach(session('tm_mails') as $item)
                                <a href="{{$item}}">{{ $item }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tm-nav {{ (env('ENABLE_COMPTACT_VIEW') ? 'tm-nav-mini' : '') }}">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="action-item copy snackbar" action="copy" msg="{{ __('app.snackbar.copy') }}">
                                    <span class="icon"><i class="far fa-copy"></i></span>
                                    <span class="text">{{ __('app.copy') }}</span>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="action-item refresh" action="refresh">
                                    <span class="icon"><i class="fas fa-sync-alt fa-spin"></i></span>
                                    <span class="text">{{ __('app.refresh') }}</span>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="action-item" id="btn-new">
                                    <span class="icon"><i class="fas fa-plus"></i></span>
                                    <span class="text">{{ __('app.new') }}</span>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="action-item" action="delete">
                                    <span class="icon"><i class="fas fa-trash-alt"></i></span>
                                    <span class="text">{{ __('app.delete') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="back">
                    <div class="tm-create">
                        <form method="POST" action="{{ route('MailIDCreateCustom') }}">
                            @csrf
                            <input type="text" name="email" placeholder="{{ __('app.enter') }}">
                            <input type="hidden" name="domain" value="{{ $domains[0] }}">
                            <div class="tm-domain-selector">
                                <div class="row current-id">
                                    <div class="col-10" id="selected-domain">{{ "@".$domains[0] }}</div>
                                    <div class="col-2"><i class="fas fa-chevron-down"></i></div>
                                </div>
                                <div class="row all-ids">
                                    <div class="col-10">
                                        @foreach($domains as $domain)
                                        <a class="domain-selector" href="#">{{ "@".$domain }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <input type="submit" action="Create" value="{{ __('app.create') }}">
                        </form>
                        <span>{{ __('app.or') }}</span>
                        <form method="POST" action="{{ route('MailIDCreateRandom') }}">
                            @csrf
                            <input type="submit" action="Random" value="{{ __('app.random') }}">
                        </form>
                        <div id="btn-cancel">{{ __('app.cancel') }}</div>
                    </div>
                </div>
            </div>
            <div class="tm-ads">
                {!! $AD_SPACE_1 !!}
            </div>
        </div>
        <div class="col-xl-3 tm-mailbox">
            <div class="row search">
                <div class="col-1 icon">
                    <i class="fas fa-search"></i>
                </div>
                <div class="col-10 input">
                    <input type="text" name="search" placeholder="{{ __('app.search') }}">
                </div>
            </div>
            <div id="mails"><p>{{ __('app.mailbox.loading') }}</p></div>
        </div>
        <div class="col-xl-6 tm-message">
            <span class="ad_space_2">{!! $AD_SPACE_2 !!}</span>
            <div id="tm-message">
                <span class="no-mails">
                    <img src="{{ asset('images/mails.png') }}">
                </span>
            </div>
            <span class="ad_space_3">{!! $AD_SPACE_3 !!}</span>
        </div>
        <button id="fetch" class="d-none">F</button>
        <div id="fetch-seconds" class="d-none">{{ env('TM_FETCH_SECONDS', 15) }}</div>
        <div id="notification-msgs" class="d-none">{{ json_encode(__('app.notification')) }}</div>
        <div id="mailbox-msgs" class="d-none">{{ json_encode(__('app.mailbox')) }}</div>
    </div>
</div>
@endsection  

@section('addonJS')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
$(window).on('load', function() {
    $("#fetch").click();
});
setInterval(function() {
    $(".refresh").click();
}, {{ intval(env('TM_FETCH_SECONDS', 10)) * 1000 }});
localStorage.setItem('notificationMsgs', $("#notification-msgs").html());
localStorage.setItem('mailboxMsgs', $("#mailbox-msgs").html());
</script>
@endsection