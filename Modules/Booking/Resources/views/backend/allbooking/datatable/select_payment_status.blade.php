

@if(isset($data->payment))
    @if($data->payment->payment_status != 1)
    <select name="branch_for" class="select2 change-select" data-token="{{csrf_token()}}"
        data-url="{{route('backend.bookings.updatePaymentStatus', ['id' => $data->id, 'action_type' => 'update-payment-status'])}}"
        style="width: 100%;">
        @foreach ($payment_status as $key => $value )

        <option value="{{$value->value}}" {{$data->payment->payment_status  == $value->value ? 'selected' : ''}}>
            {{$value->name}}</option>
        @endforeach
    </select>

@else

@foreach ($payment_status as $key => $value )

@if(isset($data->payment))
    @if($data->payment->payment_status==$value->value)

    <span class="text-capitalize badge bg-soft-info p-3">{{$value->name}}</span>
    @endif
@endif

@endforeach

@endif 
@else

<span class="text-capitalize badge bg-soft-danger p-3">Failed</span>

@endif 