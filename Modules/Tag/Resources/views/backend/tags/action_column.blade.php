<div class="d-flex gap-2 align-items-center">
@if($data->created_by === $user->id || $user->hasRole(['admin', 'demo_admin']))
      @hasPermission('edit_tag')
            <button type="button" class="btn btn-soft-primary btn-sm" data-crud-id="{{$data->id}}" title="{{ __('messages.edit') }} " data-bs-toggle="tooltip"> <i class="fa-solid fa-pen-clip"></i></button>
      @endhasPermission

      @hasPermission('delete_tag')
            <a href="{{route('backend.tags.destroy', $data->id)}}" id="delete-{{$module_name}}-{{$data->id}}" class="btn btn-soft-danger btn-sm" data-type="ajax" data-method="DELETE" data-token="{{csrf_token()}}" data-bs-toggle="tooltip" title="{{__('messages.delete')}}" data-confirm="{{ __('messages.are_you_sure?') }}"> <i class="fa-solid fa-trash"></i></a>
      @endhasPermission
@endif
</div>
