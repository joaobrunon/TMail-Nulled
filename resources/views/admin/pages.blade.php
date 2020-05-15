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
        <div class="row">
            <div class="col-md-12">
                <h3 class="page_title">Pages</h3>
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                        <tr>
                            <td>{{ $page->id }}</td>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->slug }}</td>
                            <td>
                                <a class="page-action" href="{{ route('AdminPageEdit') }}?id={{ $page->id }}">Edit</a>
                                <a class="page-action" href="{{ route('AdminPageDelete') }}?id={{ $page->id }}" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row hp-editor">
            <div class="col-md-12">
                <h3 class="page_title">Add New Page</h3>
                <form method="POST" id="pageForm" action="{{ route('AdminPageAdd') }}">
                    @csrf
                    <div class="page_title">
                        <label for="title">Page Title</label>
                        <input id="title" type="text" name="title" placeholder="Page Title" required>
                    </div>
                    <div class="page_slug">
                        <label for="title">Page Slug (ex. home, about)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">{{ env('APP_URL') }}/</span>
                            </div>
                            <input id="slug" type="text" name="slug" value="" placeholder="Page Slug" required>
                        </div>
                    </div>
                    <div class="page_content">
                        <label for="content">Page Content</label>
                        <div id="editor"></div>
                    </div>
                    <div class="page_custom_header">
                        <label for="custom_header">Page Custom Header</label>
                        <textarea id="custom_header" name="custom_header"></textarea>
                    </div>
                    <textarea id="content" name="content"></textarea>
                    <button class="blue-bg" type="button" id="btnSubmit">Submit</button>
                </form>
            </div>
        </div>
@endsection
