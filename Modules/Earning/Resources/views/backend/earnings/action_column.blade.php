<div class="text-end d-flex gap-2 align-items-center">
    @if($data['total_pay'] > 0)
      <span  class="fs-4 text-primary border-0 bg-transparent cursor-pointer"  data-crud-id="{{ $data->id }}" title="{{__('Payout')}}" data-bs-toggle="tooltip"><i class='icon-money'></i></span>
    @else
      <span  class="px-2">-</span>
    @endif
</div>



