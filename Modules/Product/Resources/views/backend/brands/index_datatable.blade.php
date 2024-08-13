@extends('backend.layouts.app')

@section('title') {{ __($module_title) }} @endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <x-backend.section-header>
                <div class="d-flex flex-wrap gap-3">
                    <x-backend.quick-action url="{{ route('backend.brands.bulk_action') }}">
                        <div class="">
                            <select name="action_type" class="form-control select2 col-12" id="quick-action-type"
                                style="width:100%">
                                <option value="">{{ __('messages.no_action') }}</option>
                                <option value="change-status">{{ __('messages.status') }}</option>
                                <option value="delete">{{ __('messages.delete') }}</option>
                            </select>
                        </div>
                        <div class="select-status d-none quick-action-field" id="change-status-action">
                            <select name="status" class="form-control select2" id="status" style="width:100%">
                                <option value="1" selected>{{ __('messages.active') }}</option>
                                <option value="0">{{ __('messages.inactive') }}</option>
                            </select>
                        </div>
                    </x-backend.quick-action>
                </div>
                <x-slot name="toolbar">
                    <div>
                        <div class="datatable-filter">
                            <select name="column_status" id="column_status" class="select2 form-control"
                                data-filter="select" style="width: 100%">
                                <option value="">{{ __('product.all')}}</option>
                                <option value="0" {{ $filter['status'] == '0' ? 'selected' : '' }}>
                                    {{ __('messages.inactive') }}</option>
                                <option value="1" {{ $filter['status'] == '1' ? 'selected' : '' }}>
                                    {{ __('messages.active') }}</option>
                            </select>
                            
                        </div>
                        
                    </div>
                    @if(enableMultivendor() == "1")
                    <div class="input-group flex-nowrap">
                        <div class="datatable-filter">
                            <select name="brand_rolewise" id="brand_rolewise" class="select2 form-control"
                                data-filter="select" style="width: 100%">
                                <option value="my_brand">
                                    {{ __('messages.my_brand') }}</option>
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('demo_admin'))
                                <option value="added_by_vendor">
                                    {{ __('messages.added_by_vendor') }}</option>
                                @endif
                                @unless(auth()->user()->hasRole('admin') || auth()->user()->hasRole('demo_admin'))
                                <option value="added_by_admin">
                                    {{ __('messages.added_by_admin') }}</option>
                                @endunless
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i
                                class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control dt-search" placeholder="Search..." aria-label="Search"
                            aria-describedby="addon-wrapping">
                    </div>
                    @hasPermission('add_brand')
                        <x-buttons.offcanvas target='#form-offcanvas' title="{{ __('messages.create') }} {{ __($module_title) }}">
                        {{ __('messages.create') }} {{ __('brand.singular_title') }}</x-buttons.offcanvas>
                    @endhasPermission
                    {{-- <button class="btn btn-outline-primary btn-group" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"><i
                            class="fa-solid fa-filter"></i>{{__('messages.advance_filter')}}</button> --}}
                </x-slot>
            </x-backend.section-header>
            <table id="datatable" class="table table-striped border table-responsive">
            </table>
        </div>
    </div>
    <div data-render="app">
        <brand-form-offcanvas default-image="{{default_feature_image()}}" create-title="{{ __('messages.create') }} {{ __('brand.singular_title') }}"
            edit-title="{{ __('messages.edit') }} {{ __($module_title) }}" :customefield="{{ json_encode($customefield) }}">
        </brand-form-offcanvas>
    </div>
    <x-backend.advance-filter>
        <x-slot name="title">
            <h4>{{ __('service.lbl_advanced_filter') }}</h4>
        </x-slot>
        <button type="reset" class="btn btn-danger" id="reset-filter">Reset</button>
    </x-backend.advance-filter>
@endsection

@push ('after-styles')
<link rel="stylesheet" href='{{ mix("modules/product/style.css") }}'>
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push ('after-scripts')
<script src='{{ mix("modules/product/script.js") }}'></script>
<script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>
<!-- DataTables Core and Extensions -->
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

<script type="text/javascript" defer>
        const columns = [

            {
                name: 'check',
                data: 'check',
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
                
                exportable: false,
                orderable: false,
                searchable: false,
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                title: "{{ __('service.sr_no') }}",
                orderable: false,
                searchable: false,
                
            },
            { data: 'feature_image', name: 'feature_image', title: "{{ __('category.lbl_image') }}"}, 
            {
                data: 'name',
                name: 'name',
                title: "{{ __('service.lbl_name') }}",
                
            },
            @if(enableMultivendor() == "1" && auth()->user()->hasRole('admin') || auth()->user()->hasRole('demo_admin'))
            {
                data: 'vendor_name',
                name: 'vendor_name',
                title: "{{ __('brand.vendor_name') }}",
                orderable: false,
            },
            @endif
            {
                data: 'updated_at',
                name: 'updated_at',
                orderable: true,
                searchable: true,
                
                title: "{{ __('service.updated_at') }}",
                visible: false,
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: true,
                title: "{{ __('service.lbl_status') }}",
                
            },
        ]


        const actionColumn = [{
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            title: "{{ __('service.lbl_action') }}",
            
        }]

        let finalColumns = [
            ...columns,
            ...actionColumn
        ]

        var orderColumn = [[ 4, "desc" ]];  
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('demo_admin'))
            orderColumn = [[ 5, "desc" ]];  
        @endif

        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
                orderColumn: orderColumn,
                advanceFilter: () => {
                    return {
                        brand_rolewise: $('#brand_rolewise').val(),
                    }
                }
            });
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

      $(document).on('update_quick_action', function() {
        // resetActionButtons()
      })
</script>
@endpush
