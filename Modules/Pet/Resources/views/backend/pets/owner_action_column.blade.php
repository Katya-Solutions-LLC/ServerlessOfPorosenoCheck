<div class="d-flex gap-2 align-items-center">
 @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('demo_admin') )

@if($enable_push_notification==1)
<button type='button' data-assign-module="{{ $data->id }}" data-assign-target='#user_send_push_notification' data-assign-event='employee_assign' class='fs-4 text-info border-0 bg-transparent text-nowrap' data-bs-toggle="tooltip" title="Send Push Notification"> <i class="fa-regular fa-paper-plane"></i></button>
@endif
@endif

@hasPermission('edit_user_password')
<button type='button' data-assign-module="{{ $data->id }}" data-assign-target='#Employee_change_password' data-assign-event='employee_assign' class='fs-4 text-success border-0 bg-transparent text-nowrap' data-bs-toggle="tooltip" title="Change Password"><i class="icon-password"></i></button>
@endhasPermission
      
@hasPermission('edit_owners')
        <button type="button" class="fs-4 text-primary border-0 bg-transparent" data-crud-id="{{$data->id}}" title="{{__('Edit')}} " data-bs-toggle="tooltip"> <i class="icon-Edit"></i></button>
    @endhasPermission
    @hasPermission('delete_owners')
        <a href="{{route("backend.customers.destroy", $data->id)}}" id="delete-{{__('pet.lbl_owner')}}-{{$data->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="icon-delete"></i></a>
    @endhasPermission
</div>


