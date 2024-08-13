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
                <!-- <option value="delete">{{ __('messages.delete') }}</option> -->
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
            
            <!-- <x-buttons.offcanvas target='#form-offcanvas' title="{{ __('Create') }} {{ __($module_title) }}">{{ __('messages.new') }}</x-buttons.offcanvas> -->
            
        </x-slot>
        </x-backend.section-header>
    </div>
  <div class="card-body p-0">
    
        <table id="datatable" class="table table-striped border table-responsive">
    </table>
  </div>
</div>
    <div data-render="app">
        <system-service-form-offcanvas create-title="{{ __('messages.create') }} {{ __($craete_title) }}"
            edit-title="{{ __('messages.edit') }} {{ __($craete_title) }}" :customefield="{{ json_encode($customefield) }}">
        </system-service-form-offcanvas>
        <assign-employee-form-offcanvas></assign-employee-form-offcanvas>
        <assign-branch-form-offcanvas></assign-branch-form-offcanvas>
        <gallery-form-offcanvas></gallery-form-offcanvas>
    </div>
@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <script src="{{ mix('modules/service/script.js') }}"></script>
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
                data: 'image',
                name: 'image',
                title:  "{{ __('service.lbl_image') }}",
                orderable: false,
                width: '0%'
            },
            {
                data: 'name',
                name: 'name',
                title: "{{ __('service.lbl_name') }}"
            },
            {
                data: 'description',
                name: 'description',
                title: "{{__('service.lbl_description')}}"
            },
            {
                data: 'status',
                name: 'status',
                orderable: true,
                searchable: true,
                title: "{{ __('service.lbl_status') }}",
                width: '10%'
            },
        
        ]


        const actionColumn = [{
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false,
            title: "{{ __('service.lbl_action') }}",
            width: '5%'
        }]

        const customFieldColumns = JSON.parse(@json($columns))

        let finalColumns = [
            ...columns,
            ...customFieldColumns,
            ...actionColumn
        ]

        // document.addEventListener('DOMContentLoaded', (event) => {
        //     initDatatable({
        //         url: '{{ route("backend.$module_name.index_data") }}',
        //         finalColumns,
        //         advanceFilter: () => {
        //             return {
        //               category_id: $('#column_category').val(), // Add category filter value
        //               sub_category_id: $('#column_subcategory').val(), // Add subcategory filter value
        //             }
        //         }
        //     })

        // })

        // $('#reset-filter').on('click', function(e) {
        //   $('#column_category').val('')
        //   $('#column_subcategory').val('')
        //   window.renderedDataTable.ajax.reload(null, false)
        // })

        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.service.systemservice.index_data") }}',
                finalColumns,
                advanceFilter: () => {
                    return {
                        category_id: $('#column_category').val(), // Add category filter value
                        sub_category_id: $('#column_subcategory').val(), // Add subcategory filter value
                    }
                }
            });

            // Event listener for category selection change
            $('#column_category').on('change', function() {
                var selectedCategoryId = $(this).val();
                filterSubcategories(selectedCategoryId);
            });

            // Function to filter subcategories based on the selected category
            function filterSubcategories(selectedCategoryId) {
                var $subcategorySelect = $('#column_subcategory');
                $subcategorySelect.empty();

                // Add the default option
                $subcategorySelect.append('<option value="">All Sub-Categories</option>');

                if (selectedCategoryId) {
                    var filteredSubcategories = @json($subcategories);
                    filteredSubcategories = filteredSubcategories.filter(function(subcategory) {
                        return subcategory.parent_id == selectedCategoryId;
                    });

                    filteredSubcategories.forEach(function(subcategory) {
                        $subcategorySelect.append('<option value="' + subcategory.id + '">' + subcategory
                            .name + '</option>');
                    });
                } else {
                    @foreach ($subcategories as $subcategory)
                        $subcategorySelect.append(
                            '<option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>');
                    @endforeach
                }
            }

            $('#reset-filter').on('click', function(e) {
                $('#column_category').val('');
                $('#column_subcategory').val('');
                filterSubcategories('');
                window.renderedDataTable.ajax.reload(null, false);
            });

            // Initialize subcategory options based on the initial selected category
            filterSubcategories($('#column_category').val());
        });


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
    </script>
@endpush
