<div class="text-end d-flex gap-2 align-items-center">
    
   {{-- <button type="button" class="fs-4 text-primary border-0 bg-transparent" data-crud-id="{{$data->id}}" title="{{__('Edit')}} " data-bs-toggle="tooltip"> <i class="icon-Edit"></i></button>--}}
   
    @hasPermission('delete_booking')
        <a href="{{route("backend.$module_name.destroy", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> 
        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
            <g id="Huge-icon/interface/outline/trash">
            <path id="Vector" d="M4.25 6V13.5C4.25 15.1569 5.59315 16.5 7.25 16.5H11.75C13.4069 16.5 14.75 15.1569 14.75 13.5V6M11 8.25V12.75M8 8.25L8 12.75M12.5 3.75L11.4453 2.16795C11.1671 1.75065 10.6988 1.5 10.1972 1.5H8.80278C8.30125 1.5 7.8329 1.75065 7.5547 2.16795L6.5 3.75M12.5 3.75H6.5M12.5 3.75H16.25M6.5 3.75H2.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
        </svg>
        </a>
    @endhasPermission
</div>
