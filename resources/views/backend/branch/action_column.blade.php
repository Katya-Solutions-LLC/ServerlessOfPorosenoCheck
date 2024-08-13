<div>
  <div class="d-flex gap-2 align-items-center">
    @hasPermission('branch_gallery')
    <button type='button' data-gallery-module="{{$data->id}}" data-gallery-target='#branch-gallery-form' data-gallery-event='branch_gallery' class='fs-4 text-success border-0 bg-transparent text-nowrap' data-bs-toggle="tooltip" title="{{ __('messages.gallery_for_branch') }}"><i class="icon-gallary"></i></button>
    @endhasPermission
     
    <button type="button" class="fs-4 text-primary border-0 bg-transparent" data-crud-id="{{$data->id}}" title="{{__('Edit')}} " data-bs-toggle="tooltip"> <i class="icon-Edit"></i></button>
     
  </div>
</div>
