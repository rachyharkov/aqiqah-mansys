<table class="table_detail_branch">
    <tbody>
        <tr>
            <td>Name</td>
            <td>:</td>
            <td>
                {{ $user->name }}
            </td>
        </tr>
        <tr>
            <td>Username</td>
            <td>:</td>
            <td>
                {{ $user->username }}
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td>
                {{ $user->email }}
            </td>
        </tr>
        <tr>
            <td>Cabang</td>
            <td>:</td>
            <td>
                {{ $user->branches->branch->name }}
            </td>
        </tr>
    </tbody>
</table>