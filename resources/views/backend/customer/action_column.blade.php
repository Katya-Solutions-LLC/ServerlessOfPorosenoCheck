<div>
  <div class="d-flex gap-2 align-items-center">
    <button type='button' data-gallery-module="{{$data->id}}" data-gallery-target='#service-gallery-form' data-gallery-event='service_gallery' class='fs-4 text-info text-nowrap' data-bs-toggle="tooltip" title="{{ __('messages.gallery_for_branch') }}"><i class="icon-gallary"></i></button>
    <button type='button' data-assign-module="{{$data->id}}" data-assign-target='#staff-assign-form' data-assign-event='employee_assign' class='btn btn-warning btn-sm rounded text-nowrap' data-bs-toggle="tooltip" title="{{ __('messages.assign_staff_branch') }}"><i class="fa-solid fa-users-rectangle"></i></button>
    @can('edit_'.$module_name)
        <button type="button" class="fs-4 text-primary border-0 bg-transparent" data-crud-id="{{$data->id}}" title="{{__('Edit')}} " data-bs-toggle="tooltip"> <i class="icon-Edit"></i></button>
    @endcan
    @can('delete_'.$module_name)
        <a href="{{route("backend.$module_name.destroy", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="btn btn-danger btn-sm" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="icon-delete"></i></a>
    @endcan
  </div>
</div>
