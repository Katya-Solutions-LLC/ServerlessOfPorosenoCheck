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
                    <div class="datatable-filter" style="width: 100%; display: inline-block;">
                        {{$filter['status']}}
                        <select name="column_status" id="column_status" class="select2 form-control"
                            data-filter="select">
                            <option value="">{{__('product.all')}}</option>
                            <option value="1" {{$filter['status'] == '1' ? "selected" : ''}}>Active</option>
                            <option value="0" {{$filter['status'] == '0' ? "selected" : ''}}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="icon-Search"></i></span>
                    <input type="text" class="form-control form-control-sm dt-search" placeholder="Search..."
                        aria-label="Search" aria-describedby="addon-wrapping">
                    
                </div>
                @hasPermission('add_page')
                <x-buttons.offcanvas target='#form-offcanvas' class=" d-flex align-items-center gap-1" title="{{ __('Create') }} {{ __($module_title) }}">
                    {{ __('messages.new') }}</x-buttons.offcanvas>
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

    <page-offcanvas create-title="{{ __('messages.create') }} {{ __($module_title) }}"
        edit-title="{{ __('messages.edit') }} {{ __($module_title) }}">
    </page-offcanvas>

    <x-backend.advance-filter>
        <x-slot name="title">
            <h4>Advanced Filter</h4>
        </x-slot>
        <select name="" id="" class="select2">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
    </x-backend.advance-filter>
</div>
@endsection

@push('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
<script src="{{ mix('modules/page/script.js') }}"></script>
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
        data: 'name',
        name: 'name',
        title: "{{ __('page.lbl_title') }}"
    },
    {
        data: 'status',
        name: 'status',
        orderable: true,
        searchable: true,
        title: "{{ __('page.lbl_status') }}"
    },
]

const actionColumn = [{
    data: 'action',
    name: 'action',
    orderable: false,
    searchable: false,
    title: "{{ __('page.lbl_action') }}"
}]

let finalColumns = [
    ...columns,
    ...actionColumn
]

document.addEventListener('DOMContentLoaded', (event) => {
    initDatatable({
        url: '{{ route("backend.$module_name.index_data") }}',
        finalColumns,
        orderColumn: [[ 2, 'desc' ]],
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

function copyUrl(event, id) {

    event.preventDefault();
    var urlToCopy = document.getElementById("myLink_" + id).href;

    var tempInput = document.createElement("input");
    tempInput.style = "position: absolute; left: -1000px; top: -1000px";
    tempInput.value = urlToCopy;

    document.body.appendChild(tempInput);


    tempInput.select();
    document.execCommand("copy");


    document.body.removeChild(tempInput);

    window.successSnackbar('Copy Page Url !')

}
</script>
@endpush