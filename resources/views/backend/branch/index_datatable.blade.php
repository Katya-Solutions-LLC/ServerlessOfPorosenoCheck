@extends('backend.layouts.app')

@section('title')
{{ __($module_action) }} {{ __($module_title) }}
@endsection

@push('after-styles')
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <!-- <x-backend.section-header>
            <div>
                <x-backend.quick-action url="{{route('backend.branch.bulk_action')}}">
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
                <div>
                    <div class="datatable-filter">
                        <select name="column_status" id="column_status" class="select2 form-control p-10"
                            data-filter="select" style="width: 100%">
                            <option value="">All</option>
                            <option value="0" {{$filter['status'] == '0' ? "selected" : ''}}>
                                {{ __('messages.inactive') }}</option>
                            <option value="1" {{$filter['status'] == '1' ? "selected" : ''}}>{{ __('messages.active') }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="input-group flex-nowrap">
                     <span class="input-group-text" id="addon-wrapping"><i
                            class="icon-Search"></i></span>
                    <input type="text" class="form-control form-control-sm dt-search" placeholder="Search..." aria-label="Search"
                        aria-describedby="addon-wrapping">
                   
                </div>

            </x-slot>
        </x-backend.section-header> -->
    </div>
    <div class="card-body p-0">
        
        <table id="datatable" class="table table-striped border table-responsive">
        </table>
    <div data-render="app">
        <branch-form-offcanvas
            create-title="{{ __('Create') }} {{ __('New') }} {{ __($module_title) }}"
            edit-title="{{ __('Edit') }} {{ __($module_title) }}"
            select-data="{{json_encode($select_data)}}"
            :customefield="{{ json_encode($customefield) }}">
        </branch-form-offcanvas>
        <branch-gallery-offcanvas></branch-gallery-offcanvas>
        <assign-branch-employee-offcanvas></assign-branch-employee-offcanvas>
    </div>
</div>
</div>

<!-- <div data-render="app">
    <branch-form-offcanvas
        create-title="{{ __('Create') }} {{ __('New') }} {{ __($module_title) }}"
        edit-title="{{ __('Edit') }} {{ __($module_title) }}" 
        select-data="{{json_encode($select_data)}}"
        :customefield="{{ json_encode($customefield) }}">
    </branch-form-offcanvas>
    <branch-gallery-offcanvas></branch-gallery-offcanvas>
</div> -->
@endsection

@push('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <script src="{{ mix('js/vue.min.js') }}"></script>
    <script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>

    <!-- DataTables Core and Extensions -->
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

    <script type="text/javascript" defer>


    const columns = [
            // {
            //     name: 'check',
            //     data: 'check',
            //     title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
            //     width: '0%',
            //     exportable: false,
            //     orderable: false,
            //     searchable: false,
            // },
            { data: 'image', name: 'image', title: "{{ __('branch.lbl_image') }}", orderable: false, width: '15%' },
            { data: 'name', name: 'name', title: "{{ __('branch.lbl_name') }}" ,width: '15%', },
            { data: 'contact_number', name: 'contact_number', title: "{{ __('branch.lbl_contact_number') }}" ,width: '15%',},
            { data: 'address.city', name: 'address.city', title: "{{ __('branch.lbl_city') }}" ,width: '15%',},
            { data: 'address.postal_code', name: 'address.postal_code', title: "{{ __('branch.lbl_postal_code') }}" ,width: '10%',},
            // { data: 'branch_for', name: 'branch_for', title: "{{ __('branch.lbl_branch_for') }}", width: '12%' },
            // { data: 'status', name: 'status', orderable: true, searchable: true, title: "{{ __('branch.lbl_status') }}", width: '5%', },

        ]

        const actionColumn = [
            { data: 'action', name: 'action', orderable: false, searchable: false, title: "{{ __('branch.lbl_action') }}", width: '5%' }
        ]

        const customFieldColumns = JSON.parse(@json($columns))

        let finalColumns = [
            ...columns,
            ...customFieldColumns,
            ...actionColumn
        ]

        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url    : '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
            })
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

$('#quick-action-type').change(function() {
    resetQuickAction()
});
</script>
@endpush