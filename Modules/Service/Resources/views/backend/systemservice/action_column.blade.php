<div class="d-flex gap-2 align-items-center">
  @hasPermission('edit_service')
      <button type="button" class="fs-4 text-primary border-0 bg-transparent" data-crud-id="{{$data->id}}" title="{{__('Edit')}} " data-bs-toggle="tooltip"> <i class="icon-Edit"></i></button>
  @endhasPermission
</div>
