@extends('backend.layouts.app')

@section('title') {{ __($module_title) }} @endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <x-backend.section-header>
                <div class="d-flex flex-wrap gap-3">
                    <x-backend.quick-action url="{{ route('backend.products.bulk_action') }}">
                        <div class="">
                            <select name="action_type" class="form-control select2 col-12" id="quick-action-type"
                                style="width:100%">
                                <option value="">{{ __('messages.no_action') }}</option>
                                <option value="change-is_featured">{{ __('product.lbl_featured') }}</option>
                                <option value="change-status">{{ __('messages.status') }}</option>
                                <option value="delete">{{ __('messages.delete') }}</option>
                            </select>
                        </div>
                        <div class="select-is_featured d-none quick-action-field" id="change-is_featured-action">
                            <select name="is_featured" class="form-control select2" id="is_featured" style="width:100%">
                                <option value="1" selected>{{ __('messages.yes') }}</option>
                                <option value="0">{{ __('messages.no') }}</option>
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
                        <div class="datatable-filter" style="width: 100%; display: inline-block;">
                            <select name="column_status" id="column_status" class="select2 form-control"
                                data-filter="select">
                                <option value="">{{ __('product.all')}}</option>
                                <option value="0" {{ $filter['status'] == '0' ? 'selected' : '' }}>
                                    {{ __('messages.inactive') }}</option>
                                <option value="1" {{ $filter['status'] == '1' ? 'selected' : '' }}>
                                    {{ __('messages.active') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i
                                class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" class="form-control dt-search" placeholder="Search..." aria-label="Search"
                            aria-describedby="addon-wrapping">
                    </div>
                    @hasPermission('add_product')
                        <x-buttons.offcanvas target='#form-offcanvas' title="{{ __('messages.create') }} {{ __($module_title) }}">
                        {{ __('messages.create') }} {{ __('product.singular_title') }}</x-buttons.offcanvas>
                    @endhasPermission

                </x-slot>
            </x-backend.section-header>
            <table id="datatable" class="table table-striped border table-responsive product-table">
            </table>
        </div>
    </div>
    <div data-render="app">
        <product-form-offcanvas create-title="{{ __('messages.create') }} {{ __('product.singular_title') }}"
            edit-title="{{ __('messages.edit') }} {{ __($module_title) }}">
        </product-form-offcanvas>
        <product-gallery-offcanvas></product-gallery-offcanvas>
        <stock-offcanvas></stock-offcanvas>
    </div>
    <x-backend.advance-filter>
        <x-slot name="title">
            <h4>{{ __('service.lbl_advanced_filter') }}</h4>
        </x-slot>

          <div class="form-group datatable-filter">

             <div class="form-group datatable-filter">
              <label class="form-label" for="column_brand">{{ __('product.brand') }}</label>
              <select name="column_brand" id="column_brand" class="form-control select2" data-filter="select">
                  <option value="">{{ __('product.all_brand')}}</option>
                  @foreach ($brands as $brand)
                      <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                  @endforeach
              </select>
            </div>

            <label class="form-label" for="column_category">{{ __('service.lbl_category') }}</label>
            <select name="column_category" id="column_category" class="form-control select2" data-filter="select">
                <option value="">{{ __('product.all_categories')}}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

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
<script src="{{ asset('js/form-modal/index.js') }}" defer></script>
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
            {   data: 'image',
                name: 'image',
                title: "{{ __('category.lbl_image') }}",
                width: '7%',
                orderable: false,},
            {
                data: 'name',
                name: 'name',
                title: "{{ __('product.name') }}"
            },
            {
                data: 'brand',
                name: 'brand',
                title: "{{ __('product.brand') }}"
            },
            {
                data: 'categories',
                name: 'categories',
                title: "{{ __('product.categories') }}",
                orderable: false,
            },
            {
                data: 'min_price',
                name: 'min_price',
                title: "{{ __('product.price') }}"
            },
            {
                data: 'stock_qty',
                name: 'stock_qty',
                title: "{{ __('product.quantity') }}",
                 width: '7%',
            },
            {
                data: 'is_featured',
                name: 'is_featured',
                orderable: true,
                searchable: true,
                title: "{{ __('product.lbl_featured') }}",
                width: '5%'
            },
            {
                data: 'status',
                name: 'status',
                orderable: true,
                searchable: true,
                title: "{{ __('product.lbl_status') }}",
                width: '5%'
            },
            {
              data: 'updated_at',
              name: 'updated_at',
              title: "{{ __('product.lbl_update_at') }}",
              orderable: true,
             visible: false,
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

        let finalColumns = [
            ...columns,
            ...actionColumn
        ]

        document.addEventListener('DOMContentLoaded', (event) => {
            initDatatable({
                url: '{{ route("backend.$module_name.index_data") }}',
                finalColumns,
                orderColumn: [[ 9, "desc" ]],
                paging: true,
                advanceFilter: () => {
                    return {
                          brand_id: $('#column_brand').val(),
                          category_id: $('#column_category').val(),
                    }
                }
            });

               // Event listener for category selection change
            $('#column_brand').on('change', function() {
                var selectedBrandId = $(this).val();
                filtercategories(selectedBrandId);
            });

            // Function to filter subcategories based on the selected category
            function filtercategories(selectedBrandId) {
                var $categorySelect = $('#column_category');
                $categorySelect.empty();

                // Add the default option
                $categorySelect.append('<option value="">All Categories</option>');

                if (selectedBrandId) {
                    var filtercategories = @json($categories);
                    filtercategories = filtercategories.filter(function(category) {
                        return category.brand_id == selectedBrandId;
                    });

                    filtercategories.forEach(function(category) {
                        $categorySelect.append('<option value="' + category.id + '">' + category
                            .name + '</option>');
                    });
                } else {
                    @foreach ($categories as $category)
                        $categorySelect.append(
                            '<option value="{{ $category->id }}">{{ $category->name }}</option>');
                    @endforeach
                }
            }

            $('#reset-filter').on('click', function(e) {
                $('#column_brand').val('');
                $('#column_category').val('');
                filtercategories('');
                window.renderedDataTable.ajax.reload(null, false);
            });


            filtercategories($('#column_category').val());

        })



        function resetQuickAction() {
          const actionValue = $('#quick-action-type').val();
          if (actionValue != '') {
              $('#quick-action-apply').removeAttr('disabled');
              $('.quick-action-field').addClass('d-none');
              if (actionValue == 'change-status') {
                  $('#change-status-action').removeClass('d-none');
              } if (actionValue == 'change-is_featured') {
                $('#change-is_featured-action').removeClass('d-none');
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
