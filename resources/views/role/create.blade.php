@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/bootstrap-tagsinput.css') }}" rel="stylesheet" />
@section('title')
    اضافة الصلاحيات - مورا سوفت للادارة القانونية
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                نوع مستخدم</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>خطا</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif




<form method="POST" action="{{ route('Role.store') }}">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="role_name">Role name</label>
        <input type="text" name="role_name" class="form-control" id="role_name" placeholder="Role name..."
            value="{{ old('role_name') }}" required>
    </div>
    <div class="form-group">
        <label for="role_slug">Role Slug</label>
        <input type="text" name="role_slug" tag="role_slug" class="form-control" id="role_slug"
            placeholder="Role Slug..." value="{{ old('role_slug') }}" required>
    </div>
    <div class="form-group">
        <label for="roles_permissions">Add Permissions</label>
        <input type="text" data-role="tagsinput" name="roles_permissions" class="form-control" id="roles_permissions"
            value="{{ old('roles_permissions') }}">
    </div>
    <div class="form-group pt-2">
        <input class="btn btn-primary" type="submit" value="Submit">
    </div>
</form>

@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-tagsinput.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#role_name').keyup(function(e) {
            var str = $('#role_name').val();
            str = str.replace(/\W+(?!$)/g, '-').toLowerCase(); //rplace stapces with dash
            $('#role_slug').val(str);
            $('#role_slug').attr('placeholder', str);
        });
    });
</script>
@endsection
