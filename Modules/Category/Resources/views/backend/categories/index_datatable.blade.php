@extends('backend.layouts.app')

@section('title')
    {{ __($module_title) }}
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ mix('modules/category/style.css') }}">
@endpush

@section('content')
    <div class="card">
    <div class="card-header">
        <x-backend.section-header>
            <div>
              <x-backend.quick-action url='{{route("backend.categories.bulk_action")}}'>
                {{-- <x-backend.quick-action> --}}
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
                    <select name="column_status" id="column_status" class="select2 form-control" data-filter="select" >
                      <option value="">{{__('category.all')}}</option>
                      <option value="1" {{$filter['status'] == '1' ? "selected" : ''}}>{{ __('messages.active') }}</option>
                      <option value="0" {{$filter['status'] == '0' ? "selected" : ''}}>{{ __('messages.inactive') }}</option>
                    </select>
                  </div>
                </div>
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping"><i class="icon-Search"></i></span>
                  <input type="text" class="form-control form-control-sm dt-search" placeholder="Search..." aria-label="Search" aria-describedby="addon-wrapping">
                  
                </div>
                @hasPermission('add_category')
                  <button type="button" title="{{ __('Create') }} Category / Sub Category" class="btn btn-primary d-flex align-items-center gap-1" data-crud-id="{{0}}"><i class="icon-add-new"></i>{{ __('messages.new') }}</button>
                @endhasPermission
            </x-slot>

            



          </x-backend.section-header>
    </div>
        <div class="card-body P-0">          
          <table id="datatable" class="table table-striped border table-responsive">
          </table>
        </div>
    </div>

    <div data-render="app">
      <form-offcanvas
              default-image="{{default_feature_image()}}"
              create-title="{{ __('messages.create') }} {{ __('messages.new') }} {{ __('category.lbl_category') }} / {{ __('category.sub_category') }}" edit-title="{{ __('messages.edit') }} {{ __('category.lbl_category') }} / {{ __('category.sub_category') }}"
              create-nested-title="{{ __('Create') }} {{ __('new') }} Sub {{ __($module_title) }}" edit-nested-title="{{ __('Edit') }} Sub {{ __($module_title) }}"
              :customefield="{{ json_encode($customefield) }}">
      </form-offcanvas>
    </div>
@endsection

@push('after-styles')
    <!-- DataTables Core and Extensions -->
    <link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push('after-scripts')
    <script src="{{ mix('modules/category/script.js') }}"></script>


    <!-- DataTables Core and Extensions -->
    <script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

    <script type="text/javascript" defer>

    const columns = [
            {
                name: 'check',
                data: 'check',
                title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
                width: '10%',
                exportable: false,
                orderable: false,
                searchable: false,
            },
            // { data: 'image', name: 'image', title: "{{ __('category.lbl_image') }}", width: '5%', orderable: false,},
            { data: 'name', name: 'name', title: "{{ __('category.lbl_name') }}", width: '15%'},
            { data: 'updated_at', name: 'updated_at',  title: "{{ __('category.lbl_updated_at') }}", width: '15%'},
            { data: 'created_at', name: 'created_at',  title: "{{ __('category.lbl_created_at') }}",width: '15%' },
            { data: 'status', name: 'status', orderable: true,  searchable: true, title: "{{ __('category.lbl_status') }}",width: '5%'},
        ]

        const actionColumn = [
            { data: 'action', name: 'action', orderable: false, searchable: false, title: "{{ __('category.lbl_action') }}", width: '5%'}
        ]

        const customFieldColumns = JSON.parse(@json($columns))

        let finalColumns = [
            ...columns,
            ...customFieldColumns,
            ...actionColumn
        ]

        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
                orderColumn: [[ 2, 'desc' ]],
            })
        })


        $(document).on('click', '[data-toggle="sub-category"]', function () {
            const categoryId = $(this).data('category-id')
		        const table = window.renderedDataTable;
            const tr = $(this).closest('tr');
            const row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                tr.find('[data-icon="plus"]').show()
                tr.find('[data-icon="minus"]').hide()
                window.renderedDataTable['category_id_'+categoryId] = undefined
            } else {
                row.child(nestedTable(categoryId), 'bg-soft-secondary p-3' ).show();
                ajaxNestedTable(categoryId)
                tr.addClass('shown');
                tr.find('[data-icon="plus"]').hide()
                tr.find('[data-icon="minus"]').show()
            }
        });

        function ajaxNestedTable(data_id){
          $.ajax({
                    type: 'get',
                    url: '{{ route("backend.$module_name.index_nested")}}',
                    data: {'category_id': data_id},
                    success: function (data) {
                        $('#nested-table-'+data_id).html(data);
                        $('#nested-table-'+data_id).addClass('fadeIn-animation');
                        $('#nested-table-'+data_id).css('min-height', '9rem')
                    }
                });
        }
        function nestedTable(id) {
            // `d` is the original data object for the row
            return '<div id="nested-table-'+id+'" class="card  card-body mb-0"></div>';
		}

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

      $(document).on('update_quick_action', function() {
        // resetActionButtons()
      })

    </script>
@endpush
