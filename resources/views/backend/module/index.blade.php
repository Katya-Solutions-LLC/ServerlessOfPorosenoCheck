@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@push('after-styles')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <x-backend.section-header>
            <div>

            </div>
            <x-slot name="toolbar">

              <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><i class="icon-Search"></i></span>
                <input type="text" class="form-control form-control-sm dt-search" placeholder="Search..." aria-label="Search" aria-describedby="addon-wrapping">
                
              </div>

                <x-buttons.offcanvas target='#form-offcanvas' class=" d-flex align-items-center gap-1" title="{{ __('Create') }} {{ __($module_title) }}">{{ __('messages.new') }}</x-buttons.offcanvas>

            </x-slot>
          </x-backend.section-header>
        </div>
        <div class="card-body p-0">
          <table id="datatable" class="table table-striped border table-responsive">
          </table>
        </div>
    </div>

    <div data-render="app">
        <module-form-offcanvas
            create-title="{{ __('Create') }} {{ __('New') }} {{ __($module_title) }}"
            edit-title="{{ __('Edit') }} {{ __($module_title) }}"
             >
        </module-form-offcanvas>

    </div>
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
             {
                name: 'check',
                data: 'check',
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
                width: '5%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            { data: 'module_name', name: 'module_name', title: "{{ __('page.lbl_name') }}" },
            // { data: 'status', name: 'status', orderable: false, searchable: true,  title: "{{ __('page.lbl_status') }}" },
        ]

        const actionColumn = [
            { data: 'action', name: 'action', orderable: false, searchable: false, title: "{{ __('page.lbl_action') }}",  width: '5%', }
        ]

        let finalColumns = [
            ...columns,
            ...actionColumn
        ]

        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
            })
        })



    </script>
@endpush
