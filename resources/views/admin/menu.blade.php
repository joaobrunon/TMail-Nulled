@extends('admin.layout')

@section('addonCSS')
<link href="{{ asset('css/admin.css') }}?v={{ env('APP_VERSION') }}" rel="stylesheet">

@endsection

@section('addonJS')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8" defer></script>
<script src="{{ asset('js/admin/menu.js') }}?v={{ env('APP_VERSION') }}" defer></script>
@endsection

@section('content')
<div class="row manage-menu">
    <div class="col-md-12">
        <div class="description_box_title">
            <h3>Manage Menu</h3>
        </div>
    </div>
    <div class="col-md-6">
        <ul id="menu-structure" class="menu-list">
             @foreach($menu as $item)
                  @if($item->status)
                    <li id="{{ ++$id }}" data-link="{{ $item->link }}" data-name="{{ $item->name }}" data-type="{{ $item->type }}">
                        {{ $item->name }}
                        <span data-id="{{ $id }}" class="delete"><i class="far fa-trash-alt"></i></span>
                        <span data-id="{{ $id }}" class="edit"><i class="far fa-edit"></i></span>
                    </li>
                @endif
            @endforeach
        </ul>
     </div>
    <div class="col-md-6">
        <ul id="available-menu-items" class="menu-list"> 
            @foreach($menu as $item)
                @if(!$item->status)
                    <li id="{{ ++$id }}" data-link="{{ $item->link }}" data-name="{{ $item->name }}" data-type="{{ $item->type }}">
                        {{ $item->name }}
                        <span data-id="{{ $id }}" class="delete"><i class="far fa-trash-alt"></i></span>
                        <span data-id="{{ $id }}" class="edit"><i class="far fa-edit"></i></span>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>     
    <div class="col-md-12">
        <div class="menu-updater menu-form">
            <form name="menu-updater" id="menu-updater">
                <input type="text" name="name" placeholder="Name">
                <input type="text" name="link" placeholder="Link">
                <label for="new_tab_update">
                    <input type="checkbox" id="new_tab_update" name="new_tab" value="true"/> <span>Open in New Tab</span>
                </label>
                <input type="hidden" name="id"><br>
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" action="update" value="update">Update</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" action="cancel" value="cancel">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div> 
    <div class="col-md-12 hp-editor menu-form">
        <button type="button" id="save-menu-structure" class="blue-purple-bg">Save</button>
    </div>   
</div>
<div class="row add-new-menu-item menu-form">
    <div class="col-md-12">
        <div class="description_box_title">
            <h3>Add New Menu Item</h3>
        </div>
        <form name="menu-adder" id="menu-adder">
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="link" placeholder="Link">
            <label for="new_tab_add">
                <input type="checkbox" id="new_tab_add" name="new_tab" value="true"/> <span>Open in New Tab</span>
            </label>
            <button type="button" value="add">Add</button>
        </form>
    </div>
</div>
    <div class="d-none" id="next-id">{{ $id + 1 }}</div>
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
@endsection
