<table class="table_detail_branch">
    <tbody>
        <tr>
            <td>Name</td>
            <td>:</td>
            <td>
                {{ $role->nama }}
            </td>
        </tr>
        <tr>
            <td>Total User with this Role</td>
            <td>:</td>
            <td>
                {{ count($role->userRole) }}
            </td>
        </tr>
    </tbody>
</table>