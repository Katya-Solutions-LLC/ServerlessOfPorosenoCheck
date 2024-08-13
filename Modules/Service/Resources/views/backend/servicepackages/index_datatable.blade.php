@extends('backend.layouts.app')

@section('title')
     {{ __($module_title) }}
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/service/style.css') }}">
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <x-backend.section-header>
            <div>
              <x-backend.quick-action url="{{route('backend.service.bulk_action')}}">
                <div class="">
                  <select name="action_type" class="form-control select2 col-12" id="quick-action-type" style="width:100%">
                      <option value="">{{ __('messages.no_action') }}</option>
                      <option value="change-status">{{ __('messages.status') }}</option>
                      <option value="delete">{{ __('messages.delete') }}</option>
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
                    <input type="text" class="form-control form-control-sm dt-search" placeholder="Search..." aria-label="Search" aria-describedby="addon-wrapping">
                    
                  </div>
                  {{-- @can('add_' . $module_name)
                        <x-buttons.offcanvas target='#form-offcanvas'
                            title="{{ __('Create') }} {{ __($module_title) }}" class=" d-flex align-items-center gap-1">{{ __('messages.new') }}</x-buttons.offcanvas>
                    @endcan --}}
                    @hasPermission('create_service_package')
                      <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-crud-id="{{0}}" title="{{ __('Create') }} {{ __($module_title) }}"><i class="fas fa-plus-circle"></i>{{ __('Create') }} {{ __($module_title) }}</button>
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
        <service-package-form-offcanvas
        create-title="{{ __('Create') }} {{ __($module_title) }}"
        edit-title="{{ __('Edit') }} {{ __($module_title) }}">
        </service-package-form-offcanvas>
    </div>
@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <script src="{{ mix('modules/service/script.js') }}"></script>


    <!-- DataTables Core and Extensions -->
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

    <script type="text/javascript" defer>
       const columns = [
            {
                name: 'check',
                data: 'check',
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
                width: '0%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            { data: 'name', name: 'name', title: "{{ __('service_package.lbl_name') }}",width:'15%' },
            { data: 'category_id', name: 'category_id', title: "{{ __('service_package.lbl_category') }}" ,width:'15%'},
            { data: 'sub_category_id', name: 'sub_category_id', title: "{{ __('service_package.lbl_sub_category') }}" ,width:'15%' },
            { data: 'description', name: 'description', title: "{{ __('service_package.lbl_description') }}" ,width:'15%' },
            { data: 'price', name: 'price', title: "{{ __('service_package.lbl_price') }}",

               render: function(data, type, row) {
                return window.defaultCurrencySymbol + ' ' + parseFloat(data).toFixed(2);
               },width:'15%'

            },
            { data: 'status', name: 'status', orderable: false, searchable: true, title: "{{ __('service_package.lbl_status') }}" ,width:'5%' },
        ]

        const actionColumn = [
            { data: 'action', name: 'action', orderable: false, searchable: false, title: 'Action' ,width:'5%' }
        ]

        const customFieldColumns = JSON.parse(@json($columns))

        let finalColumns = [
            ...columns,
            ...customFieldColumns,
            ...actionColumn
        ]

        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.service.index_data") }}',
                finalColumns,
            })
        })
        const formOffcanvas = document.getElementById('form-offcanvas')
        const instance = bootstrap.Offcanvas.getOrCreateInstance(formOffcanvas)

        $(document).on('click', '[data-crud-id]', function() {
            setEditID($(this).attr('data-crud-id'), $(this).attr('data-parent-id'))
        })

        function setEditID(id, parent_id) {
            if (id !== '' || parent_id !== '') {
                const idEvent = new CustomEvent('crud_change_id', {
                    detail: {
                        form_id: id,
                        parent_id: parent_id
                    }
                })
                document.dispatchEvent(idEvent)
            } else {
                removeEditID()
            }
            instance.show()
        }

        function removeEditID() {
            const idEvent = new CustomEvent('crud_change_id', {
                detail: {
                    form_id: 0,
                    parent_id: null
                }
            })
            document.dispatchEvent(idEvent)
        }

        formOffcanvas?.addEventListener('hidden.bs.offcanvas', event => {
            removeEditID()
        })

        function resetQuickAction () {
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

      $('#quick-action-type').change(function () {
        resetQuickAction()
      });

    </script>
@endpush
