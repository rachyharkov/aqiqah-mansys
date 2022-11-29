@if (count($data) == 0)
    <tr>
        <td colspan="5" class="text-center">Empty data</td>
    </tr>
@else
    @foreach ($data as $d)
        <tr>
            <td></td>
            <td>
                <div class="order_details">
                    <p class="order_details_text">
                        {{ $d->packageMenu == null ? 'Belum ada paket yang dipilih' : $d->packageMenu }}
                    </p>
                    <p class="order_details_helper">
                        Updated 1 day ago
                    </p>
                </div>
            </td>
            <td class="table-customer-name">
                <div class="order_details">
                    <p class="order_details_text">
                        {{ $d->customer->name }}
                    </p>
                    <p class="order_details_helper">
                        {{ $d->customer->phone_1 }}
                    </p>
                </div>
            </td>
            <td>
                <div class="order_details">
                    <p class="order_details_text">
                        {{ date('F d, Y', strtotime($d->send_date)) }}
                    </p>
                    <p class="order_details_helper">
                        {{ $d->send_time }}
                    </p>
                </div>
            </td>
            <td>
                <div class="order_details">
                    <p class="order_details_text">
                        {{ $d->shipping ?? '-' }}
                    </p>
                </div>
            </td>
            <td>
                <div id="detail_icon text-success">
                    <a href="{{ route('order.show', [$d->id]) }}" class="table_action">
                        <i class="fa fa-eye text-success fa-1x"></i>
                    </a>
                    <a href="{{ route('order.edit', [$d->id]) }}" class="table_action">
                        <i class="fa fa-pencil-square-o text-primary"></i>
                    </a>
                    <a href="{{ route('order.invoice', [$d->id]) }}" target="_blank" class="table_action">
                        <i class="fa fa-print text-success"></i>
                    </a>
                    <a href="{{ route('order.kitchen-invoice', [$d->id]) }}" class="table_action">
                        <i class="fa fa-cutlery text-primary"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
@endif
