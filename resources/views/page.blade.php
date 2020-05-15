@extends('layout')

@section('custom_header')
{!! $page_custom_header  !!}
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-3 tm-sidebar">
            <div class="tm-ads">
                {!! isset($AD_SPACE_5) ? $AD_SPACE_5 : '' !!}
            </div>
            <div class="tm-create {{ (session('tm_current_mail')) ? 'show-button' : ''  }}">
                @if(session('tm_current_mail'))
                <a href="{{ route('App') }}" class="btn-backtoapp"><i class="fas fa-angle-double-left"></i>{{ __('app.goback') }}</a>
                @endif
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
            </div>
            <div class="tm-ads">
                {!! $AD_SPACE_1 !!}
            </div>
        </div>
        <div class="col-xl-9 tm-content">
            {!! $AD_SPACE_2 !!}
            <h3 class="page_title">{{ $page_title }}</h3>
            <p class="page_content">{!! $page_content  !!}</p>
            {!! $AD_SPACE_3 !!}
        </div>
    </div>
</div>
@endsection         
