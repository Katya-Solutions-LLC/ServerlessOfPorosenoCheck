<div class="d-flex gap-2 align-items-center">
  @hasPermission('edit_category')
      <button type="button" class="fs-4 text-primary border-0 bg-transparent" data-crud-id="{{$data->id}}" data-parent-id="{{$data->parent_id}}" data-bs-toggle="tooltip" title="{{__('Edit')}}"> <i class="icon-Edit"></i></button>
  @endhasPermission
  @hasPermission('delete_category')
  <a href="{{route("backend.$module_name.destroy", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}"  data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="icon-delete"></i></a>
  @endhasPermission
</div>
