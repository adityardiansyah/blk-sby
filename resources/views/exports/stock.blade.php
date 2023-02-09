<table>
    <tr>
        <td><b>Report Stock</b></td>
    </tr>
    <tr>
        <td>Store : {{ $shop }}</td>
    </tr>
    <tr>
        <td>Date : {{ $date_start }} / {{ $date_end }}</td>
    </tr>
    <tr>
        <td>User : </td>
    </tr>
</table>
<br>
<table border="1">
    <thead>
    <tr>
        <th rowspan="2"><b>No</b></th>
        <th rowspan="2"><b>Nama Master</b></th>
        <th rowspan="2"><b>Nama SKU</b></th>
        <th colspan="6" style="text-align: center;"><b>Category</b></th>
        <th colspan="4" style="text-align: center;"><b>Qty (pcs)</b></th>
        <th rowspan="2"><b>Harga Jual</b></th>
    </tr>
    <tr>
        <th><b>Group</b></th>
        <th><b>Brand</b></th>
        <th><b>Varian</b></th>
        <th><b>Motive</b></th>
        <th><b>Warna</b></th>
        <th><b>Size</b></th>
        <th><b>Last Month</b></th>
        <th><b>Received</b></th>
        <th><b>Sales</b></th>
        <th><b>Stock on Hand</b></th>
    </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $item)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $item->name_item }}</td>
            <td>{{ $item->sku }}</td>
            <td>{{ $item->group }}</td>
            <td>{{ $item->brand }}</td>
            <td>{{ $item->variant }}</td>
            <td>{{ $item->motive }}</td>
            <td>{{ $item->color }}</td>
            <td>{{ $item->size }}</td>
            <td>{{ $item->last_month }}</td>
            <td>{{ $item->gr }}</td>
            <td>{{ $item->sales }}</td>
            <td>{{ $item->qty_on_hand }}</td>
            <td>{{ $item->price }}</td>
        </tr>
        @endforeach
    </tbody>
</table>