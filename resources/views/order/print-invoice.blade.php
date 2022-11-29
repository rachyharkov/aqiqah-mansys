<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    >
    <title>{{ $fileName }}</title>

    <style>
        .table-detail {
            width: 100%;
            margin-bottom: 1rem;
        }

        .table-detail>tbody>tr:first-child>td {
            padding-top: 1rem;
        }

        .table-detail>tbody>tr>td:nth-child(1) {
            width: 200px;
        }

        .table-detail>tbody>tr>td:nth-child(2) {
            width: 20px;
        }

        .table-detail>tbody>tr>td:nth-child(3) {
            width: 100%;
        }

        .table-detail>tbody>tr>td {
            vertical-align: top;
        }

        .custom-header-table>th {
            border-bottom: 3px solid #000 !important;
            text-align: left;
            padding-bottom: 10px;
        }

        .custom-header-table {
            margin-bottom: 20px;
        }

        .custom-td {
            padding-top: 20px;
        }

        .custom-td-1 {
            padding-bottom: 20px;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }
        }

    </style>
</head>

<body>
    <div style="padding: 0 25px">
        <table border="0">
            <tr>
                <td>
                    <img
                        src="img/logo.png"
                        alt="Syamil Aqiqah"
                        class="brand-image img-circle"
                    >
                </td>
                <td>
                    <p style="font-size: 36px; font-weight: bold; padding: 0 1rem">Syamil<br />Aqiqah & Catering</p>
                </td>
            </tr>
        </table>
    </div>
    <div style="padding: 0 25px">
        <table class="table-detail">
            <thead>
                <tr class="custom-header-table">
                    <th colspan="3">Data Pemesan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nama Customer</td>
                    <td>:</td>
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
                        @php
                            $addresses = [];
                            if (!is_null($data->customer->address)) {
                                $addresses[] = $data->customer->address;
                            }
                            if (!is_null($data->customer->village)) {
                                $addresses[] = $data->customer->village->name;
                            }
                            if (!is_null($data->customer->district)) {
                                $addresses[] = $data->customer->district->name;
                            }
                            if (!is_null($data->customer->postalcode)) {
                                $addresses[] = $data->customer->postalcode;
                            }
                        @endphp
                        {{ implode(', ', $addresses) }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table-detail">
            <thead>
                <tr class="custom-header-table">
                    <th colspan="3">Data Order</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jenis Pembayaran</td>
                    <td>:</td>
                    <td>
                        {{ $data->payment->name ?? '-' }}
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
                        {{ implode(', ', $rices) }}
                    </td>
                </tr>
                <tr>
                    <td>Jenis Beras Arab</td>
                    <td>:</td>
                    <td>
                        {{ implode(', ', $isArabic) }}
                    </td>
                </tr>
                <tr>
                    <td>Menu Pilihan</td>
                    <td>:</td>
                    <td>
                        {{ implode(', ', $allMenu) }}
                    </td>
                </tr>
                <tr>
                    <td>Menu Pilihan</td>
                    <td>:</td>
                    <td>
                        {{ $data->qty }}
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
        <table class="table-detail">
            <thead>
                <tr class="custom-header-table">
                    <th colspan="3">Total Pesanan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Harga Pesanan</td>
                    <td>:</td>
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
                        {{ $data->payment->name ?? '-' }}
                    </td>
                </tr>
                <tr style="font-weight: bold;">
                    <td>Total Pembayaran</td>
                    <td>:</td>
                    <td>
                        {{ number_format($data->total) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
