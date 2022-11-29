@foreach ($roles as $role)
<tr>
    <td>
        {{ $role->nama }}
    </td>
    <td>
        <div id="detail_icon text-success">
            <button class="table_action btn" onclick="detail({{ $role->id }})">
                <i class="fa fa-eye text-success fa-1x"></i>
            </button>
        </div>
    </td>
</tr>
@endforeach
