<table class="table_detail_branch">
    <tbody>
        <tr>
            <td>Name</td>
            <td>:</td>
            <td>
                {{ $branch->name }}
            </td>
        </tr>
        <tr>
            <td>Total User</td>
            <td>:</td>
            <td>
                {{ count($branch->userBranch) }}
            </td>
        </tr>
        <tr>
            <td>Total Pesanan</td>
            <td>:</td>
            <td>
                {{ count($branch->orders) }}
            </td>
        </tr>
    </tbody>
</table>