@extends('layouts.master')
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{ URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
@section('title')
    اضافة مستخدم - مورا سوفت للادارة القانونية
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                مستخدم</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">


    <div class="col-lg-12 col-md-12">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}">رجوع</a>
                    </div>
                </div><br>
                <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                    action="{{ route('users.store', 'test') }}" method="post">
                    {{ csrf_field() }}

                    <div class="">

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label for="name">User name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Name..." value="{{ old('name') }}" required>
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="Email..." value="{{ old('email') }}">
                            </div>
                        </div>

                    </div>

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Password..." required minlength="8">
                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label for="password_confirmation">Password Confirm</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Password..." id="password_confirmation">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role">Select Role</label>
                        <select class="role form-control" name="role" id="role">
                            <option value="">Select Role...</option>
                            @foreach ($roles as $role)
                                <option data-role-id="{{ $role->id }}" data-role-slug="{{ $role->slug }}"
                                    value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="premissions_box">
                        <label for="roles">Select Permissions</label>
                        <div id="permissions_ckeckbox_list">

                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-main-primary pd-x-20" type="submit">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')


<!-- Internal Nice-select js-->
<script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js') }}"></script>

<!--Internal  Parsley.min js -->
<script src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
<!-- Internal Form-validation js -->
<script src="{{ URL::asset('assets/js/form-validation.js') }}"></script>
<script>
    $(document).ready(function() {
        var permissions_box = $('#permissions_box');
        var permissions_ckeckbox_list = $('#permissions_ckeckbox_list');

        permissions_box.hide(); // hide all boxes


        $('#role').on('change', function() {
            var role = $(this).find(':selected');
            var role_id = role.data('role-id');
            var role_slug = role.data('role-slug');

            permissions_ckeckbox_list.empty();

            $.ajax({
                url: "{{ URL::to('users') }}/create/",
                method: 'get',
                dataType: 'json',
                data: {
                    role_id: role_id,
                    role_slug: role_slug,
                }
            }).done(function(data) {

                console.log(data);

                permissions_box.show();
                // permissions_ckeckbox_list.empty();

                $.each(data, function(index, element) {
                    $(permissions_ckeckbox_list).append(
                        '<div class="custom-control custom-checkbox">' +
                        '<input class="custom-control-input" type="checkbox" name="permissions[]" id="' +
                        element.slug + '" value="' + element.id + '">' +
                        '<label class="custom-control-label" for="' + element.slug +
                        '">' + element.name + '</label>' +
                        '</div>'
                    );

                });
            });
        });
    });
</script>
@endsection
