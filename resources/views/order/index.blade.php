@extends('layouts.template')
@section('style')
<style>
    .card_title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem;
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

    .filter_group {
        display: flex;
        align-items: center;
    }

    .search,
    .sort,
    .filter,
    .export,
    .branch_search {
        display: flex;
        align-items: center;
        margin-left: 20px;
    }

    .search_text,
    .sort_text,
    .filter_text {
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 20px;
        letter-spacing: 0.2px;
        color: #4B506D;
        margin-bottom: 0 !important;
        margin-left: 10px;
    }

    .card_list_order > .card-body {
        padding: 0;
    }

    .table_list_order > thead > tr > th {
        font-style: normal;
        font-weight: 700;
        font-size: 14px;
        line-height: 18px;
        letter-spacing: 0.2px;
        color: #9FA2B4;
    }

    .table_list_order > tbody > tr {
        cursor: pointer;
    }

    .order_details > .order_details_text {
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 20px;
        letter-spacing: 0.2px;
        color: #252733;
        margin-bottom: 0 !important;
        text-transform: capitalize;
        width: 200px;
    }

    .order_details > .order_details_helper {
        font-style: normal;
        font-weight: 400;
        font-size: 12px;
        line-height: 16px;
        letter-spacing: 0.1px;
        color: #C5C7CD;
    }

    .table_action {
        margin-left: 15px;
    }

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

    #tooltip {
        background-color: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 13px;
    }

    #arrow,
    #arrow::before {
    position: absolute;
    width: 8px;
    height: 8px;
    background: inherit;
    }

    #arrow {
    visibility: hidden;
    }

    #arrow::before {
    visibility: visible;
    content: '';
    transform: rotate(45deg);
    }

    #tooltip[data-popper-placement^='top'] > #arrow {
    bottom: -4px;
    }

    #tooltip[data-popper-placement^='bottom'] > #arrow {
    top: -4px;
    }

    #tooltip[data-popper-placement^='left'] > #arrow {
    right: -4px;
    }

    #tooltip[data-popper-placement^='right'] > #arrow {
    left: -4px;
    }

    .custom_button_timeline {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
    }

    .timeline_box {
        width: 150px;
        background: transparent;
        border: 1px solid #ABA8A8;
        border-radius: 20px;
        margin: 0 8px;
        padding: 10px;
        cursor: pointer;
    }

    .timeline_box.active {
        background: #007bff;
    }

    .timeline_box.active > .timeline_text {
        color: #fff;
    }

    .timeline_text {
        color: #000;
        font-size: 13px;
        text-align: center;
        margin-bottom: 0 !important;
    }
</style>
@endsection
@section('content')
{{-- errors --}}
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <h5>{{ $errors->first() }}</h5>
    </div>
@endif
<div class="card card_list_order">
    <div class="card-body">
        <div class="card_title">
            <div class="text_group">
                <p class="card_title_text">All Order List</p>
            </div>
            <form action="" method="GET">
                <div class="filter_group">
                    <div class="d-flex align-items-center">
                        <label for="send_date" class="mb-0 mr-2">Tanggal Kirim:</label>
                        <div>
                            <input
                                type="date"
                                class="form-control"
                                id="send_date"
                                name="send_date"
                                placeholder="Send Date"
                                value="{{ request('send_date') }}"
                                onchange="this.form.submit()"
                            />
                        </div>
                    </div>
                    <div class="search">
                        <input
                            type="search"
                            class="form-control"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search here"
                        />
                    </div>
                    @if ($user == null)
                        <div class="branch_search">
                            <select name="branch_id" class="form-control" onchange="this.form.submit()">
                                <option value="">-- All branches --</option>
                                @foreach ($branches as $branch)
                                    <option
                                        value="{{ $branch->id }}"
                                        @if(request('branch_id') == $branch->id) selected @endif
                                    >{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="export">
                        <button type="button" class="btn btn-primary" onclick="optionExport()">Export</button>
                    </div>
                </div>
            </div>
            </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Order Details</th>
                    <th>Customer Name</th>
                    <th>Tanggal Dikirim</th>
                    <th>Keterangan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>
                            <div class="order_details">
                                <p class="order_details_text">
                                    {{ $order->packageMenu == null ? 'Belum ada paket yang dipilih' : $order->packageMenu }}
                                </p>
                                <p class="order_details_helper">
                                    {{ $order->created_at->diffFOrHumans() }}
                                </p>
                            </div>
                        </td>
                        <td class="table-customer-name">
                            <div class="order_details">
                                <p class="order_details_text">
                                    {{ $order->customer_name }}
                                </p>
                                <p class="order_details_helper">
                                    {{ $order->customer_phone_1 }}
                                </p>
                            </div>
                        </td>
                        <td>
                            <div class="order_details">
                                <p class="order_details_text">
                                    {{ date('F d, Y', strtotime($order->send_date)) }}
                                </p>
                                <p class="order_details_helper">
                                    {{ $order->send_time }}
                                </p>
                            </div>
                        </td>
                        <td>
                            <div class="order_details">
                                <p class="order_details_text">
                                    {{ $order->shipping->name ?? '-' }}
                                </p>
                            </div>
                        </td>
                        <td>
                            <div id="detail_icon text-success">
                                <a href="{{ route('order.show', [$order->id]) }}" class="table_action">
                                    <i class="fa fa-eye text-success fa-1x"></i>
                                </a>
                                <a href="{{ route('order.edit', [$order->id]) }}" class="table_action">
                                    <i class="fa fa-pencil-square-o text-primary"></i>
                                </a>
                                <a href="{{ route('order.invoice', [$order->id]) }}" target="_blank" class="table_action">
                                    <i class="fa fa-print text-success"></i>
                                </a>
                                <a href="{{ route('order.kitchen-invoice', [$order->id]) }}" class="table_action">
                                    <i class="fa fa-cutlery text-primary"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Data not found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-end">
            {!! $orders->withQueryString()->links() !!}
        </div>
    </div>
</div>

{{-- modal export --}}
<div class="modal fade" id="modalExport" tabindex="-1" aria-labelledby="modalExportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalExportLabel">Export</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('order.export') }}" method="POST" id="form-export">
                @csrf
                <div class="modal-body">
                    {{-- custom button choice --}}
                    <label for="">Pilih Timeline</label>
                    <div class="custom_button_timeline">
                        <div class="timeline_box"
                            id="timeline_week"
                            onclick="chooseTimeline('week')">
                            <p class="timeline_text">This Week</p>
                        </div>
                        <div class="timeline_box"
                            id="timeline_month"
                            onclick="chooseTimeline('month')">
                            <p class="timeline_text">This Month</p>
                        </div>
                        <div class="timeline_box"
                            id="timeline_custom"
                            onclick="chooseTimeline('custom')">
                            <p class="timeline_text">Custom</p>
                        </div>
                    </div>

                    <div class="form-group d-none" id="form-group-export">
                        {{-- hidden input field timeline --}}
                        <input type="text" hidden name="timeline" id="timeline_field">
                        <div class="form-row">
                            <div class="col-6">
                                <label for="">Start date</label>
                                <input type="date" class="form-control"
                                    name="start_date">
                            </div>
                            <div class="col-6">
                                <label for="">End date</label>
                                <input type="date" class="form-control"
                                    name="end_date">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label for="">Branch</label>
                                @if ($user == null)
                                    <select name="branch" class="form-control"
                                    id="branch_export"></select>
                                @else
                                    <input type="text" readonly class="form-control"
                                        value="{{ $user->branch->name }}">
                                    <input type="text" name="branch" hidden
                                        value="{{ $user->branch_id }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </form>
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
            // init popover
            $("#myPopover").popover({
                title : "Default popover title"
            });

            // action onchange modal
            $('#modalExport').on('hidden.bs.modal', function (event) {
                let elem = $('.timeline_box');
                for (let a = 0; a < elem.length; a++) {
                    elem[a].classList.remove('active')
                }
                document.getElementById('form-export').reset();
                // hide form
                $('#form-group-export').addClass('d-none');
            })
        })
        function optionExport() {
            // get branch list
            $.ajax({
                type: "GET",
                url: "{{ route('branch.list') }}",
                dataType: 'json',
                success: function(res) {
                    console.log(res);
                    let option = '<option value="" selected disabled>-- Pilih Cabang --</option>';
                    if (res.data.length) {
                        for (let a = 0; a < res.data.length; a++) {
                            option += '<option value="'+ res.data[a].id +'">'+
                            res.data[a].name +
                            '</option>'
                        }

                        $('#branch_export').html(option);
                    }
                }
            });
            $('#modalExport').modal('show');
        }
        function chooseTimeline(param) {
            let elem = $('.timeline_box');
            for (let a = 0; a < elem.length; a++) {
                elem[a].classList.remove('active')
            }
            $('#timeline_' + param).addClass('active');
            if (param == 'custom') {
                $('#form-group-export').removeClass('d-none');
            } else {
                $('#form-group-export').addClass('d-none');
            }

            // manipulate input field
            if (param == 'week') {
                $("#timeline_field").val(1);
            } else if (param == 'month') {
                $("#timeline_field").val(2);
            } else {
                $("#timeline_field").val(3);
            }
        }
    </script>
@endsection
