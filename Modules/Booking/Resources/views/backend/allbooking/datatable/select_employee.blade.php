@if($data->status != 'completed')
<select name="employee" class="select2 change-select" data-token="{{csrf_token()}}" data-url="{{route('backend.bookings.updateEmployee', ['id' => $data->id])}}" style="width: 100%;">
    <option value="Null">Select</option>
  @foreach ($employeeData as $key => $value )
    <option value="{{$value->id}}" {{$data->id == $value->id ? 'selected' : ''}}>{{$value->first_name}}</option>
  @endforeach
</select>
@else
@endif