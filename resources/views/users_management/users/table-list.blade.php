@foreach ($users as $user)
@php
    $branch = '';
    $role = '';
    if ($user->branches == null) {
        $branch = 'HO';
    } else {
        $branch = $user->branches->branch->name;
    }
    if ($user->roles == null) {
        $role = '-';
    } else {
        $role = $user->roles->nama;
    }
@endphp
    <tr>
        <td>
            {{ $user->name }}
        </td>
        <td>
            {{ $user->username }}
        </td>
        <td>
            {{ $user->email }}
        </td>
        <td>
            {{ $branch }}
        </td>
        <td>
            {{ $role }}
        </td>
        <td>
            <div class="status_user {{ $user->deleted_at == null ? 'status_green' : 'status_red' }}">
                <p class="status_user_text">
                    {{ $user->deleted_at == null ? 'Active' : 'Nonactive' }}
                </p>
            </div>
        </td>
        <td>
            <div id="detail_icon text-success">
                <button class="table_action btn" onclick="detail({{ $user->id }})">
                    <i class="fa fa-eye text-success fa-1x"></i> 
                </button>
                <button  class="table_action btn" onclick="edit({{ $user->id }})">
                    <i class="fa fa-pencil-square-o text-primary"></i> 
                </button>
                <button  class="table_action btn" onclick="deleteData({{ $user->id }})">
                    <i class="fa fa-trash text-danger"></i> 
                </button>
            </div>
        </td>
    </tr>
@endforeach