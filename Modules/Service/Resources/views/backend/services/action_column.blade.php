<div class="d-flex gap-2 align-items-center">
  @if(auth()->user()->user_type == 'vet' || auth()->user()->user_type == 'groomer')
  
    @if($data->created_by == auth()->id())

        @hasPermission('edit_service')
            <button type="button" class="fs-4 text-primary border-0 bg-transparent" data-crud-id="{{$data->id}}" title="{{__('Edit')}} " data-bs-toggle="tooltip"> <i class="icon-Edit"></i></button>
        @endhasPermission
        @hasPermission('delete_service')
            <a href="{{route("backend.$module_name.destroy", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="icon-delete"></i></a>
        @endhasPermission
    @endif
  @else
        @hasPermission('service_gallery')
          <button type='button' data-gallery-module="{{ $data->id }}" data-gallery-target='#service-gallery-form' data-gallery-event='service_gallery' class='fs-4 text-success border-0 bg-transparent text-nowrap' data-bs-toggle="tooltip" title="Gallery For Service"><i class="icon-gallary"></i></button>
        @endhasPermission
        @hasPermission('edit_service')
            <button type="button" class="fs-4 text-primary border-0 bg-transparent" data-crud-id="{{$data->id}}" title="{{__('Edit')}} " data-bs-toggle="tooltip"> <i class="icon-Edit"></i></button>
        @endhasPermission
        @hasPermission('delete_service')
            <a href="{{route("backend.$module_name.destroy", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="icon-delete"></i></a>
        @endhasPermission
  @endif
</div>
