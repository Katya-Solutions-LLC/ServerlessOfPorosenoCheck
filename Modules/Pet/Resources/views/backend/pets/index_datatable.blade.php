@extends('backend.layouts.app')

@section('title')
  {{ __($module_title) }}
@endsection

@push('after-styles')
<link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
@endpush

@section('content')
<div class="card">
  <div class="card-header">
    <x-backend.section-header>
      <div>
        <x-backend.quick-action url='{{ route("backend.$module_name.bulk_action") }}'>
          <div class="">
            <select name="action_type" class="form-control select2 col-12" id="quick-action-type" style="width:100%">
              <option value="">{{ __('messages.no_action') }}</option>
              <option value="change-status">{{ __('messages.status') }}</option>
               @hasPermission('delete_owners')
              <option value="delete">{{ __('messages.delete') }}</option>
              @endhasPermission
            </select>
          </div>
          <div class="select-status d-none quick-action-field" id="change-status-action">
            <select name="status" class="form-control select2" id="status" style="width:100%">
              <option value="1">{{ __('messages.active') }}</option>
              <option value="0">{{ __('messages.inactive') }}</option>
            </select>
          </div>
        </x-backend.quick-action>
      </div>

      <x-slot name="toolbar">
        <div class="input-group flex-nowrap">
          <span class="input-group-text" id="addon-wrapping"><i class="icon-Search"></i></span>
          <input type="text" class="form-control form-control-sm dt-search" placeholder="Search..." aria-label="Search"
            aria-describedby="addon-wrapping">            
          
        </div>
        
      @hasPermission('add_owners')
          <x-buttons.offcanvas target='#form-offcanvas' title="{{ __('Create') }} {{ __('pet.lbl_owner') }}" class=" d-flex align-items-center gap-1">{{ __('messages.new') }}</x-buttons.offcanvas>
        @endhasPermission
      </x-slot>
    </x-backend.section-header>
  </div>
  <div class="card-body p-0">
      <table id="datatable" class="table table-striped border table-responsive">
    </table>
  </div>
</div>

<div data-render="app">
  <customer-offcanvas default-image="{{user_avatar()}}" create-title="{{ __('messages.create') }} {{ __('pet.lbl_owner') }}"
    edit-title="{{ __('messages.edit') }} {{ __('pet.lbl_owner') }}">
  </customer-offcanvas>
  <send-push-notification create-title="Send Push Notification"></send-push-notification>
  <change-password create-title="Change Password"></change-password>
  <assign-pet create-title="Assign Pet"></assign-pet>
  <pet-offcanvas
          create-title="{{ __('messages.create') }} {{ __('pet.title') }}"
          edit-title="{{ __('messages.edit') }} {{ __('pet.title') }}">
    </pet-offcanvas>
</div>


<div data-render="app">
     <pets-offcanvas
          create-title="{{ __('Create') }} {{ __('pet.title') }}"
          edit-title="{{ __('Edit') }} {{ __('pet.title') }}">
    </pets-offcanvas>
 </div>
@endsection

@push('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
<script src="{{ mix('modules/pet/script.js') }}"></script>
<script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>

<!-- DataTables Core and Extensions -->
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

<script type="text/javascript" defer>
  const columns = [{
        name: 'check',
        data: 'check',
        title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
        width: '0%',
        exportable: false,
        orderable: false,
        searchable: false,
      },
      {
    name: 'serial_number',
    title: 'No.',
    data: null,
    width: '5%',
    render: function(data, type, row, meta) {
      return meta.row + 1;
    },
    orderable: false,
    searchable: false,
  },
      {
        data: 'user_id',
        name: 'user_id',
        title: "{{__('pet.lbl_name')}}",
        orderable: true,
        searchable: true,
      },
   
      // {
      //   data: 'email',
      //   name: 'email',
      //   title: "{{__('customer.lbl_Email')}}"
      // },
      {
        data: 'mobile',
        name: 'mobile',
        title: "{{__('customer.lbl_contact_number')}}"
      },
      @hasPermission("view_owner's_pet")
    
        { data: 'pet_count', name: 'pet_count', title: "{{ __('pet.lbl_pet_count') }}", orderable: false, searchable: false,  },
    
       @endhasPermission

       {
      data: 'updated_at',
      name: 'updated_at',
      title: "{{ __('booking.lbl_update_at') }}"
    },

    {
        data: 'gender',
        name: 'gender',
        title: "{{__('customer.lbl_gender')}}"
      },

      
      {
        data: 'status',
        name: 'status',
        orderable: false,
        searchable: true,
        title: "{{__('customer.lbl_status')}}"
      },
      
    ]

    const actionColumn = [{
      data: 'action',
      name: 'action',
      orderable: false,
      searchable: false,
      width:'5%',
      title: "{{__('customer.lbl_action')}}"
    }]

    
    let finalColumns = [
      ...columns,
      ...actionColumn
    ]

    document.addEventListener('DOMContentLoaded', (event) => {
      initDatatable({
        url: '{{ route("backend.$module_name.index_data") }}',
        finalColumns,
        orderColumn: [[ 5, 'desc' ]],
      })
    })

    function resetQuickAction() {
      const actionValue = $('#quick-action-type').val();
      if (actionValue != '') {
        $('#quick-action-apply').removeAttr('disabled');

        if (actionValue == 'change-status') {
          $('.quick-action-field').addClass('d-none');
          $('#change-status-action').removeClass('d-none');
        } else {
          $('.quick-action-field').addClass('d-none');
        }
      } else {
        $('#quick-action-apply').attr('disabled', true);
        $('.quick-action-field').addClass('d-none');
      }
    }

    $('#quick-action-type').change(function() {
      resetQuickAction()
    });

    $(document).on('update_quick_action', function() {
      // resetActionButtons()
    })
</script>
@endpush
