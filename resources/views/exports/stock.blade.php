<table>
    <tr>
        <td><b>Report Stock</b></td>
    </tr>
    <tr>
        <td>Store : {{ $shop }}</td>
    </tr>
    <tr>
        <td>Date : {{ $date_start }} - {{ $date_end }}</td>
    </tr>
    <tr>
        <td>User : </td>
    </tr>
</table>
<br>
<table border="1">
    <thead>
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Nama Master</th>
        <th rowspan="2">Nama SKU</th>
        <th colspan="6">Category</th>
        <th colspan="4">Qty (pcs)</th>
        <th rowspan="2">Harga Jual</th>
    </tr>
    <tr>
        <th>Group</th>
        <th>Brand</th>
        <th>Varian</th>
        <th>Motive</th>
        <th>Warna</th>
        <th>Size</th>
        <th>Last Month</th>
        <th>Received</th>
        <th>Sales</th>
        <th>Stock on Hand</th>
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