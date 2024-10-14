        @extends('layouts.master')
        @section('css')
            <!-- Internal Nice-select css  -->
            <link href="{{ URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet" />
        @section('title')
            تعديل مستخدم - مورا سوفت للادارة القانونية
        @stop


    @endsection
    @section('page-header')
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                        تعديل
                        مستخدم</span>
                </div>
            </div>
        </div>
        <!-- breadcrumb -->
    @endsection
    @section('content')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('Role.update', $role->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="role_name">Role name</label>
                <input type="text" name="role_name" class="form-control" id="role_name" placeholder="Role name..."
                    value="{{ $role->name }}" required>
            </div>
            <div class="form-group">
                <label for="role_slug">Role Slug</label>
                <input type="text" name="role_slug" tag="role_slug" class="form-control" id="role_slug"
                    placeholder="Role Slug..." value="{{ $role->slug }}" required>
            </div>
            <div class="form-group">
                <label for="roles_permissions">Add Permissions</label>
                <input type="text" data-role="tagsinput" name="roles_permissions" class="form-control"
                    id="roles_permissions"
                    value="@foreach ($role->permissions as $permission)
                {{ $permission->name . ',' }} @endforeach">
            </div>
            <div id="permissions_box">
                <label for="roles">Select Permissions</label>
                <div id="permissions_ckeckbox_list">
                </div>
            </div>

           
            

            <div class="form-group pt-2">
                <input class="btn btn-primary" type="submit" value="Submit">
            </div>
        </form>

        @section('js_role_page')
            <script src="/js/admin/bootstrap-tagsinput.js"></script>

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
            <script>
                $(document).ready(function() {
                    var permissions_box = $('#permissions_box');
                    var permissions_ckeckbox_list = $('#permissions_ckeckbox_list');
                    var user_permissions_box = $('#user_permissions_box');
                    var user_permissions_ckeckbox_list = $('#user_permissions_ckeckbox_list');

                    permissions_box.show(); // hide all boxes


                    $('#role').on('change', function() {
                        console.log('#role');
                        var role = $(this).find(':selected');
                        var role_id = role.data('role-id');
                        var role_slug = role.data('role-slug');

                        permissions_ckeckbox_list.empty();
                        user_permissions_box.empty();

                        $.ajax({
                            url: "{{ URL::to('role') }}/create/",
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
    @endsection
