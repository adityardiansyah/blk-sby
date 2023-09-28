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
        <td>User : {{ Auth::user()->name }}</td>
    </tr>
</table>
<br>
<table border="1">
    <thead>
    <tr>
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>No</b></th>
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>Nama Master</b></th>
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>Nama SKU</b></th>
        <th colspan="6" style="text-align: center; background-color: #40c668;"><b>Category</b></th>
        <th colspan="6" style="text-align: center; background-color: #40c668;"><b>Qty (pcs)</b></th>
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>Harga Jual</b></th>
    </tr>
    <tr>
        <th style="text-align: center; background-color: #40c668;"><b>Group</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Brand</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Varian</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Motive</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Warna</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Size</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Saldo Awal</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Received</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Sales</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Total</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Stock Opname</b></th>
        <th style="text-align: center; background-color: #e42525;"><b>Deviasi</b></th>
    </tr>
    </thead>
    <tbody>
        @php
            $total_last_month = 0;
            $total_gr = 0;
            $total_sales = 0;
            $total = 0;
            $total_price = 0;
            $total_opname = 0;
            $deviasi = 0;
        @endphp
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
            <td>{{ $item->total }}</td>
            <td>{{ $item->stock_opname }}</td>
            <td>{{ $item->deviasi }}</td>
            <td>{{ $item->price }}</td>
        </tr>
        @php
            $total_last_month += $item->last_month;
            $total_gr += $item->gr;
            $total_sales += $item->sales;
            $total += $item->total;
            $total_price += $item->price;
            $total_opname += $item->stock_opname;
            $deviasi += $item->deviasi;
        @endphp
        @endforeach
        <tr>
            <td colspan="9" style="background-color: #b6b6b6;"><b>Total</b></td>
            <td style="background-color: #b6b6b6;"><b>{{ $total_last_month }}</b></td>
            <td style="background-color: #b6b6b6;"><b>{{ $total_gr }}</b></td>
            <td style="background-color: #b6b6b6;"><b>{{ $total_sales }}</b></td>
            <td style="background-color: #b6b6b6;"><b>{{ $total }}</b></td>
            <td style="background-color: #b6b6b6;"><b>{{ $total_opname }}</b></td>
            <td style="background-color: #b6b6b6;"><b>{{ $deviasi }}</b></td>
            <td style="background-color: #b6b6b6;"><b>{{ $total_price }}</b></td>
        </tr>
    </tbody>
</table>