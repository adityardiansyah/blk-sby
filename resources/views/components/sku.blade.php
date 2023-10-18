<tr>
    <td>{{ $key + 1 }}</td>
    <td>{{ $item->product_master->name }}</td>
    <td>{{ $item->sku }}</td>
    <td>
        @if (Auth::user()->id == 1)
        <form class='d-inline' action=" {{ url ('/sku/' .$item->id) }}" method="POST">
            @csrf
            @method('DELETE')
                <button type="submit" name="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
        @endif
        {!! NavHelper::action('tabel', $item->id) !!}
    </td>
</tr>