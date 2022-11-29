@extends('layouts.template')
@section('order', 'active')
@section('style')
<style>
    .greeting {
        margin-bottom: 1em;
    }

    .form-row {
        margin-bottom: 1em;
    }

    .btn-check-availability,
    .btn-collapse {
        background: #000;
        color: #fff;
    }

    .btn-check-availability:hover,
    .btn-collapse:hover {
        color: #fff;
    }

    .custom-label-cek {
        color: transparent;
    }

    .btn-group-check {
        display: flex; 
        align-items: end;
    }

    .btn-collapse {
        margin-bottom: 10px;
    }

    .card_package {
        position: relative;
        margin-top: 35px;
    }

    .floating_button {
        position: absolute;
        top: -15px;
        right: 15px;
    }

    .btn_add_package {
        border-radius: 50%;
        color: #fff;
        font-size: 16px;
    }

    label {
        text-transform: capitalize !important;
    }
</style>
@endsection
@section('content')
@php
    $orderPackage = $order->orderPackage->toArray();
@endphp
{{-- collapse item --}}
<form action="{{ route('order.update-data', [$id]) }}" id="form-order-update">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {{-- <div class="">
                        <button class="btn btn-check-availability btn-collapse w-100 text-left"
                            type="button" data-toggle="collapse" data-target="#collapseCheckQuota"
                            aria-expanded="false" aria-controls="collapseCheckQuota">
                            Cek Kuota Ketersediaan
                        </button>
                
                        <div class="collapse" id="collapseCheckQuota">
                            <div class="card card-body">
                                <div class="form-row">
                                    <div class="col-4">
                                        <label for="">Cabang</label>
                                        @if ($branch != null)
                                            <input type="text" class="form-control"
                                                name="branch" disabled 
                                                value="{{ $order->branch->name }}">
                                            <input type="text" class="form-control" id="branchId" hidden
                                                value="{{ $order->branch->id }}" name="branchId">
                                        @else
                                            <select name="branchId" class="form-control" id="branchId"
                                                value="{{ $order->branch->id }}">
                                                <option value="" selected disabled>-- Pilih cabang --</option>
                                                @foreach ($allBranch as $ab)
                                                    <option value="{{ $ab->id }}"
                                                        {{ $order->branch->id == $ab->id ? 'selected' : '' }}>
                                                        {{ $ab->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        <label for="">Tanggal Kirim</label>
                                        <input type="date" id="date" class="form-control"
                                            value="{{ date('Y-m-d', strtotime($order->send_date)) }}">
                                    </div>
                                    <div class="col-4">
                                        <label for="">Jam Kirim</label>
                                        <input type="time" id="time" class="form-control" name="time"
                                            value="{{ $order->send_time }}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Sisa Kuota</label>
                                        <input type="text" readonly id="quota"
                                            class="form-control" name="kuota">
                                    </div>
                                    <div class="col-6 btn-group-check">
                                        <button class="btn btn-success btn-check"
                                            type="button" onclick="checkQuota()">Cek</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- branch id --}}
                    <input type="text" class="form-control" id="branchId" hidden
                        value="{{ $order->branch->id }}" name="branchId">

                    {{-- data leads --}}
                    <div class="">
                        <button class="btn btn-collapse w-100 text-left"
                            type="button" data-toggle="collapse" data-target="#collapseDataLeads"
                            aria-expanded="false" aria-controls="collapseDataLeads">
                            Data Leads
                        </button>
                
                        {{-- collapse item --}}
                        <div class="collapse" id="collapseDataLeads">
                            <div class="card card-body">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Nama Customer</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $order->customer->name }}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Telepon</label>
                                        <input type="number" class="form-control" name="phone_1"
                                            value="{{ $order->customer->phone_1 }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Source Order</label>
                                        <select name="source_order" class="form-control" id=""
                                            value="{{ $order->source_order_id }}">
                                            <option value="1" {{ $order->source_order_id == 1 ? 'selected' : '' }}>IG</option>
                                            <option value="2" {{ $order->source_order_id == 2 ? 'selected' : '' }}>FB</option>
                                            <option value="3" {{ $order->source_order_id == 3 ? 'selected' : '' }}>Google Ads</option>
                                            <option value="4" {{ $order->source_order_id == 4 ? 'selected' : '' }}>Offline</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="">Market Temperature</label>
                                        <select name="market_temperature" class="form-control"
                                            id="">
                                            <option value="" selected disabled>-- Pilih Temperature --</option>
                                            <option value="1" {{ $order->market_temperature == 1 ? 'selected' : '' }}>Cold</option>
                                            <option value="2" {{ $order->market_temperature == 2 ? 'selected' : '' }}>Warm</option>
                                            <option value="3" {{ $order->market_temperature == 3 ? 'selected' : '' }}>Hot</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- data customer --}}
                    <div class="">
                        <button class="btn btn-collapse w-100 text-left"
                            type="button" data-toggle="collapse" data-target="#collapseCustomerInformation"
                            aria-expanded="false" aria-controls="collapseCustomerInformation">
                            Customer information
                        </button>
                
                        {{-- collapse item --}}
                        <div class="collapse" id="collapseCustomerInformation">
                            <div class="card card-body">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Nama Sohibul Aqiqah</label>
                                        <input type="text" class="form-control"
                                            name="name_of_aqiqah" value="{{ $order->customer->name_of_aqiqah }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Tanggal lahir</label>
                                        @if ($order->customer->birth_of_date == null || $order->customer->birth_of_date == '')
                                            <input type="date" class="form-control"
                                                name="birth_of_date" 
                                                value="">
                                        @else
                                            <input type="date" class="form-control"
                                                name="birth_of_date" 
                                                value="{{ date('Y-m-d', strtotime($order->customer->birth_of_date)) }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Jenis kelamin</label>
                                        <select name="gender_of_aqiqah" class="form-control" id=""
                                            value="{{ $order->customer->gender_of_aqiqah }}">
                                            <option value="1">Laki - laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Nomor HP</label>
                                        <input type="number" class="form-control"
                                            name="number_2" value="{{ $order->customer->phone_2 }}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Nama Ayah</label>
                                        <input type="text" class="form-control"
                                            name="father_name" value="{{ $order->customer->father_name }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Nama Ibu</label>
                                        <input type="text" class="form-control"
                                            name="mother_name" value="{{ $order->customer->mother_name }}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Alamat</label>
                                        <textarea name="address" class="form-control"
                                            id="" cols="5" rows="3"
                                            value="">{{ $order->customer->address }}</textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-4">
                                        <label for="">Kecamatan</label>
                                        <select name="district" class="form-control" id="district_select"
                                            onchange="getVilages(this.value)"
                                            value="{{ $order->customer->district_id }}">
                                            <option value="" selected disabled>-- Pilih Kecamatan --</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}"
                                                    {{ $order->customer->district_id == $district->id ? 'selected' : '' }}>
                                                    {{$district->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="">Kelurahan</label>
                                        <select name="village" class="form-control" id="village_select"
                                            onchange="getVilages(this.value)"
                                            value="{{ $order->customer->village_id }}">
                                            <option value="" selected disabled>-- Pilih Kelurahan --</option>
                                            @foreach ($villages as $village)
                                                <option value="{{ $village->id }}"
                                                    {{ $order->customer->village_id == $village->id ? 'selected' : '' }}>
                                                    {{$village->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="">Kode pos</label>
                                        <input type="number" class="form-control" name="postalcode" value="{{ $order->customer->postalcode }}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Grup area</label>
                                        <select name="branch_group" class="form-control"
                                            value="{{ $order->branch_group_id }}">
                                            <option value="1" {{ $order->branch_group_id == 1 ? 'selected' : '' }}>Jabodetabek</option>
                                            <option value="2" {{ $order->branch_group_id == 2 ? 'selected' : '' }}>Jawa Barat</option>
                                            <option value="3" {{ $order->branch_group_id == 3 ? 'selected' : '' }}>Banten</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Cabang</label>
                                        <input type="text" class="form-control" value="{{ $order->branch->name }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- order information --}}
                    <div class="">
                        <button class="btn btn-collapse w-100 text-left"
                            type="button" data-toggle="collapse" data-target="#collapseOrderInformation"
                            aria-expanded="false" aria-controls="collapseOrderInformation">
                            Order Informasi
                        </button>
                
                        {{-- collapse item --}}
                        <div class="collapse" id="collapseOrderInformation">
                            <div class="card card-body">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Jenis pembayaran</label>
                                        <select name="payment" class="form-control"
                                            id="payment_type_field_edit" onchange="showFileUploader(this.value)"
                                            value="{{ $order->payment_id }}">
                                            <option value="" selected disabled>-- Pilih Pembayaran --</option>
                                            @foreach ($payment as $pay)
                                                <option value="{{ $pay->id }}" {{ $pay->id == $order->payment_id ? 'selected' : '' }}>
                                                    {{ Str::ucfirst($pay->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- set hidden file image id --}}
                                <input type="text" hidden value="1" id="static_file_id" name="static_file_id">
                                <div class="form-row target-file"></div>

                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Jumlah kambing</label>
                                        <select name="number_of_goats" class="form-control"
                                            id="" onchange="qtyGoats(this.value)"
                                            value="{{ $order->number_of_goats }}">
                                            <option value="" selected disabled>-- Pilih Jumlah Kambing --</option>
                                            <option value="1" {{ $order->number_of_goats == 1 ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ $order->number_of_goats == 2 ? 'selected' : '' }}>2</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Jenis kelamin kambing</label>
                                        <select name="gender_of_goats" class="form-control"
                                            id="" value="{{ $order->gender_of_goats }}">
                                            <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                                            <option value="1" {{ $order->gender_of_goats == 1 ? 'selected' : '' }}>Jantan</option>
                                            <option value="2" {{ $order->gender_of_goats == 2 ? 'selected' : '' }}>Betina</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Jenis Pesanan</label>
                                        <select name="type_order" class="form-control"
                                            id="" value="{{ $order->type_order_id }}">
                                            <option value="" selected disabled>-- Pilih Jenis Pesanan</option>
                                            @foreach ($typeOrder as $ty)
                                                <option value="{{ $ty->id }}" {{ $order->type_order_id == $ty->id ? 'selected' : '' }}>
                                                    {{ Str::ucfirst($ty->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Maklon</label>
                                        <select name="maklon" class="form-control"
                                            id="" value="{{ $order->maklon }}">
                                            <option value="" selected disabled>-- Pilih Maklon</option>
                                            <option value="1" {{ $order->maklon == 1 ? 'selected' : '' }}>Ya</option>
                                            <option value="2" {{ $order->maklon == 2 ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Jumlah Order</label>
                                        <input type="text" class="form-control" id="qty_order" name="qty_order"
                                            value="{{ $order->qty }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Pengiriman</label>
                                        <select name="shipping" class="form-control"
                                            id="" value="{{ $order->shipping_id }}">
                                            <option value="" selected disabled>-- Pilih Pengiriman --</option>
                                            @foreach ($shippings as $shipping)
                                                <option value="{{ $shipping->id }}" {{ $order->shipping_id == $shipping->id ? 'selected' : '' }}>
                                                    {{ Str::ucfirst($shipping->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-4">
                                        <label for="">Tanggal Kirim</label>
                                        <input type="date" class="form-control"
                                            id="send_date" name="send_date" readonly
                                            value="{{ date('Y-m-d', strtotime($order->send_date)) }}">
                                    </div>
                                    <div class="col-4">
                                        <label for="">Jam Tiba Lokasi</label>
                                        <input type="time" class="form-control"
                                            id="send_time" name="send_time" readonly
                                            value="{{ $order->send_time }}">
                                    </div>
                                    <div class="col-4">
                                        <label for="">Jam Konsumsi</label>
                                        <input type="time" class="form-control"
                                            name="consumsion_time" value="{{ $order->consumsion_time }}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Keterangan</label>
                                        <textarea name="notes" class="form-control" 
                                            id="" cols="5" rows="3">{{ $order->notes }}</textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Total Harga</label>
                                        <input type="text" class="form-control currency"
                                            name="total_price" onchange="calculate(this.value)"
                                            value="{{ $order->total + $order->discount_price - $order->additional_price }}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Biaya tambahan</label>
                                        <input type="text" class="form-control currency"
                                            name="additional_price" onchange="calculate(this.value, 'additional')"
                                            value="{{ $order->additional_price }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Diskon</label>
                                        <input type="text" class="form-control currency"
                                            name="discount_price" onchange="calculate(this.value, 'discount')"
                                            value="{{ $order->discount_price }}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Total Keseluruhan</label>
                                        <input type="text" class="form-control currency"
                                            name="total" id="fix_price" value="{{ $order->total }}">
                                    </div>
                                </div>
                            </div>
                            @if (count($orderPackage) == 0)
                                <div class="card card-body card_package" id="card_package_1">
                                    <div class="floating_button d-none">
                                        <button class="btn btn-primary btn_add_package"
                                            type="button" id="btn_add_package_0"
                                            onclick="addPackage()"
                                        >
                                            +
                                        </button>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <label for="">Jenis Paket</label>
                                            <select name="package[0][package_id]" class="form-control"
                                                onchange="selectDetailPackage(this.value, 0, 'new')" id="check-0"
                                                value="">
                                                <option value="" selected disabled>-- Pilih Paket --</option>
                                                @foreach ($package as $pack)
                                                    <option value="{{ $pack->id }}">
                                                        {{ $pack->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row" id="target-package-detail-0"></div>
                                </div>
                            @else
                                @for ($i = 0; $i < count($orderPackage); $i++)
                                    <div class="card card-body card_package" id="card_package_{{ $i + 1 }}">
                                        <div class="floating_button d-none">
                                            <button class="btn btn-primary btn_add_package"
                                                type="button" id="btn_add_package_0"
                                                onclick="addPackage()"
                                            >
                                                +
                                            </button>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <label for="">Jenis Paket</label>
                                                <select name="package[{{$i}}][package_id]" class="form-control"
                                                    onchange="selectDetailPackage(this.value, {{$i}}, 'new')" id="check-{{ $i }}"
                                                    value="{{ $orderPackage[$i]['package_id'] }}">
                                                    <option value="" selected disabled>-- Pilih Paket --</option>
                                                    @foreach ($package as $pack)
                                                        <option value="{{ $pack->id }}"
                                                            {{ $orderPackage[$i]['package_id'] == $pack->id ? 'selected' : '' }}>
                                                            {{ $pack->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row" id="target-package-detail-{{ $i }}"></div>
                                    </div>
                                @endfor
                            @endif
                            <div id="target_package"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-success" id="save-order" type="submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('scripts')
<script src="{{asset('vendors/inputmask/dist/jquery.inputmask.min.js')}}"></script>
<script>
    // set ajax header
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        // $('#collapseOrderInformation').collapse('show');
        $('.collapse').collapse('show');
        // select2
        $('#district_select').select2({
            theme: "bootstrap"
        });
        $('#village_select').select2({
            theme: "bootstrap"
        });
        // get quota
        // checkQuota();
        // show uploaded file
        showFileUploader("{{ $order->payment_id }}", true);
        // set package 
        let package = @json($orderPackage);
        for (let a = 0; a < package.length; a++) {
            selectDetailPackage(package[a].package_id, a, 'edit');
        }

        // currency format
        $('.currency').inputmask({
            alias: 'currency', prefix: 'Rp ', digits: '0', numericInput: true,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });

        $('#form-order-update').on('submit', (function(e) {
            e.preventDefault();
            let quota = $('#quota').val();
            let qtyOrder = $('#qty_order').val();
            let data = new FormData(this);
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: (res) => {
                    console.log(res);
                    if (res.status == 200) {
                        swal({
                            title: "Success",
                            text: res.message,
                            icon: "success",
                            button: "Ok",
                        });
                        let url = "{{ route('order.index') }}";
                        setTimeout(() => {
                            window.location.href = url;
                        }, 500);
                    } else {
                        swal({
                            title: "Failed",
                            text: res.message,
                            icon: "warning",
                            button: "Ok",
                        });
                    }
                },
                error: function(error) {
                    clearDropify();
                    let err = error.responseJSON;
                    swal({
                        title: "Failed",
                        text: err.message,
                        icon: "warning",
                        button: "Ok"
                    })
                }
            });
        }))
    })
    
    function clearDropify() {
        var drEvent = $('#input-file-max-fs').dropify();
        drEvent = drEvent.data('dropify');
        drEvent.resetPreview();
        drEvent.clearElement();
    }

    function manipulateStaticFileId() {
        $('#static_file_id').val(0);
    }

    function calculate(value, param = "") {
        let total = $('#fix_price').val();
        let fix = "";
        if (param == 'discount') {
            fix = parseInt(total) - parseInt(value);
        } else if (param == 'additional') {
            fix = parseInt(total) + parseInt(value);
        } else {
            fix = value;
        }
        $('#fix_price').val(fix);
    }

    function showFileUploader(value, isEdit = false) {
        $.ajax({
            type: "POST",
            url: "{{ route('order.showFileUploader') }}",
            data: {
                id: value,
                isEdit: isEdit,
                orderId: "{{ $order->id }}"
            },
            dataType: "json",
            success: function(res) {
                if (value != '') {
                    $('.target-file').html(res.data.view);
                    // init dropify
                    $('.dropify').dropify({
                        messages: {
                            'default': 'Upload file'
                        }
                    })
                }
            }
        })
    }

    function checkQuota() {
        let branch = $('#branchId').val();
        let dates = $('#date').val();
        let times = $('#time').val();
        $.ajax({
            type: "POST",
            url: "{{ route('order.check-quota') }}",
            data: {
                branch: branch,
                dates: dates,
                times: times
            },
            dataType: 'json',
            success: function(res) {
                $('#quota').val(res.data);
                // manipulat same value
                $('#send_date').val(dates);
                $('#send_time').val(times);
            }
        });
    }

    function qtyGoats(value) {
        console.log(value)
        if (value == 2) {
            $('.floating_button').removeClass('d-none');
        } else if (value == 1) {
            $('.floating_button').addClass('d-none');
            // remove latest element
            $('#card_package_2').remove();
        }
    }

    function addPackage() {
        let allElem = $('.card_package');
        if (allElem.length > 0 && allElem.length < 3) {
            for (let a = 1; a <= allElem.length; a++) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('order.showCardPackage') }}",
                    data: {
                        id: a
                    },
                    dataType: 'json',
                    success: (res) => {
                        $('#target_package').html(res.data.view);
                    }
                })
            }
        }
    }

    function selectDetailPackage(value, index, paramEdit) {
        $.ajax({
            type: "POST",
            url : "{{ route('order.getDetailPackage') }}",
            data: {
                packageId: value,
                index: index,
                isEdit: paramEdit,
                orderId: "{{ $order->id }}"
            },
            dataType: 'json',
            success: (res) => {
                console.log(res)
                if (res.status == 200) {
                    $('#target-package-detail-' + index).html(res.data.view);
                }
            }
        })
    }

    function freeTextChange(value, param) {
        if (value == 'free_text') {
            $('#' + param + '_menu_option').removeClass('d-none');
            $('#' + param + '_menu_input').removeClass('d-none');
            $('#' + param + '_menu_input').focus();
        } else {
            $('#' + param + '_menu_input').addClass('d-none');
            $('#' + param + '_menu_input_text').val('');
        }
    }
</script>
@endsection