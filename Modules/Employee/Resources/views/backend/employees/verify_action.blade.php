@if ($data->email_verified_at) 

<span class="badge booking-status bg-soft-success p-3">{{__('employee.msg_verified')}} </span>
                  
@else

 <span href="{{route("backend.employees.verify-employee", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="text-capitalize badge bg-soft-danger p-3" data-type="ajax" data-method="GET" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Verify')}}" data-confirm="{{ __('messages.verify_account') }}"> Verify </span>

@endif