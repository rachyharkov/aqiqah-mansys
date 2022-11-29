@extends('layouts.template')
@section('content')
    @php
    // address
    $address = '';
    $village = '';
    $district = '';
    $postalcode = '';
    if ($data->customer->village != '') {
        $village = $data->customer->village->name;
    }
    if ($data->customer->district != '') {
        $district = $data->customer->district->name;
    }
    if ($data->customer->postalcode != '') {
        $postalcode = $data->customer->postalcode;
    }
    $address = $data->customer->address . ' ' . $village . ' ' . $district . ' ' . $postalcode;

    // payment
    $payment = '';
    if ($data->payment != '') {
        $payment = $data->payment->name;
    }
    @endphp
    <div class="row">
        <div class="col">
            <div class="card card-body">
                <table class="mb-4">
                    <thead>
                        <tr colspan="3">
                            <th class="pb-3">Data Pemesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="250px">Nama Customer</td>
                            <td width="20px">:</td>
                            <td>
                                {{ $data->customer->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>No Telp</td>
                            <td>:</td>
                            <td>
                                {{ $data->customer->phone_1 }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Shohubul Aqiqah</td>
                            <td>:</td>
                            <td>
                                {{ $data->customer->name_of_aqiqah }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal lahir</td>
                            <td>:</td>
                            <td>
                                {{ date('Y-m-d', strtotime($data->customer->birth_of_date)) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Kirim</td>
                            <td>:</td>
                            <td>
                                {{ date('Y-m-d H:i', strtotime($data->send_date)) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Ayah</td>
                            <td>:</td>
                            <td>
                                {{ $data->customer->father_name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Ibu</td>
                            <td>:</td>
                            <td>
                                {{ $data->customer->mother_name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>
                                {{ $address }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="mb-4">
                    <thead>
                        <tr colspan="3">
                            <th class="pb-3">Data Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="250px">Jenis Pembayaran</td>
                            <td width="20px">:</td>
                            <td>
                                {{ $payment }}
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah kambing</td>
                            <td>:</td>
                            <td>
                                {{ $data->number_of_goats }}
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah Pesanan</td>
                            <td>:</td>
                            <td>
                                {{ $data->qty }}
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Paket</td>
                            <td>:</td>
                            <td>
                                {{ $data->packageMenu }}
                            </td>
                        </tr>
                        <tr>
                            <td>Pilihan Nasi</td>
                            <td>:</td>
                            <td>
                                {{
                                    $data->orderPackage
                                        ->map(function ($orderPackage) {
                                            return !is_null($orderPackage->rice)
                                                ? $orderPackage->rice->rice->name
                                                : null;
                                        })
                                        ->join(', ')
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td>Olahan Daging</td>
                            <td>:</td>
                            <td>
                                {{
                                    $data->orderPackage
                                        ->map(function ($orderPackage) {
                                            return !is_null($orderPackage->meat)
                                                ? $orderPackage->meat->meat->name
                                                : null;
                                        })
                                        ->join(', ')
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td>Olahan Jeroan</td>
                            <td>:</td>
                            <td>
                                {{
                                    $data->orderPackage
                                        ->map(function ($orderPackage) {
                                            return !is_null($orderPackage->offal)
                                                ? $orderPackage->offal->offal->name
                                                : null;
                                        })
                                        ->join(', ')
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td>Menu Pilihan 1</td>
                            <td>:</td>
                            <td>
                                {{
                                    $data->orderPackage
                                        ->map(function ($orderPackage) {
                                            if (!is_null($orderPackage->chicken)) {
                                                return $orderPackage
                                                    ->chicken
                                                    ->chicken
                                                    ->name;
                                            } else if (!is_null($orderPackage->egg)) {
                                                return $orderPackage
                                                    ->egg
                                                    ->egg
                                                    ->name;
                                            }

                                            return null;
                                        })
                                        ->join(', ')
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td>Menu Pilihan 2</td>
                            <td>:</td>
                            <td>
                                {{
                                    $data->orderPackage
                                        ->map(function ($orderPackage) {
                                            return !is_null($orderPackage->vegie)
                                                ? $orderPackage->vegie->vegie->name
                                                : null;
                                        })
                                        ->join(', ')
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Kirim</td>
                            <td>:</td>
                            <td>
                                {{ date('Y-m-d H:i', strtotime($data->send_date)) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr colspan="3">
                            <th class="pb-3">Total Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="250px">Harga Pesanan</td>
                            <td width="20px">:</td>
                            <td>
                                {{ number_format($data->total + $data->discount_price - $data->additional_price) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Biaya Tambahan</td>
                            <td>:</td>
                            <td>
                                {{ number_format($data->additional_price) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Diskon</td>
                            <td>:</td>
                            <td>
                                {{ number_format($data->discount_price) }}
                            </td>
                        </tr>
                        <tr>
                            <td>Catatan Tambahan</td>
                            <td>:</td>
                            <td>
                                {{ $data->notes }}
                            </td>
                        </tr>
                        <tr>
                            <td>Metode Pembayaran</td>
                            <td>:</td>
                            <td>
                                {{ $payment }}
                            </td>
                        </tr>
                        <tr class="font-weight-bold">
                            <td>Total Pembayaran</td>
                            <td>:</td>
                            <td>
                                {{ number_format($data->total) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
