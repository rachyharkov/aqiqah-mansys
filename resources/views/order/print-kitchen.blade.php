<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>
     <!-- jQuery -->
    <script src="{{asset('template/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('template/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('template/dist/css/adminlte.min.css')}}">
    {{-- page css --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css"> --}}
    <style>

        @page {
            size: A5;
        }

        @media print {
            @page {
                size: A5;
            }
        }

        body {
            border: 1px solid red;
        }

        html,
        body {
            padding: 0;
            margin: 0;
            width: 100%;
        }

        .main_title {
            background: #000;
            color: #fff;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px !important;
            margin-block-start: 0;
        }

        .logo-group {
            display: flex;
            justify-content: center;
        }

        .brand-image {
            width: 190px;
            height: auto;       
        }

        .table-kitchen > tbody > tr > td {
            padding: .2rem;
        }

        .table-kitchen > tbody > tr > td:first-child {
            width: 150px;
        }
        .table-kitchen > tbody > tr > td:nth-child(2) {
            width: 20px;
        }
    </style>
</head>
<body class="A5">
    <div class="row">
        <div class="col-5">
            <p class="main_title">Kartu Order Dapur</p>
            <div class="detail_order">
                <table class="table table-borderless table-kitchen">
                    <tbody>
                        <tr>
                            <td>Order Nomor</td>
                            <td>:</td>
                            <td>{{ $orders->id }}</td>
                        </tr>
                        <tr>
                            <td>Nama CS</td>
                            <td>:</td>
                            <td>
                                {{ $orders->createdBy->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Pesanan</td>
                            <td>:</td>
                            <td>{{ date('d/m/Y', strtotime($orders->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Kirim</td>
                            <td>:</td>
                            <td>{{ date('d/m/Y', strtotime($orders->send_date)) }}</td>
                        </tr>
                        <tr>
                            <td>Request Jam</td>
                            <td>:</td>
                            <td>
                                {{ date('H:i:s', strtotime($orders->send_time)) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-5">
            <div class="logo-group">
                <!-- Brand Logo -->
                <img src="{{asset('img/logo.png')}}" alt="Syamil Aqiqah" class="brand-image img-circle">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-5">
            <table class="table table-borderless table-kitchen">
                <tbody>
                    <tr>
                        <td>Nama Customer</td>
                        <td>:</td>
                        <td>
                            {{ $orders->customer->name }}
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Sohibul Aqiqah</td>
                        <td>:</td>
                        <td>
                            {{ $orders->customer->name_of_aqiqah }}
                        </td>
                    </tr>
                    <tr>
                        <td>Paket Aqiqah</td>
                        <td>:</td>
                        <td>
                            {{ $orders->packageMenu }}
                        </td>
                    </tr>
                    <tr>
                        <td>Porsi</td>
                        <td>:</td>
                        <td>
                            {{ $orders->qty }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-5">
            <table class="table table-borderless table-kitchen">
                <tbody>
                    <tr>
                        <td>Lauk 1</td>
                        <td>:</td>
                        <td>
                            {{ implode(',', $data['menu1']) }}
                        </td>
                    </tr>
                    <tr>
                        <td>Lauk 2</td>
                        <td>:</td>
                        <td>
                            {{ implode(',', $data['menu2']) }}
                        </td>
                    </tr>
                    <tr>
                        <td>Lauk 3</td>
                        <td>:</td>
                        <td>
                            {{ implode(',', $data['menu3']) }}
                        </td>
                    </tr>
                    <tr>
                        <td>Lauk 4</td>
                        <td>:</td>
                        <td>
                            {{ implode(',', $data['menu4']) }}
                        </td>
                    </tr>
                    <tr>
                        <td>Lauk 5</td>
                        <td>:</td>
                        <td>
                            {{ implode(',', $data['menu5']) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>