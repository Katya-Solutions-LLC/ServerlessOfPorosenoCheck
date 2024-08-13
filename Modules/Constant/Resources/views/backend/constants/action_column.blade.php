<div class="text-end d-flex gap-2 align-items-center">
    @can('edit_'.$module_name)
        <button type="button" class="fs-4 text-primary border-0 bg-transparent" data-crud-id="{{$data->id}}" title="{{__('Edit')}} " data-bs-toggle="tooltip"> <i class="icon-Edit"></i></button>
    @endcan
    <a href="{{route("backend.$module_name.show", $data->id)}}" class="fs-4 text-success" data-bs-toggle="tooltip" title="{{__('Show')}}"><i class="icon-eye"></i></a>
    @can('delete_'.$module_name)
        <a href="{{route("backend.$module_name.destroy", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="icon-delete"></i></a>
    @endcan
</div>
