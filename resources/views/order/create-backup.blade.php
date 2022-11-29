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
        display: flex;
        align-items: center;
        justify-content: space-between;
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
{{-- collapse item --}}
<form action="{{ route('order.store') }}" id="form-order">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <button class="btn btn-check-availability btn-collapse w-100 text-left"
                            type="button" data-toggle="collapse" data-target="#collapseCheckQuota"
                            aria-expanded="false" aria-controls="collapseCheckQuota">
                            <span>Cek Kuota Ketersediaan</span>
                            <i class="fa fa-plus"></i>
                        </button>

                        <div class="collapse" id="collapseCheckQuota">
                            <div class="card card-body">
                                <div class="form-row">
                                    <div class="col-4">
                                        <label for="">Cabang</label>
                                        @if ($branch != null)
                                            <input type="text" class="form-control"
                                                name="branch" disabled
                                                value="{{ $branch->branch->name }}">
                                            <input type="text" class="form-control" id="branchId" hidden
                                                value="{{ $branch->branch->id }}" name="branchId">
                                        @else
                                            <select name="branchId" class="form-control" id="branchId">
                                                <option value="" selected disabled>-- Pilih cabang --</option>
                                                @foreach ($allBranch as $ab)
                                                    <option value="{{ $ab->id }}">
                                                        {{ $ab->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        <label for="">Tanggal Kirim</label>
                                        <input type="date" id="date" class="form-control" value="">
                                    </div>
                                    <div class="col-4">
                                        <label for="">Jam Kirim</label>
                                        <input type="time" id="time" class="form-control" name="time">
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
                    </div>

                    {{-- data leads --}}
                    <div class="">
                        <button class="btn btn-collapse w-100 text-left"
                            type="button" data-toggle="collapse" data-target="#collapseDataLeads"
                            aria-expanded="false" aria-controls="collapseDataLeads">
                            <span>Data Leads</span>
                            <i class="fa fa-plus"></i>
                        </button>

                        {{-- collapse item --}}
                        <div class="collapse" id="collapseDataLeads">
                            <div class="card card-body">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Nama Customer</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Telepon</label>
                                        <input type="number" class="form-control" name="phone_1">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Source Order</label>
                                        <select name="source_order" class="form-control" id="">
                                            <option value="1">Instagram</option>
                                            <option value="2">Facebook</option>
                                            <option value="3">Google</option>
                                            <option value="4">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="">Market Temperature</label>
                                        <select name="market_temperature" class="form-control"
                                            id="">
                                            <option value="" selected disabled>-- Pilih Temperature --</option>
                                            <option value="1">Cold</option>
                                            <option value="2">Warm</option>
                                            <option value="3">Hot</option>
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
                            <span>Customer Information</span>
                            <i class="fa fa-plus"></i>
                        </button>

                        {{-- collapse item --}}
                        <div class="collapse" id="collapseCustomerInformation">
                            <div class="card card-body">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Nama Sohibul Aqiqah</label>
                                        <input type="text" class="form-control"
                                            name="name_of_aqiqah">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Tanggal Lahir</label>
                                        <input type="date" class="form-control"
                                            name="birth_of_date">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Jenis Kelamin</label>
                                        <select name="gender_of_aqiqah" class="form-control" id="">
                                            <option value="1">Laki - laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Nomor HP</label>
                                        <input type="number" class="form-control"
                                            name="number_2">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Nama Ayah</label>
                                        <input type="text" class="form-control"
                                            name="father_name">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Nama Ibu</label>
                                        <input type="text" class="form-control"
                                            name="mother_name">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Alamat</label>
                                        <textarea name="address" class="form-control"
                                            id="" cols="5" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-4">
                                        <label for="">Kecamatan</label>
                                        <select name="district" class="form-control" id="district_select"
                                            onchange="getVilages(this.value)">
                                            <option value="" selected disabled>-- Pilih Kecamatan --</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}">
                                                    {{$district->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="">Kelurahan</label>
                                        <select name="village" class="form-control" id="village_select">
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="">Kode pos</label>
                                        <input type="number" class="form-control" name="postalcode">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Grup area</label>
                                        <select name="branch_group" class="form-control">
                                            <option value="1">Jabodetabek</option>
                                            <option value="2">Jawa Barat</option>
                                            <option value="3">Banten</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Cabang</label>
                                        @if ($branch != null)
                                            <input type="text" class="form-control" value="{{ $branch->branch->name }}" disabled>
                                        @else
                                            <select name="branchId" class="form-control" id="branch_2">
                                                <option value="" selected disabled>-- Pilih cabang --</option>
                                                @foreach ($allBranch as $ab)
                                                    <option value="{{ $ab->id }}">
                                                        {{ $ab->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
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
                            <span>Order Informasi</span>
                            <i class="fa fa-plus"></i>
                        </button>

                        {{-- collapse item --}}
                        <div class="collapse" id="collapseOrderInformation">
                            <div class="card card-body">
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Jenis pembayaran</label>
                                        <select name="payment" class="form-control"
                                            id="payment_type_field" onchange="showFileUploader(this.value)">
                                            <option value="" selected disabled>-- Pilih Pembayaran --</option>
                                            @foreach ($payment as $pay)
                                                <option value="{{ $pay->id }}">
                                                    {{ Str::ucfirst($pay->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row target-file"></div>

                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Jumlah kambing</label>
                                        <select name="number_of_goats" class="form-control"
                                            id="" onchange="qtyGoats(this.value)">
                                            <option value="" selected disabled>-- Pilih Jumlah Kambing --</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Jenis kelamin kambing</label>
                                        <select name="gender_of_goats" class="form-control"
                                            id="">
                                            <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                                            <option value="1">Jantan</option>
                                            <option value="2">Betina</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Jenis Pesanan</label>
                                        <select name="type_order" class="form-control"
                                            id="">
                                            <option value="" selected disabled>-- Pilih Jenis Pesanan</option>
                                            @foreach ($typeOrder as $ty)
                                                <option value="{{ $ty->id }}">
                                                    {{ Str::ucfirst($ty->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="">Maklon</label>
                                        <select name="maklon" class="form-control"
                                            id="">
                                            <option value="" selected disabled>-- Pilih Maklon</option>
                                            <option value="1">Ya</option>
                                            <option value="2">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Jumlah Order</label>
                                        <input type="text" class="form-control" id="qty_order" name="qty_order">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Pengiriman</label>
                                        <select name="shipping" class="form-control"
                                            id="">
                                            <option value="" selected disabled>-- Pilih Pengiriman --</option>
                                            @foreach ($shippings as $shipping)
                                                <option value="{{ $shipping->id }}">
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
                                            id="send_date" name="send_date" readonly>
                                    </div>
                                    <div class="col-4">
                                        <label for="">Jam Tiba Lokasi</label>
                                        <input type="time" class="form-control"
                                            id="send_time" name="send_time" readonly>
                                    </div>
                                    <div class="col-4">
                                        <label for="">Jam Konsumsi</label>
                                        <input type="time" class="form-control"
                                            name="consumsion_time">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Keterangan</label>
                                        <textarea name="notes" class="form-control"
                                            id="" cols="5" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Total Harga</label>
                                        <input type="text" class="form-control currency"
                                            name="total_price" onchange="calculate(this.value)">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="">Biaya tambahan</label>
                                        <input type="text" class="form-control currency"
                                            name="additional_price" onchange="calculate(this.value, 'additional')">
                                    </div>
                                    <div class="col-6">
                                        <label for="">Diskon</label>
                                        <input type="text" class="form-control currency"
                                            name="discount_price" onchange="calculate(this.value, 'discount')">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Total Keseluruhan</label>
                                        <input type="text" class="form-control currency"
                                            name="total" id="fix_price" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="card card-body card_package">
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
                                            onchange="selectDetailPackage(this.value, 0)" id="">
                                            <option value="" selected disabled>-- Pilih Paket --</option>
                                            @foreach ($package as $pack)
                                                <option value="{{ $pack->id }}">{{ $pack->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row" id="target-package-detail-0"></div>
                            </div>
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
        $('#collapseCheckQuota').collapse('show');

        // select2
        $("#district_select").select2({
            theme: "bootstrap"
        });
        $("#village_select").select2({
            theme: "bootstrap"
        });

        //  init daterangepicker
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });

        // currency format
        $('.currency').inputmask({
            alias: 'currency', prefix: 'Rp ', digits: '0', numericInput: true,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });

        $('#form-order').on('submit', (function(e) {
            e.preventDefault();
            // validation quota
            let paymentType = $('#payment_type_field').val();
            let quota = $('#quota').val();
            let qtyOrder = $('#qty_order').val();
            let data = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('order.store') }}",
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
                        // clear dropify
                        if (paymentType != null) {
                            clearDropify();
                        }
                        // reset form
                        document.getElementById('form-order').reset();
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
                    let err = error.responseJSON;
                    swal({
                        title: "Failed",
                        text: err.message,
                        icon: "warning",
                        button: "Ok"
                    })
                    if (paymentType != null) {
                        clearDropify();
                    }
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

    function getVilages(value) {
        $.ajax({
            type: "POST",
            url: "{{ route('order.getVillages') }}",
            data: {
                id: value
            },
            dataType: 'json',
            success: function(res) {
                console.log(res);
                let option = '<option value="" selected disabled>-- Pilih Kelurahan --</option>';
                if (res.data.length) {
                    for (let a = 0; a < res.data.length; a++) {
                        option += '<option value="'+ res.data[a].id +'">'+
                        res.data[a].name +
                        '</option>';
                    }
                }
                $('#village_select').html(option)
            }
        })
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

    function showFileUploader(value) {
        $.ajax({
            type: "POST",
            url: "{{ route('order.showFileUploader') }}",
            data: {
                id: value
            },
            dataType: "json",
            success: function(res) {
                $('.target-file').html(res.data.view);
                // init dropify
                $('.dropify').dropify({
                    messages: {
                        'default': 'Upload file'
                    }
                })
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
                $('#branch_2').val(branch);
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

    function selectDetailPackage(value, index) {
        $.ajax({
            type: "POST",
            url : "{{ route('order.getDetailPackage') }}",
            data: {
                packageId: value,
                index: index
            },
            dataType: 'json',
            success: (res) => {
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
