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

    #table_list_branch thead tr th:nth-child(2) {
        width: 20%;
        text-align: center;
    }

    #table_list_branch thead tr th:first-child {
        width: 80%;
    }

    #table_list_branch tbody tr td:nth-child(2) {
        width: 20%;
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
</style>
@endsection
@section('content')
<div class="row">
    <div class="col">
        <div class="card card-body">
            <div class="header_group">
                <p class="card_title_text mb-0">Users List</p>
                <button class="btn btn-primary" onclick="add()">Add Branch</button>
            </div>

            <table class="table" id="table_list_branch">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="target-branch-body">
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- modal edit --}}
<div class="modal fade" id="modalBranch" tabindex="-1" aria-labelledby="modalBranchLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalBranchLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="edit-body">
            <form action="" class="form-branch">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control"
                            name="name" id="edit_branch_name_field">

                        {{-- hidden id for edit action --}}
                        <input type="text" name="id" id="id_branch_field" hidden>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btn_save_branch">Save</button>
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
        getData(0,10);
        // init table sort
        let table = $('#table_list_order');
        new Tablesort(document.getElementById('table_list_branch'), {
            descending: true
        });

        // handle onchange event in modal
        $('#modalBranch').on('hidden.bs.modal', function (event) {
            $('#edit_branch_name_field').val('');
            $('#id_branch_field').val('');
        })
    })

    function add() {
        // hide detail body and show edit / add body
        $('.edit-body').removeClass('d-none');
        $('.detail-body').addClass('d-none');
        // show modal
        $('#modalBranch').modal('show');
        // add title
        $('#modalBranchLabel').text('Add Branch');
        // add id to form
        $('.form-branch').attr('id', 'form_add_branch');
        // add action onclick
        $('#btn_save_branch').attr('onclick', 'store()');
    }

    function store() {
        let data = $('#form_add_branch').serialize();
        $.ajax({
            type: 'POST',
            url: "{{ route('branch.store') }}",
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
                    $('#modalBranch').modal('hide');
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
        let data = $('#form_edit_branch').serialize();
        $.ajax({
            type: 'POST',
            url: "{{ route('branch.update') }}",
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
                    $('#modalBranch').modal('hide');
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

        let uri = {!! json_encode(url('branch/edit')) !!}
        let url = uri + '/' + id
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function(res) {
                $('#edit_branch_name_field').val(res.data.name);
                $('#id_branch_field').val(res.data.id);
                // show modal
                $('#modalBranch').modal('show');
                // add title
                $('#modalBranchLabel').text('Edit Branch');
                // add id to form
                $('.form-branch').attr('id', 'form_edit_branch');
                // add action onclick
                $('#btn_save_branch').attr('onclick', 'update()');
            }
        })
    }

    function detail(id) {
        // hide detail body and show edit / add body
        $('.edit-body').addClass('d-none');
        $('.detail-body').removeClass('d-none');

        let uri = {!! json_encode(url('branch/detail')) !!}
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
                    $('#modalBranch').modal('show');
                    // set title
                    $('#modalBranchLabel').text('Detail Branch');
                }
            }
        })
    }

    function getData(page = 0, limit = 10) {
        let uri = {!! json_encode(url('branch/json')) !!};
        let url = uri + '/' + page + '/' + limit;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            beforeSend: function() {
                // set loading
                let loading = `<tr>
                    <td colspan="2" class="text-center">
                        Processing data ...
                    </td>
                    </tr>`
                $('.target-branch-body').html(loading);
            },
            success: function(res) {
                $('.target-branch-body').html(res.data.view);
            }
        })
    }

    function deleteData(id) {
        swal({
            title: "Are you sure?",
            text: "This branch will delete permanently from database",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('branch.delete') }}",
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
</script>
@endsection
