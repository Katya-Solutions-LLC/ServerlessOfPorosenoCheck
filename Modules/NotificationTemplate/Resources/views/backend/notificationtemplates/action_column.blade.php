<div class="d-flex gap-2 align-items-center">
  @hasPermission('edit_notification_template')
    <a href="{{route("backend.notification-templates.edit", $data->id)}}" class="fs-4 text-primary" data-bs-toggle="tooltip" title="{{__('Edit')}} "> <i class="icon-Edit"></i></a>
  @endhasPermission
  {{-- @hasPermission('delete_notification_template')
    <a href="{{route("backend.notification-templates.destroy", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="icon-delete"></i></a>
  @endhasPermission --}}

</div>
