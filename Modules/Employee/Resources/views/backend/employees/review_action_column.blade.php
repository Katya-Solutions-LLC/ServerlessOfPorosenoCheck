<div class="d-flex gap-2 align-items-center">
   
@hasPermission('delete_review')
        <a href="{{route("backend.employees.destroy_review", $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="fs-4 text-danger" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="icon-delete"></i></a>
    @endhasPermission
</div>
