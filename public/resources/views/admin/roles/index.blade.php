@extends('layouts.admin')
@section('page-title','Roles')
@section('css')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 text-right">

                        <button type="button" class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#addRoleModal">
                          Add Role
                        </button>

                    </div>
                <div class="row" style="clear: both;margin-top: 18px;">
                    <div class="col-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr id="role_{{$role->id}}">
                                    <td>{{ $role->id  }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @can('update',$role)
                                        <a data-id="{{$role->id}}" onclick="editRole(event.target)" class="btn btn-info">Edit</a>
                                        @endcan
                                        @can('delete',$role)
                                        <a data-id="{{$role->id}}" class="btn btn-danger" onclick="deleteRole({{$role->id}})">Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

        <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Role</h5>
                    </div>
                    <div class="modal-body"  style="height: 150px; overflow: auto">
                        <form id="delete_form" style="height: 400px">
                            <div class="form-group">
                                <label for="name" class="col-sm-2">Add Role</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name" >
                                    <span id="roleError" class="alert-message"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2">Permissions</label>
                                <div class="col-sm-12">
                                     @foreach(config('permissions') as $code =>$label)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="permission" name="permission" value="{{$code}}"  >
                                            <label class="form-check-label">
                                                {{$label}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="addRole()">Send </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="editRoleModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Role</h4>
                    </div>
                    <div class="modal-body"  style="height: 150px; overflow: auto">
                        <form id="edit_form" style="height: 400px">
                        <input type="hidden" name="role_id" id="role_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Role</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="edit_role" name="name"  >
                                <span id="taskError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2">Permissions</label>
                            <div class="col-sm-12">
                                @foreach(config('permissions') as $code =>$label)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"  name="permission" value="{{$code}}"
                                        @if($permission == $code) checked @endIf>
                                        <label class="form-check-label" >
                                            {{$label}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="updateRole()">Save</button>
                    </div>
                </div>
            </div>
@endsection
@section('js')
            <script>
                function addRole() {
                    let permission =[];
                    $("input:checkbox[name=permission]:checked").each(function(){
                        permission.push($(this).val());
                    });
                    let  permissions= JSON.stringify(permission);
                    let name = $('#name').val();
                    let _url     ="{{ route('roles.store')}}";
                    let _token   = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: _url,
                        type: "POST",
                        data: {
                            name: name,
                            permissions:permissions,
                            _token: _token
                        },
                        success: function(data) {
                            role = data;
                            console.log(data);
                            Swal.fire({
                                icon: 'success',
                                title: 'Done...',
                                text: 'Role Added successfully' ,
                            })
                            $('table tbody').append(`
                            <tr id="role_${role.id}">
                                <td>${role.id}</td>
                                <td>${ role.name }</td>
                                <td>
                                    <a data-id="${role.id}" onclick="editRole(${role.id})" class="btn btn-info">Edit</a>
                                    <a data-id="${role.id}" class="btn btn-danger" onclick="deleteRole(${role.id})">Delete</a>
                                </td>
                            </tr>
                            `);
                           document.getElementById('delete_form').reset()
                            $('#addRoleModal').modal('hide');
                        },
                        error: function(response) {
                            console.log(response);
                            Swal.fire({
                                icon: 'error',
                                title: 'OPs...',
                                text: response.responseText ,
                            });
                        }
                    });
                }
                function deleteRole(id) {

                    let url =`{{url('/Admin/roles')}}/${id}`;
                    let token   = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: token
                        },
                        success: function(response) {
                            $("#role_"+id).remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Done...',
                                text: 'Role '+ response.name +' Deleted successfully' ,
                            })
                        }
                    });
                }
                function editRole(e) {
                    let id  = $(e).data("id");
                    let role  = $("#role_"+id+" td:nth-child(2)").html();
                    $("#role_id").val(id);
                    $("#edit_role").val(role);
                    $('#editRoleModal').modal('show');
                }

                function updateRole() {
                    let permission =[];
                    $("input:checkbox[name=permission]:checked").each(function(){
                        permission.push($(this).val());
                    });
                   let  permissions= JSON.stringify(permission);
                    console.log(permissions);
                    let name = $('#edit_role').val();
                    let id = $('#role_id').val();
                    let _url     = `{{url('/Admin/roles')}}/${id}`;
                    let _token   = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: _url,
                        type: "PUT",
                        data: {
                            name: name,
                            permissions:permissions,
                            _token: _token
                        },
                        success: function(data) {
                            role = data
                            $("#role_"+id+" td:nth-child(2)").html(role.name);
                            document.getElementById('edit_form').reset()
                            $('#editRoleModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Done...',
                                text: 'Role Updated successfully' ,
                            })
                        },
                        error: function(response) {
                           // let error=JSON.stringify( response.responseText);
                            console.log(response.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'OPs...',
                                text:response.responseText,
                            })
                        }
                    });
                }


            </script>
@endsection
