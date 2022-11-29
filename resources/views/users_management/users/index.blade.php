@extends('layouts.template')
@section('style')
<style>
    th[role=columnheader]:not(.no-sort) {
        cursor: pointer;
    }

    th[role=columnheader]:not(.no-sort):after {
        content: '';
        float: right;
        margin-top: 7px;
        border-width: 0 4px 4px;
        border-style: solid;
        border-color: #404040 transparent;
        visibility: hidden;
        opacity: 0;
        -ms-user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    th[aria-sort=ascending]:not(.no-sort):after {
        border-bottom: none;
        border-width: 4px 4px 0;
    }

    th[aria-sort]:not(.no-sort):after {
        visibility: visible;
        opacity: 0.4;
    }

    th[role=columnheader]:not(.no-sort):hover:after {
        visibility: visible;
        opacity: 1;
    }

    .card_title_text {
        font-style: normal;
        font-weight: 700;
        font-size: 19px;
        line-height: 24px;
        letter-spacing: 0.4px;
        color: #252733;
        margin-bottom: 0 !important;
    }

    .table_action {
        margin-left: 10px;
    }

    #table_list_user thead tr th:nth-child(2) {
        width: 20%;
        text-align: center;
    }

    /* #table_list_user thead tr th:first-child {
        width: 80%;
    } */

    #table_list_user tbody tr td:nth-child(2) {
        /* width: 20%; */
        text-align: center;
    }

    .detail_icon {
        display: flex;
        align-items: center;
    }

    .header_group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .detail-body {
        padding: 20px;
        margin-top: 20px;
    }

    .status_user {
        width: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        padding: 5px;
        background: #29CC97;
    }

    .status_user_text {
        margin-bottom: 0 !important;
        color: #fff;
        font-size: 12px;
    }

    .status_green {
        background: #29CC97;
    }

    .status_red {
        background: #FEC400;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="header_group">
                    <p class="card_title_text mb-0">User List</p>
                    <button class="btn btn-primary" onclick="add()">Add User</button>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Branch</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @php
                                $branch = '';
                                $role = '';
                                if ($user->branches == null) {
                                    $branch = 'HO';
                                } else {
                                    $branch = $user->branches->branch->name;
                                }
                                if ($user->roles == null) {
                                    $role = '-';
                                } else {
                                    $role = $user->roles->nama;
                                }
                            @endphp
                            <tr>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->username }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    {{ $branch }}
                                </td>
                                <td>
                                    {{ $role }}
                                </td>
                                <td>
                                    <div class="status_user {{ $user->deleted_at == null ? 'status_green' : 'status_red' }}">
                                        <p class="status_user_text">
                                            {{ $user->deleted_at == null ? 'Active' : 'Nonactive' }}
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <div id="detail_icon text-success">
                                        <button class="table_action btn" onclick="detail({{ $user->id }})">
                                            <i class="fa fa-eye text-success fa-1x"></i>
                                        </button>
                                        <button  class="table_action btn" onclick="edit({{ $user->id }})">
                                            <i class="fa fa-pencil-square-o text-primary"></i>
                                        </button>
                                        <button  class="table_action btn" onclick="deleteData({{ $user->id }})">
                                            <i class="fa fa-trash text-danger"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    {!! $users->withQueryString()->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal edit --}}
<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalUserLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUserLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="edit-body">
            <form action="" class="form-user">
                <div class="modal-body">
                    {{-- hidden id for edit action --}}
                    <input type="text" name="id" id="id_user_field" hidden>

                    <div class="form-row">
                        <div class="col">
                            <label for="">Name</label>
                            <input type="text" class="form-control"
                                name="name" id="edit_user_name_field">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-6">
                            <label for="">Username</label>
                            <input type="text" class="form-control"
                                name="username" id="edit_user_username_field">
                        </div>
                        <div class="col-6">
                            <label for="">Email</label>
                            <input type="text" class="form-control"
                                name="email" id="edit_user_email_field">
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col">
                            <label for="">Password</label>
                            <input type="password" class="form-control"
                                name="password" id="edit_user_password_field"
                                placeholder="Leave it blank if you dont wont to change">
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col-6">
                            <label for="">Role</label>
                            <select name="role" class="form-control"
                                id="edit_user_role_field">
                                <option value="" selected disabled>-- Pilih Role --</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="">Branch</label>
                            <select name="branch" class="form-control"
                                id="edit_user_branch_field">
                                <option value="" selected disabled>-- Pilih Branch --</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btn_save_user">Save</button>
                </div>
            </form>
        </div>

        <div class="detail-body">

        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script>
    // set ajax header
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        // handle onchange event in modal
        $('#modalUser').on('hidden.bs.modal', function (event) {
            $('#edit_user_name_field').val('');
            $('#edit_user_username_field').val('');
            $('#edit_user_email_field').val('');
            $('#edit_user_role_field').val('');
            $('#edit_user_branch_field').val('');
            $('#edit_user_password_field').val('');
            $('#id_user_field').val('');
        })
    })

    function add() {
        // hide detail body and show edit / add body
        $('.edit-body').removeClass('d-none');
        $('.detail-body').addClass('d-none');
        // show modal
        $('#modalUser').modal('show');
        // add title
        $('#modalUserLabel').text('Add User');
        // add id to form
        $('.form-user').attr('id', 'form_add_user');
        // add action onclick
        $('#btn_save_user').attr('onclick', 'store()');
        // disable select branch
        $('#edit_user_branch_field').attr('disabled', true);

        // get data role and branch
        $.ajax({
            type: "GET",
            url: "{{ route('users.generalData') }}",
            dataType: 'json',
            success: function(res) {
                console.log(res);
                // add select option in role field
                let selectRole = '<option value="" selected disabled>-- Pilih Role</option>';
                for (let a = 0; a < res.data.role.length; a++) {
                    selectRole += '<option value="'+ res.data.role[a].id +'">'+
                        res.data.role[a].nama +
                        '</option>';
                }
                let selectBranch = '<option value="" selected disabled>-- Pilih Branch</option>';
                for (let a = 0; a < res.data.branch.length; a++) {
                    selectBranch += '<option value="'+ res.data.branch[a].id +'">'+
                        res.data.branch[a].name +
                        '</option>';
                }
                $('#edit_user_branch_field').html(selectBranch);
                $('#edit_user_role_field').html(selectRole);
            }
        })
    }

    function store() {
        let data = $('#form_add_user').serialize();
        $.ajax({
            type: 'POST',
            url: "{{ route('users.store') }}",
            data: data,
            dataType: 'json',
            success: function(res) {
                console.log(res);
                if (res.status == 200) {
                    swal({
                        title: "Success",
                        text: res.message,
                        icon: "success",
                        button: "Ok",
                    })
                    // close modal
                    $('#modalUser').modal('hide');
                    // update data
                    getData(0,10);
                } else {
                    let message = typeof res.message == 'object' ? res.message.join(',') : res.message;
                    swal({
                        title: "Failed",
                        text: message,
                        icon: "warning",
                        button: "Ok",
                    })
                }
            },
            error: function(err) {
                console.log('err', err);
            }
        })
    }

    function update() {
        let data = $('#form_edit_user').serialize();
        $.ajax({
            type: 'POST',
            url: "{{ route('users.update') }}",
            data: data,
            dataType: 'json',
            success: function(res) {
                console.log(res);
                if (res.status == 200) {
                    swal({
                        title: "Success",
                        text: res.message,
                        icon: "success",
                        button: "Ok",
                    })
                    // close modal
                    $('#modalUser').modal('hide');
                    // update data
                    getData(0,10);
                } else {
                    let message = typeof res.message == 'object' ? res.message.join(',') : res.message;
                    swal({
                        title: "Failed",
                        text: message,
                        icon: "warning",
                        button: "Ok",
                    })
                }
            },
            error: function(err) {
                console.log('err', err);
            }
        })
    }

    function edit(id) {
        // hide detail body and show edit / add body
        $('.edit-body').removeClass('d-none');
        $('.detail-body').addClass('d-none');
        $('#edit_user_branch_field').attr('disabled', true);

        let uri = {!! json_encode(url('users/edit')) !!}
        let url = uri + '/' + id
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function(res) {
                console.log(res);
                // add select option in role field
                let selectRole = '<option value="" selected disabled>-- Pilih Role</option>';
                for (let a = 0; a < res.data.role.length; a++) {
                    selectRole += '<option value="'+ res.data.role[a].id +'">'+
                        res.data.role[a].nama +
                        '</option>';
                }
                let selectBranch = '<option value="" selected disabled>-- Pilih Branch</option>';
                for (let a = 0; a < res.data.branch.length; a++) {
                    selectBranch += '<option value="'+ res.data.branch[a].id +'">'+
                        res.data.branch[a].name +
                        '</option>';
                }

                let valueBranch = res.data.user.branches != null ? res.data.user.branches.branch_id : null;
                if (valueBranch) {
                    $('#edit_user_branch_field').removeAttr('disabled');
                }
                $('#edit_user_branch_field').html(selectBranch);
                $('#edit_user_branch_field').val(valueBranch);
                $('#edit_user_role_field').html(selectRole);
                $('#edit_user_role_field').val(res.data.user.roles_id);
                $('#edit_user_name_field').val(res.data.user.name);
                $('#edit_user_username_field').val(res.data.user.username);
                $('#edit_user_email_field').val(res.data.user.email);
                $('#id_user_field').val(res.data.user.id);
                // show modal
                $('#modalUser').modal('show');
                // add title
                $('#modalUserLabel').text('Edit Role');
                // add id to form
                $('.form-user').attr('id', 'form_edit_user');
                // add action onclick
                $('#btn_save_user').attr('onclick', 'update()');
            }
        })
    }

    function detail(id) {
        // hide detail body and show edit / add body
        $('.edit-body').addClass('d-none');
        $('.detail-body').removeClass('d-none');

        let uri = {!! json_encode(url('users/detail')) !!}
        let url = uri + '/' + id
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function(res) {
                console.log(res);
                if (res.status == 200) {
                    $('.detail-body').html(res.data.view);
                    //show modal
                    $('#modalUser').modal('show');
                    // set title
                    $('#modalUserLabel').text('Detail Branch');
                }
            }
        })
    }

    function deleteData(id) {
        swal({
            title: "Are you sure?",
            text: "This user will be temporarily disabled",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('users.delete') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        if (res.status == 200) {
                            swal({
                                title: 'Success',
                                text: res.message,
                                icon: 'success',
                                button: 'Ok'
                            });

                            getData(0,10);
                        } else {
                            swal({
                                title: 'Failed',
                                text: res.message,
                                icon: 'warning',
                                button: 'Ok'
                            });
                        }
                    },
                    error: function(err) {
                        swal({
                                title: 'Failed',
                                text: err.responseJSON.message,
                                icon: 'warning',
                                button: 'Ok'
                            });
                    }
                })
            }
        });
    }

    $('#edit_user_role_field').on('change', function (e) {
        if (![6,7,8].includes(Number(e.target.value))) {
            $('#edit_user_branch_field').removeAttr('disabled');
        } else {
            $('#edit_user_branch_field')
                .attr('disabled', true)
                .val(null);
        }
    });
</script>
@endsection
