@extends('backend.layouts.app')

@section('title')
     {{ __($module_title) }}
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/earning/style.css') }}">
@endpush

@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table id="datatable" class="table table-striped border table-responsive">
            </table>
        </div>
    </div>
    <div data-render="app">
        <view-commissions-offcanvas></view-commissions-offcanvas>
        <earning-form-offcanvas create-title="{{ __('Create') }} {{ __($module_title) }}"
            edit-title="{{ __('Create') }} {{ __('Staff Payout') }} " commission-type="order"></earning-form-offcanvas>

           
    </div>
@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <!-- DataTables Core and Extensions -->
    <script src="{{ mix('modules/earning/script.js') }}"></script>
    <script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', (event) => {
            window.renderedDataTable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                dom: '<"row align-items-center"><"table-responsive my-3" rt><"row align-items-center px-3 mb-3" <"col-md-6" l><"col-md-6" p>><"clear">',
                ajax: {
                    "type"   : "GET",
                    "url"    : '{{ route("backend.$module_name.index_data") }}',
                    "data"   : function( d ) {
                    d.search = {
                        value: $('.dt-search').val()
                    };
                    d.filter = {
                        column_status: $('#column_status').val()
                    }
                    },
                },
                columns: [
                   {
                         data: 'user_id',
                         name: 'user_id',
                         title: "{{__('employee.lbl_name')}}",
                         orderable: true,
                         searchable: true,
                     },
                    { data: 'total_orders', name: 'total_orders', title: "{{ __('earning.lbl_tot_orders') }}", orderable: false},
                    { data: 'total_order_amount', name: 'total_order_amount', title: "{{ __('earning.lbl_total_earning') }}", orderable: false },
                    { data: 'total_commission_earn', name: 'total_commission_earn', title: "{{ __('earning.lbl_total_commission') }}", orderable: false },
                    { data: 'total_admin_earning', name: 'total_admin_earning', title: "{{ __('earning.lbl_admin_earnings') }}", orderable: false, searchable: false },
                    { data: 'total_pay', name: 'total_pay', title: "{{ __('earning.lbl_staff_earning') }}", orderable: false },
                    { data: 'action', name: 'action', title: "{{ __('earning.lbl_action') }}", orderable: false, searchable: false }
                ]
            });
        })


        const formOffcanvas = document.getElementById('form-offcanvas')

        const instance = bootstrap.Offcanvas.getOrCreateInstance(formOffcanvas)

        $(document).on('click', '[data-crud-id]', function() {
            setEditID($(this).attr('data-crud-id'), $(this).attr('data-parent-id'))
        })

        function test(){

            alert(132);
        }

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
    </script>
@endpush
