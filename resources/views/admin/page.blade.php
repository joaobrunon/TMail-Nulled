@extends('admin.layout')

@section('addonCSS')
<link href="{{ asset('css/admin.css?v='.env('APP_VERSION')) }}" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('addonJS')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });
</script>
<script>
$(document).ready(function() {
    document.getElementById("btnSubmit").addEventListener("click", function(){
        var changedContent = $("#editor > div").html();
        document.getElementById("content").innerHTML = changedContent;
        document.getElementById("pageForm").submit();
    });
});
</script>
@endsection

@section('content')
        <div class="row hp-editor">
            <div class="col-md-12">
                <div class="row">
                    <h3 class="col-md-9 page_title">Edit Page - #{{ $page->id }}</h3>
                    <a class="col-md-3 button-return" href="{{ route('AdminPages') }}">Return to All Pages</a>
                </div>
                <form method="POST" id="pageForm" action="{{ route('AdminPageEditSubmit') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $page->id }}">
                    <div class="page_title">
                        <label for="title">Page Title</label>
                        <input id="title" type="text" name="title" value="{{ $page->title }}" placeholder="Page Title" required>
                    </div>
                    <div class="page_slug">
                        <label for="title">Page Slug (ex. home, about)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">{{ env('APP_URL') }}/</span>
                            </div>
                            <input id="slug" type="text" name="slug" value="{{ $page->slug }}" placeholder="Page Slug" required>
                        </div>
                    </div>
                    <div class="page_content">
                        <label for="content">Page Content</label>
                        <div id="editor">{!! $page->content !!}</div>
                    </div>
                    <textarea id="content" name="content"></textarea>
                    <div class="page_custom_header">
                        <label for="custom_header">Page Custom Header</label>
                        <textarea id="custom_header" name="custom_header">{!! $page->custom_header !!}</textarea>
                    </div>
                    <button class="blue-bg" type="button" id="btnSubmit">Submit</button>
                </form>
            </div>
        </div>
@endsection
