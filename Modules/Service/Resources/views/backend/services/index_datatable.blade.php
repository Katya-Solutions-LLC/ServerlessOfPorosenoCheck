@extends('backend.layouts.app', ['isNoUISlider' => true])

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
                        <!-- <div class="datatable-filter">
                            <select name="column_status" id="column_status" class="select2 form-control"
                                data-filter="select" style="width: 100%">
                                <option value="">{{__('service.all')}}</option>
                                <option value="0" {{ $filter['status'] == '0' ? 'selected' : '' }}>
                                    {{ __('messages.inactive') }}</option>
                                <option value="1" {{ $filter['status'] == '1' ? 'selected' : '' }}>
                                    {{ __('messages.active') }}</option>
                            </select>
                        </div> -->
                        <x-backend.quick-action url="{{ route('backend.services.bulk_action') }}">
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
                                    <option value="1">{{ __('messages.active') }}</option>
                                    <option value="0">{{ __('messages.inactive') }}</option>
                                </select>
                            </div>
                        </x-backend.quick-action>
                    </div>
                    <x-slot name="toolbar">
                    @if(auth()->user()->hasRole('vet')||auth()->user()->hasRole('groomer'))
                         <div>
                            <div class="datatable-filter">
                                <select name="column_service_type" id="column_service_type" class="select2 form-control"
                                    data-filter="select" style="width: 100%">
                                    <option value="all" {{ $filter['column_service_type'] == 'all' ? 'selected' : '' }}>{{__('product.all')}}</option>
                                    <option value="added_by_me" {{ $filter['column_service_type'] == 'added_by_me' ? 'selected' : '' }}>
                                        {{ __('messages.added_by_me') }}</option>
                                    <option value="assign_by_admin" {{ $filter['column_service_type'] == 'assign_by_admin' ? 'selected' : '' }}>
                                        {{ __('messages.assign_by_admin') }}</option>
                                </select>
                            </div>
                        </div>
                        @endif

                        <div>
                            <div class="datatable-filter">
                                <select name="column_status" id="column_status" class="select2 form-control"
                                    data-filter="select" style="width: 100%">
                                    <option value="">{{__('product.all')}}</option>
                                    <option value="0" {{ $filter['status'] == '0' ? 'selected' : '' }}>
                                        {{ __('messages.inactive') }}</option>
                                    <option value="1" {{ $filter['status'] == '1' ? 'selected' : '' }}>
                                        {{ __('messages.active') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id="addon-wrapping"><i class="icon-Search"></i></span>
                            <input type="text" class="form-control form-control-sm dt-search" placeholder="Search..." aria-label="Search" aria-describedby="addon-wrapping">
                            
                        </div>
                        @hasPermission('add_service')
                            <x-buttons.offcanvas target='#form-offcanvas' title="{{ __('Create') }} {{ __($create_title) }}" class=" d-flex align-items-center gap-1">
                            {{ __('messages.new') }}</x-buttons.offcanvas>
                        @endhasPermission
                        <!-- <button class="btn btn-outline-primary btn-group" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"><i
                                class="fa-solid fa-filter"></i> Advanced Filter</button> -->
                    </x-slot>
                </x-backend.section-header>
        </div>
        <div class="card-body ">            
            <table id="datatable" class="table table-striped border table-responsive">
            </table>
        </div>
    </div>
    <div data-render="app">
        <service-form-offcanvas create-title="{{ __('messages.create') }} {{ __($create_title) }}"
            edit-title="{{ __('messages.edit') }} {{ __($create_title) }}" :customefield="{{ json_encode($customefield) }}">
        </service-form-offcanvas>
        <assign-employee-form-offcanvas type="{{ __($type) }}"></assign-employee-form-offcanvas>
        <assign-branch-form-offcanvas></assign-branch-form-offcanvas>
        <gallery-form-offcanvas></gallery-form-offcanvas>
    </div>
    <x-backend.advance-filter>
        <x-slot name="title">
            <h4>{{ __('service.lbl_advanced_filter') }}</h4>
        </x-slot>
        <div class="form-group datatable-filter">
            <label class="form-label" for="column_category">{{ __('service.lbl_category') }}</label>
            <select name="column_category" id="column_category" class="form-control select2" data-filter="select">
                <option value="">{{__('service.all_categories')}}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group datatable-filter">
            <label class="form-label" for="column_subcategory">{{ __('service.lbl_sub_category') }}</label>
            <select name="column_subcategory" id="column_subcategory" class="form-control select2" data-filter="select">
                <option value="">{{__('service.all_sub_cat')}}</option>
                @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="reset" class="btn btn-danger" id="reset-filter">Reset</button>
        <div class="form-group custom-range">
            <div class="filter-slider slider-secondary"></div>
        </div>
    </x-backend.advance-filter>
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
                title: "{{ __('service.lbl_service_name') }}"
            },
            {
                data: 'default_price',
                name: 'default_price',
                title: "{{ __('service.lbl_default_price') }}"
            },
            {
                data: 'duration_min',
                name: 'duration_min',
                title: "{{ __('service.lbl_duration') }}"
            },

            {
                data: 'category_id',
                name: 'category_id',
                title: "{{ __('service.lbl_category_id') }}"
            },
            { 
                data: 'updated_at', 
                name: 'updated_at',  
                title: "{{ __('service.lbl_updated_at') }}", 
                width: '15%',
                visible: false
            },
            @if (!$is_single_branch)
                {
                    data: 'branches_count',
                    name: 'branches_count',
                    title: "{{ __('service.lbl_branches') }}",
                    orderable: true,
                    searchable: false,
                },
            @endif
            @if(auth()->user()->hasRole('admin')|| auth()->user()->hasRole('demo_admin'))
            { data: 'employee_count', name: 'employee_count', title: "{{ __('service.lbl_staffs') }}", orderable: true, searchable: false,  },
            @endif
            {
                data: 'status',
                name: 'status',
                orderable: true,
                searchable: true,
                title: "{{ __('service.lbl_status') }}",
                width: '5%'
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
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
                orderColumn: [[ 6, 'desc' ]],
                advanceFilter: () => {
                    return {
                        category_id: $('#column_category').val(), // Add category filter value
                        sub_category_id: $('#column_subcategory').val(), // Add subcategory filter value

                         column_service_type: $('#column_service_type').val(), // Add subcategory filter value

                        
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
                 $('#column_service_type').val('');
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
