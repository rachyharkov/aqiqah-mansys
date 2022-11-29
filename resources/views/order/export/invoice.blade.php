<table>
    <thead>
        <tr>
            <th colspan="10">
                {{ $title }}
            </th>
        </tr>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th>Nama CS</th>
            <th>Nama Cabang</th>
            <th>Nama Customer</th>
            <th>Nomor Telepon 1</th>
            <th>Nomor Telepon 2</th>
            <th>Source Order</th>
            <th>Tanggal Kirim</th>
            <th>Jam Kirim</th>
            <th>Nama sohibul aqiqah</th>
            <th>Jenis Kelamin</th>
            <th>Tanggal lahir</th>
            <th>Nama Ayah</th>
            <th>Nama Ibu</th>
            <th>Alamat</th>
            <th>Jenis Pembayaran</th>
            <th>Jumlah kambing</th>
            <th>Cabang</th>
            <th>Grup area</th>
            <th>jumlah pesanan</th>
            <th>Jenis paket</th>
            <th>Pilihan Nasi</th>
            <th>Jenis Beras Arab</th>
            <th>Lauk 1</th>
            <th>Lauk 2</th>
            <th>Lauk 3</th>
            <th>Lauk 4</th>
            <th>Lauk 5</th>
        </tr>
    </thead>
    <tbody>
        @php
            $x = 0;
        @endphp
        @foreach ($orders as $order)
        @php
            if ($order->source_order_id == 1) {
                $source = 'Instagram';
            } else if ($order->source_order_id == 2) {
                $source = 'Facebook';
            } else if ($order->source_order_id == 3) {
                $source = 'Google';
            } else {
                $source = 'Others';
            }

            // gender
            if ($order->customer->gender_of_aqiqah != '') {
                if ($order->customer->gender_of_aqiqah == 1) {
                    $gender = 'laki - laki';
                } else {
                    $gender = 'Perempuan';
                }
            } else {
                $gender = '-';
            }

            // address
            $address = '-';
            $village = '';
            $district = '';
            $postalcode = $order->customer->postalcode ?? '';
            if ($order->customer->village != '') {
                $village = $order->customer->village->name;
            }
            if ($order->customer->district != '') {
                $district = $order->customer->district->name;
            }
            if ($order->customer->address != '') {
                $address = $order->customer->address . ', ' . $village . ' ' . $district . ' ' . $postalcode;
            }

            // group area
            $groupBranch = '';
            if ($order->branch_group_id != '') {
                switch ($order->branch_group_id) {
                    case '1':
                        $groupBranch = 'Jabodetabek';
                        break;

                    case '2':
                        $groupBranch = 'Jawa Barat';
                        break;

                    case '3':
                        $groupBranch = 'Banten';
                        break;

                    default:
                        $groupBranch = '';
                        break;
                }
            }

            // payment
            $payment = "";
            if ($order->payment_id != '') {
                $payment = $order->payment->name;
            }
        @endphp
            <tr>
                <td>
                    {{ $order->createdBy->name }}
                </td>
                <td>
                    {{ $order->branch->name }}
                </td>
                <td>
                    {{ $order->customer->name }}
                </td>
                <td>
                    {{ $order->customer->phone_1 ?? '-' }}
                </td>
                <td>
                    {{ $order->customer->phone_2 ?? '-' }}
                </td>
                <td>
                    {{ $source }}
                </td>
                <td>
                    {{ date('Y-m-d', strtotime($order->send_date)) }}
                </td>
                <td>
                    {{ date('H:i:s', strtotime($order->send_time)) }}
                </td>
                <td>
                    {{ $order->customer->name_of_aqiqah ?? '-' }}
                </td>
                <td>
                    {{ $gender }}
                </td>
                <td>
                    {{ $order->customer->birth_of_date != '' ? date('Y-m-d', strtotime($order->customer->birth_of_date)) : '-' }}
                </td>
                <td>
                    {{ $order->customer->father_name }}
                </td>
                <td>
                    {{ $order->customer->mother_name }}
                </td>
                <td>
                    {{ $address }}
                </td>
                <td>
                    {{ $payment }}
                </td>
                <td>
                    {{ $order->number_of_goats }}
                </td>
                <td>
                    {{ $order->branch->name }}
                </td>
                <td>
                    {{ $groupBranch }}
                </td>
                <td>
                    {{ $order->qty }}
                </td>
                <td>
                    {{ $order->packageMenu }}
                </td>
                <td>
                    {{ $orderPackage[$x]['rices'] }}
                </td>
                <td>
                    {{ $orderPackage[$x]['isArabic'] }}
                </td>
                <td>
                    {{ $orderPackage[$x]['menu1'] }}
                </td>
                <td>
                    {{ $orderPackage[$x]['menu2'] }}
                </td>
                <td>
                    {{ $orderPackage[$x]['menu3'] }}
                </td>
                <td>
                    {{ $orderPackage[$x]['menu4'] }}
                </td>
                <td>
                    {{ $orderPackage[$x]['menu5'] }}
                </td>
            </tr>
            @php
                $x++;
            @endphp
        @endforeach
    </tbody>
</table>
