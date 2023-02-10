<table>
    <tr>
        <td><b>Report Sales</b></td>
    </tr>
    <tr>
        <td>Store : {{ $shop }}</td>
    </tr>
    <tr>
        <td>Date : {{ date('d m Y', strtotime($date_start)) }} / {{ date('d m Y', strtotime($date_end)) }}</td>
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
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>Tanggal</b></th>
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>Nama Master</b></th>
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>Nama SKU</b></th>
        <th colspan="6" style="text-align: center; background-color: #40c668;"><b>Category</b></th>
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>Qty Sales (pcs)</b></th>
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>Harga Jual</b></th>
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>Disc.</b></th>
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>Additional Disc.</b></th>
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>Harga Jual Nett</b></th>
        <th rowspan="2" style="text-align: center; background-color: #40c668;"><b>Total</b></th>
    </tr>
    <tr>
        <th style="text-align: center; background-color: #40c668;"><b>Group</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Brand</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Varian</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Motive</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Warna</b></th>
        <th style="text-align: center; background-color: #40c668;"><b>Size</b></th>
    </tr>
    </thead>
    <tbody>
        @php
            $qty = 0;
            $total = 0;
        @endphp
        @foreach ($data as $key => $item)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $item->trans_date }}</td>
            <td>{{ $item->item_name }}</td>
            <td>{{ $item->sku }}</td>
            <td>{{ $item->group }}</td>
            <td>{{ $item->brand }}</td>
            <td>{{ $item->variant }}</td>
            <td>{{ $item->motive }}</td>
            <td>{{ $item->color }}</td>
            <td>{{ $item->size }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->unit_price }}</td>
            <td>{{ $item->disc }}</td>
            <td>{{ $item->add_disc }}</td>
            <td>{{ $item->bruto_price }}</td>
            <td>{{ $item->total }}</td>
            @php
                $qty += $item->qty;
                $total += $item->total;
            @endphp
        </tr>
        @endforeach
        <tr>
            <td colspan="10" style="background-color: #b6b6b6;"><b>Total</b></td>
            <td style="background-color: #b6b6b6;"><b>{{ $qty }}</b></td>
            <td style="background-color: #b6b6b6;"></td>
            <td style="background-color: #b6b6b6;"></td>
            <td style="background-color: #b6b6b6;"></td>
            <td style="background-color: #b6b6b6;"></td>
            <td style="background-color: #b6b6b6;"><b>{{ $total }}</b></td>
        </tr>
    </tbody>
</table>