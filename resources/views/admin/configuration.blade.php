@extends('admin.layout')

@section('addonCSS')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
<style>
ul.nav a {
    color: #405cff;
    font-size: 16px;
}
input, select, textarea {
    box-shadow: none !important;
}
small {
    margin-top: -6px;
    margin-bottom: 6px;
    display: block;
}
.addIcons {
    font-size: 36px;
    cursor: pointer;
}
.domains {
    margin-top: 5px;
}
.domains input {
    width: 100%;
    margin-top: 5px;
}
.delete_after_key {
    width: 69.72%;
    display: inline;
}
.delete_after_value {
    width: 30%;
    display: inline;
    text-align: right;
    padding-right: 20px;
}
</style>
@endsection

@section('addonJS')
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="{{ asset('js/admin/scripts.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection

@section('content')
<h3 class="page_title">{{ $page_title }}</h3>

<form method="POST" action="{{ route('AdminConfigurationSubmit') }}" enctype="multipart/form-data">
    @csrf
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#general">General</a></li>
        <li><a data-toggle="tab" href="#database">Database</a></li>
        <li><a data-toggle="tab" href="#imap">IMAP</a></li>
        <li><a data-toggle="tab" href="#customization">Customization</a></li>
        <li><a data-toggle="tab" href="#advance">Advance</a></li>
    </ul>
    <br>
    <div class="tab-content">
        <div id="general" class="tab-pane fade in active">
            <div class="form-group">
                <label for="logo" class="col-form-label">Logo</label>
                <div class="field">
                    <input type="file" id="logo" class="{{ $errors->has("logo") ? ' is-invalid' : '' }}" name="logo">
                    @if ($errors->has("logo"))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("logo") }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="APP_NAME" class="col-form-label">App Name (Website Title)</label>
                <div class="field">
                    <input id="APP_NAME" type="text" class="form-control{{ $errors->has('APP_NAME') ? ' is-invalid' : '' }}" name="APP_NAME" value="{{ $env['APP_NAME'] }}">
                    @if ($errors->has('APP_NAME'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('APP_NAME') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="APP_URL" class="col-form-label">App URL</label>
                <div class="field">
                    <input id="APP_URL" type="text" class="form-control{{ $errors->has('APP_URL') ? ' is-invalid' : '' }}" name="APP_URL" value="{{ $env['APP_URL'] }}">
                    @if ($errors->has('APP_URL'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('APP_URL') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="TM_DOMAINS" class="col-form-label">Domains</label>
                <div class="field">
                    @foreach( explode(',', env("TM_DOMAINS")) as $domain )
                    <div class="domains">
                        <input id="domain" type="text" name="domain[]" placeholder="Enter Domain" value="{{ $domain }}">
                    </div>
                    @endforeach
                    <div class="addIcons" id="addDomain">+</div>
                    @if ($errors->has("TM_DOMAINS"))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("TM_DOMAINS") }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="TM_HOMEPAGE" class="col-form-label">Select Home Page</label>
                <div class="field">
                    <select id="TM_HOMEPAGE" class="form-control{{ $errors->has("TM_HOMEPAGE") ? ' is-invalid' : '' }}" name="TM_HOMEPAGE">
                        <option value="mailbox" {{ ($env["TM_HOMEPAGE"] == 'mailbox') ? 'selected' : '' }}>App (Auto Generate ID)</option>
                        @foreach($pages as $page)
                        <option value="{{ $page->slug }}" {{ ($env["TM_HOMEPAGE"] == $page->slug) ? 'selected' : '' }}>{{ $page->title }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has("TM_HOMEPAGE"))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("TM_HOMEPAGE") }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="APP_TIMEZONE" class="col-form-label">Timezone</label>
                <br><small><a href="https://www.w3schools.com/php/php_ref_timezones.asp" target="_blank">List of Timezones</a></small>
                <div class="field">
                    <input id="APP_TIMEZONE" type="text" class="form-control{{ $errors->has('APP_TIMEZONE') ? ' is-invalid' : '' }}" name="APP_TIMEZONE" value="{{ $env['APP_TIMEZONE'] }}">
                    @if ($errors->has('APP_TIMEZONE'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('APP_TIMEZONE') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="AD_SPACE_1" class="col-form-label">AD Space 1 (Sidebar Ads)</label>
                <div class="field">
                    <textarea id="AD_SPACE_1" type="text" class="form-control{{ $errors->has("AD_SPACE_1") ? ' is-invalid' : '' }}" name="{{ "AD_SPACE_1" }}">{{ $env["AD_SPACE_1"] }}</textarea>
                    @if ($errors->has("AD_SPACE_1"))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("AD_SPACE_1") }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="AD_SPACE_2" class="col-form-label">AD Space 2 (Top Content/App Ads)</label>
                <div class="field">
                    <textarea id="AD_SPACE_2" type="text" class="form-control{{ $errors->has("AD_SPACE_2") ? ' is-invalid' : '' }}" name="{{ "AD_SPACE_2" }}">{{ $env["AD_SPACE_2"] }}</textarea>
                    @if ($errors->has("AD_SPACE_2"))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("AD_SPACE_2") }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="AD_SPACE_3" class="col-form-label">AD Space 3 (Bottom Content/App Ads)</label>
                <div class="field">
                    <textarea id="AD_SPACE_3" type="text" class="form-control{{ $errors->has("AD_SPACE_3") ? ' is-invalid' : '' }}" name="{{ "AD_SPACE_3" }}">{{ $env["AD_SPACE_3"] }}</textarea>
                    @if ($errors->has("AD_SPACE_3"))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("AD_SPACE_3") }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="AD_SPACE_4" class="col-form-label">AD Space 4 (Mails inBetween Ads)</label>
                <div class="field">
                    <textarea id="AD_SPACE_4" type="text" class="form-control{{ $errors->has("AD_SPACE_4") ? ' is-invalid' : '' }}" name="{{ "AD_SPACE_4" }}">{{ $env["AD_SPACE_4"] }}</textarea>
                    @if ($errors->has("AD_SPACE_4"))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("AD_SPACE_4") }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="AD_SPACE_5" class="col-form-label">AD Space 5 (Between Logo and Create/Actions Box)</label>
                <div class="field">
                    <textarea id="AD_SPACE_5" type="text" class="form-control{{ $errors->has("AD_SPACE_5") ? ' is-invalid' : '' }}" name="{{ "AD_SPACE_5" }}">{{ isset($env["AD_SPACE_5"]) ? $env["AD_SPACE_5"] : '' }}</textarea>
                    @if ($errors->has("AD_SPACE_5"))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("AD_SPACE_5") }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="FACEBOOK_URL" class="col-form-label">Facebook Link</label>
                <div class="field">
                    <input id="FACEBOOK_URL" type="text" class="form-control{{ $errors->has('FACEBOOK_URL') ? ' is-invalid' : '' }}" name="FACEBOOK_URL" value="{{ $env['FACEBOOK_URL'] }}">
                    @if ($errors->has('FACEBOOK_URL'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('FACEBOOK_URL') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="TWITTER_URL" class="col-form-label">Twitter Link</label>
                <div class="field">
                    <input id="TWITTER_URL" type="text" class="form-control{{ $errors->has('TWITTER_URL') ? ' is-invalid' : '' }}" name="TWITTER_URL" value="{{ $env['TWITTER_URL'] }}">
                    @if ($errors->has('TWITTER_URL'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('TWITTER_URL') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="YOUTUBE_URL" class="col-form-label">YouTube Link</label>
                <div class="field">
                    <input id="YOUTUBE_URL" type="text" class="form-control{{ $errors->has('YOUTUBE_URL') ? ' is-invalid' : '' }}" name="YOUTUBE_URL" value="{{ $env['YOUTUBE_URL'] }}">
                    @if ($errors->has('YOUTUBE_URL'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('YOUTUBE_URL') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div id="database" class="tab-pane fade">
            <div class="form-group">
                <label for="DB_HOST" class="col-form-label">Database Hostname</label>
                <div class="field">
                    <input id="DB_HOST" type="text" class="form-control{{ $errors->has('DB_HOST') ? ' is-invalid' : '' }}" name="DB_HOST" value="{{ $env['DB_HOST'] }}">
                    @if ($errors->has('DB_HOST'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('DB_HOST') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="DB_PORT" class="col-form-label">Database Port</label>
                <div class="field">
                    <input id="DB_PORT" type="text" class="form-control{{ $errors->has('DB_PORT') ? ' is-invalid' : '' }}" name="DB_PORT" value="{{ $env['DB_PORT'] }}">
                    @if ($errors->has('DB_PORT'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('DB_PORT') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="DB_DATABASE" class="col-form-label">Database Name</label>
                <div class="field">
                    <input id="DB_DATABASE" type="text" class="form-control{{ $errors->has('DB_DATABASE') ? ' is-invalid' : '' }}" name="DB_DATABASE" value="{{ $env['DB_DATABASE'] }}">
                    @if ($errors->has('DB_DATABASE'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('DB_DATABASE') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="DB_USERNAME" class="col-form-label">Database Username</label>
                <div class="field">
                    <input id="DB_USERNAME" type="text" class="form-control{{ $errors->has('DB_USERNAME') ? ' is-invalid' : '' }}" name="DB_USERNAME" value="{{ $env['DB_USERNAME'] }}">
                    @if ($errors->has('DB_USERNAME'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('DB_USERNAME') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="DB_PASSWORD" class="col-form-label">Database Password</label>
                <div class="field">
                    <input id="DB_PASSWORD" type="text" class="form-control{{ $errors->has('DB_PASSWORD') ? ' is-invalid' : '' }}" name="DB_PASSWORD" value="{{ $env['DB_PASSWORD'] }}">
                    @if ($errors->has('DB_PASSWORD'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('DB_PASSWORD') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div id="imap" class="tab-pane fade">
            <div class="form-group">
                <label for="IMAP_HOST" class="col-form-label">IMAP Hostname</label>
                <div class="field">
                    <input id="IMAP_HOST" type="text" class="form-control{{ $errors->has('IMAP_HOST') ? ' is-invalid' : '' }}" name="IMAP_HOST" value="{{ $env['IMAP_HOST'] }}">
                    @if ($errors->has('IMAP_HOST'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('IMAP_HOST') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="IMAP_PORT" class="col-form-label">IMAP Port</label>
                <div class="field">
                    <input id="IMAP_PORT" type="text" class="form-control{{ $errors->has('IMAP_PORT') ? ' is-invalid' : '' }}" name="IMAP_PORT" value="{{ $env['IMAP_PORT'] }}">
                    @if ($errors->has('IMAP_PORT'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('IMAP_PORT') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="IMAP_ENCRYPTION" class="col-form-label">IMAP Encryption (SSL or TSL)</label>
                <div class="field">
                    <input id="IMAP_ENCRYPTION" type="text" class="form-control{{ $errors->has('IMAP_ENCRYPTION') ? ' is-invalid' : '' }}" name="IMAP_ENCRYPTION" value="{{ $env['IMAP_ENCRYPTION'] }}">
                    @if ($errors->has('IMAP_ENCRYPTION'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('IMAP_ENCRYPTION') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="IMAP_VALIDATE_CERT" class="col-form-label">IMAP Validate Certificate</label>
                <div class="field">
                    <select id="IMAP_VALIDATE_CERT" class="form-control{{ $errors->has("IMAP_VALIDATE_CERT") ? ' is-invalid' : '' }}" name="IMAP_VALIDATE_CERT">
                        <option value="true" {{ $env['IMAP_VALIDATE_CERT'] ? 'selected' : '' }}>Yes</option>
                        <option value="false" {{ $env['IMAP_VALIDATE_CERT'] ? '' : 'selected' }}>No</option>
                    </select>
                    @if ($errors->has('IMAP_VALIDATE_CERT'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('IMAP_VALIDATE_CERT') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="IMAP_USERNAME" class="col-form-label">IMAP Username</label>
                <div class="field">
                    <input id="IMAP_USERNAME" type="text" class="form-control{{ $errors->has('IMAP_USERNAME') ? ' is-invalid' : '' }}" name="IMAP_USERNAME" value="{{ $env['IMAP_USERNAME'] }}">
                    @if ($errors->has('IMAP_USERNAME'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('IMAP_USERNAME') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="IMAP_PASSWORD" class="col-form-label">IMAP Password</label>
                <div class="field">
                    <input id="IMAP_PASSWORD" type="text" class="form-control{{ $errors->has('IMAP_PASSWORD') ? ' is-invalid' : '' }}" name="IMAP_PASSWORD" value="{{ $env['IMAP_PASSWORD'] }}">
                    @if ($errors->has('IMAP_PASSWORD'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('IMAP_PASSWORD') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div id="customization" class="tab-pane fade">
            <div class="form-group">
                <label for="TM_COLOR_PRIMARY" class="col-form-label">Primary Colour</label>
                <div class="field">
                    <input id="TM_COLOR_PRIMARY" type="color" class="form-control{{ $errors->has('TM_COLOR_PRIMARY') ? ' is-invalid' : '' }}" name="TM_COLOR_PRIMARY" value="{{ $env['TM_COLOR_PRIMARY'] }}">
                    @if ($errors->has('TM_COLOR_PRIMARY'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('TM_COLOR_PRIMARY') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="TM_COLOR_SECONDARY" class="col-form-label">Secondary Colour</label>
                <div class="field">
                    <input id="TM_COLOR_SECONDARY" type="color" class="form-control{{ $errors->has('TM_COLOR_SECONDARY') ? ' is-invalid' : '' }}" name="TM_COLOR_SECONDARY" value="{{ $env['TM_COLOR_SECONDARY'] }}">
                    @if ($errors->has('TM_COLOR_SECONDARY'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('TM_COLOR_SECONDARY') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="TM_COLOR_TERTIARY" class="col-form-label">Tertiary Colour</label>
                <div class="field">
                    <input id="TM_COLOR_TERTIARY" type="color" class="form-control{{ $errors->has('TM_COLOR_TERTIARY') ? ' is-invalid' : '' }}" name="TM_COLOR_TERTIARY" value="{{ $env['TM_COLOR_TERTIARY'] }}">
                    @if ($errors->has('TM_COLOR_TERTIARY'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('TM_COLOR_TERTIARY') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="CUSTOM_CSS" class="col-form-label">Custom CSS</label>
                <div class="field">
                    <textarea id="CUSTOM_CSS" type="text" class="form-control{{ $errors->has('CUSTOM_CSS') ? ' is-invalid' : '' }} custom_code" name="CUSTOM_CSS">{{ $env['CUSTOM_CSS'] }}</textarea>
                    @if ($errors->has('CUSTOM_CSS'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('CUSTOM_CSS') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="CUSTOM_JS" class="col-form-label">Custom JS</label>
                <div class="field">
                    <textarea id="CUSTOM_JS" type="text" class="form-control{{ $errors->has('CUSTOM_JS') ? ' is-invalid' : '' }} custom_code" name="CUSTOM_JS">{{ $env['CUSTOM_JS'] }}</textarea>
                    @if ($errors->has('CUSTOM_JS'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('CUSTOM_JS') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="CUSTOM_HEADER" class="col-form-label">Custom Header</label>
                <div class="field">
                    <textarea id="CUSTOM_HEADER" type="text" class="form-control{{ $errors->has('CUSTOM_HEADER') ? ' is-invalid' : '' }} custom_code" name="CUSTOM_HEADER">{{ $env['CUSTOM_HEADER'] }}</textarea>
                    @if ($errors->has('CUSTOM_HEADER'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('CUSTOM_HEADER') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div id="advance" class="tab-pane fade">
            @foreach($env as $key => $value)
                @if($key == "APP_FORCE_HTTPS")
                <div class="form-group">
                    <label for="{{$key}}" class="col-form-label">Force SSL?</label>
                    <div class="field">
                        <select id="{{$key}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" name="{{$key}}">
                            <option value="true" {{ $value ? 'selected' : '' }}>Yes</option>
                            <option value="false" {{ $value ? '' : 'selected' }}>No</option>
                        </select>
                        @if ($errors->has($key))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first($key) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                @elseif($key == "DELETE_AFTER_KEY")
                <div class="form-group">
                    <label for="{{$key}}" class="col-form-label">Delete After</label>
                    <div class="field">
                        <input id="DELETE_AFTER_VALUE" type="text" class="form-control{{ $errors->has('DELETE_AFTER_VALUE') ? ' is-invalid' : '' }} delete_after_value" name="DELETE_AFTER_VALUE" value="{{ $env['DELETE_AFTER_VALUE'] }}">
                        <select id="{{$key}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }} delete_after_key" name="{{$key}}">
                            <option value="d" {{ ($value == "d") ? 'selected' : '' }}>Days</option>
                            <option value="m" {{ ($value == "m") ? 'selected' : '' }}>Months</option>
                        </select>
                        @if ($errors->has($key))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first($key) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                @elseif($key == "API_KEY")
                <div class="form-group">
                    <label for="{{$key}}" class="col-form-label">API Key(s)</label>
                    <div class="field">
                        @foreach( explode(',', $value) as $api )
                        @if($api)
                        <div class="domains">
                            <input id="api" type="text" name="api[]" placeholder="Enter API Key" value="{{ $api }}">
                        </div>
                        @endif
                        @endforeach
                        <div class="addIcons" id="addAPI">+</div>
                        @if ($errors->has($key))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first($key) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                @elseif($key == "FORBIDDEN_IDS")
                <div class="form-group">
                    <label for="{{$key}}" class="col-form-label">Forbidden ID(s)</label>
                    <div class="field">
                        @foreach( explode(',', $value) as $ids )
                        <div class="domains">
                            <input id="ids" type="text" name="forbidden[]" placeholder="Enter Forbidden ID (without domain)" value="{{ $ids }}">
                        </div>
                        @endforeach
                        <div class="addIcons" id="addForbidden">+</div>
                        @if ($errors->has($key))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first($key) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                @elseif($key == 'CC_CHECK')
                <div class="form-group">
                    <label for="{{$key}}" class="col-form-label">Enable Check for CC Field?</label>
                    <div class="field">
                        <select id="{{$key}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" name="{{$key}}">
                            <option value="true" {{ $value ? 'selected' : '' }}>Yes</option>
                            <option value="false" {{ $value ? '' : 'selected' }}>No</option>
                        </select>
                        @if ($errors->has($key))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first($key) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                @elseif($key == "DEFAULT_LANGUAGE") 
                <div class="form-group">
                    <label for="{{$key}}" class="col-form-label">Select Language</label>
                    <div class="field">
                        <select id="{{$key}}" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" name="{{$key}}">
                            @foreach(config('app.locales') as $locale)
                            <option value="{{ $locale }}" {{ ($value == $locale) ? 'selected' : '' }}>{{ $locale }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has($key))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first($key) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                @elseif($key == "CRON_PASSWORD") 
                <div class="form-group">
                    <label for="{{$key}}" class="col-form-label">{{ ucwords(strtolower(str_replace("_"," ",str_replace("TM_"," ",$key)))) }}</label>
                    <div class="field">
                        <input id="{{$key}}" type="text" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" name="{{ $key }}" value="{{ $value }}">
                        @if ($errors->has($key))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first($key) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                @elseif($key == "TM_FETCH_SECONDS") 
                <div class="form-group">
                    <label for="{{$key}}" class="col-form-label">{{ ucwords(strtolower(str_replace("_"," ",str_replace("TM_"," ",$key)))) }}</label>
                    <div class="field">
                        <input id="{{$key}}" type="text" class="form-control{{ $errors->has($key) ? ' is-invalid' : '' }}" name="{{ $key }}" value="{{ $value }}">
                        @if ($errors->has($key))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first($key) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-12 hp-editor menu-form">
            <button class="blue-bg" type="submit">Save</button>
        </div>
    </div>
</form>
@endsection    
