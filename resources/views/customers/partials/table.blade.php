@foreach ($customers as $key => $customer)
    <tr>
        <td style="border: 1px solid black; text-align: center">{{ $customers->firstItem() + $key }}</td>
        <td style="border: 1px solid black; text-align: center">{{ $customer->name }}</td>
        <td style="border: 1px solid black; text-align: center">{{ $customer->phone }}</td>
        <td style="border: 1px solid black; text-align: center">{{ $customer->email }}</td>
        <td style="border: 1px solid black; text-align: center">
            <div style="display: inline-flex; align-items: center; gap: 10px;">
                <a class="btn btn-info" href="{{ route('customer.edit', [$customer->id]) }}">Edit</a>
                <form action="{{ route('customer.destroy', [$customer->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">
                        Delete
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
