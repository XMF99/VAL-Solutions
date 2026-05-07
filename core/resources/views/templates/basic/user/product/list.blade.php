@extends($activeTemplate . 'layouts.master')
@section('panel')
    <div class="row">
        <div class="col-12">
            <x-panel.ui.card>
                <x-panel.ui.card.body :paddingZero=true>
                    <x-panel.ui.table.layout>
                        <x-panel.ui.table>
                            <x-panel.ui.table.header>
                                <tr>
                                    <th>@lang('Product')</th>
                                    <th>@lang('Brand')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Sale Price')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </x-panel.ui.table.header>
                            <x-panel.ui.table.body>
                                @forelse($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2 flex-wrap justify-content-start">
                                                <span class="table-thumb">
                                                    <img src="{{ $product->image_src }}">
                                                </span>
                                                <div>
                                                    <strong class="d-block text-start">
                                                        {{ strLimit(__(@$product->name), 25) }}
                                                    </strong>
                                                    <span>
                                                        {{ __(@$product->product_code) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ __(@$product->brand->name) }}</td>
                                        <td>{{ __(@$product->category->name) }}</td>
                                        <td>
                                            {{ showAmount($product->details->min('final_price')) }}
                                            @if ($product->product_type == Status::PRODUCT_TYPE_VARIABLE)
                                                - {{ showAmount($product->details->max('final_price')) }}
                                            @endif
                                        </td>
                                        <td>
                                            <x-panel.other.status_switch :status="$product->status" :action="route('user.product.status.change', $product->id)"
                                                title="product" />
                                        </td>
                                        <td class="dropdown">
                                            @if (request()->trash)
                                                <button type="button" class="btn btn-outline--success confirmationBtn"
                                                    data-question='@lang('Are you sure to restore this product?')'
                                                    data-action="{{ route('user.product.trash.restore', $product->id) }}">
                                                    <i class="las la-undo"></i>
                                                    @lang('Restore')
                                                </button>
                                            @else
                                                <button class=" btn btn-outline--primary" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    @lang('Action') <i class="las la-angle-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown">
                                                    <x-staff_permission_check permission="edit product">
                                                        <a class="dropdown-list d-block"
                                                            href="{{ route('user.product.edit', $product->id) }}">
                                                            <span class="me-2">
                                                                <i class="las la-pencil-alt text--primary"></i>
                                                            </span>
                                                            @lang('Edit Product')
                                                        </a>
                                                    </x-staff_permission_check>
                                                    <x-staff_permission_check permission="view product">
                                                        <a class="dropdown-list d-block"
                                                            href="{{ route('user.product.view', $product->id) }}">
                                                            <span class="me-2">
                                                                <i class="las la-eye text--success"></i>
                                                            </span>
                                                            @lang('View Product')
                                                        </a>
                                                    </x-staff_permission_check>
                                                    <x-staff_permission_check permission="add purchase">
                                                        <a class="dropdown-list d-block"
                                                            href="{{ route('user.purchase.add') }}?product_code={{ $product->product_code }}">
                                                            <span class="me-2">
                                                                <i class="las la-plus text--info"></i>
                                                            </span>
                                                            @lang('Add Stock')
                                                        </a>
                                                    </x-staff_permission_check>
                                                    <x-staff_permission_check permission="print product barcode">
                                                        <a class="dropdown-list d-block"
                                                            href="{{ route('user.product.print.label') }}?product_code={{ $product->product_code }}">
                                                            <span class="me-2">
                                                                <i class="las la-barcode text--dark"></i>
                                                            </span>
                                                            @lang('Print Label')
                                                        </a>
                                                    </x-staff_permission_check>
                                                    <x-staff_permission_check permission="trash product">
                                                        <button type="button" class="dropdown-list d-block confirmationBtn"
                                                            data-question='@lang('Are you sure to move this product to trash?')'
                                                            data-action="{{ route('user.product.trash.temporary', $product->id) }}">
                                                            <span class="me-2">
                                                                <i class="las la-trash text--danger"></i>
                                                            </span>
                                                            @lang('Trash Product')
                                                        </button>
                                                    </x-staff_permission_check>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <x-panel.ui.table.empty_message />
                                @endforelse
                            </x-panel.ui.table.body>
                        </x-panel.ui.table>
                        @if ($products->hasPages())
                            <x-panel.ui.table.footer>
                                {{ paginateLinks($products) }}
                            </x-panel.ui.table.footer>
                        @endif
                    </x-panel.ui.table.layout>
                </x-panel.ui.card.body>
            </x-panel.ui.card>
        </div>
    </div>


    <x-panel.ui.modal class="importModal progressModal modal-xl">
        <x-panel.ui.modal.header>
            <div>
                <h5 class="modal-title">@lang('Import Products')</h5>
                <p class="text mb-0">@lang('Select your file to import products')</p>
            </div>
            <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
        </x-panel.ui.modal.header>
        <x-panel.ui.modal.body>
            <div class="py-2">
                <div class="row gy-3">
                    <div class="col-lg-12">
                        <div class=" custom-border rounded-3 p-3 p-sm-4 d-flex flex-column">
                            <h5 class="mb-3 text--primary">@lang('Import Instructions')</h5>
                            <ol class="instruction-list mb-0">
                                <li class="instruction-list__item">@lang('Download the sample template file to ensure the correct format.')</li>
                                <li class="instruction-list__item">@lang('Keep all column names unchanged.')</li>
                                <li class="instruction-list__item">
                                    @lang('Optional fields (can be blank if not applicable):')
                                    <code>@lang('product_code')</code>,
                                    <code>@lang('sku')</code>,
                                    <code>@lang('tax_name')</code>,
                                    <code>@lang('tax_type')</code>,
                                    <code>@lang('tax_percentage')</code>,
                                    <code>@lang('discount_type')</code>,
                                    <code>@lang('discount_value')</code>
                                </li>
                                <li class="instruction-list__item">@lang('If tax_name is filled, tax_type (inclusive/exclusive) and tax_percentage are required.')</li>
                                <li class="instruction-list__item">@lang('If no tax applies, leave all tax fields blank.')</li>
                                <li class="instruction-list__item">
                                    @lang('discount_type must be either fixed or percentage. discount_value represents the amount of discount based on the selected type (fixed amount or percentage value).')
                                </li>
                                <li class="instruction-list__item">@lang('Category, brand, and unit must already exist in the system.')</li>
                                <li class="instruction-list__item">
                                    @lang('<code>product_code</code> and <code>sku</code> will be auto-generated if left blank.')
                                </li>
                                <li class="instruction-list__item">
                                    @lang('Only :csv files are supported and the maximum file size is :2MB.', ['csv' => '<code>.CSV</code>', '2MB' => '<code>2MB</code>'])
                                </li>
                            </ol>
                            <div class="mt-2 ps-2">
                                <a href="{{ route('user.product.csv.download') }}" class="btn btn--white btn--sm">
                                    <i class="la la-download"></i> @lang('Download Sample File')
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="custom-border rounded-3 p-3 p-sm-4">
                            <h6 class="mb-3">@lang('Upload File')</h6>
                            <div class="thumb-form-wrapper">
                                <form action="{{ route('user.product.import') }}" method="POST" id="import-form"
                                    enctype="multipart/form-data" class="no-submit-loader">
                                    @csrf
                                    <div class="row gy-3">
                                        <div class="col-12">
                                            <div class="thumb-form upload-dropzone">
                                                <input id="import-file" type="file" class="form--control drag-drop"
                                                    name="file" accept=".csv">
                                                <label for="import-file" class="upload-dropzone__label">
                                                    <span class="upload-dropzone__icon">
                                                        <i class="las la-cloud-upload-alt"></i>
                                                    </span>
                                                    <span class="upload-dropzone__title">@lang('Drag & drop your file here')</span>
                                                    <span class="upload-dropzone__subtitle">@lang('or click to browse')</span>

                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                                <button type="button" class="btn btn--secondary btn-large"
                                                    data-bs-dismiss="modal">
                                                    <i class="fa-solid fa-xmark"></i> @lang('Close')
                                                </button>
                                                <button type="submit" class="btn btn--primary btn-large">
                                                    <i class="fa-solid fa-file-arrow-down"></i> @lang('Import Product')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </x-panel.ui.modal.body>
    </x-panel.ui.modal>




    <x-confirmation-modal />
@endsection


@push('breadcrumb-plugins')
    <x-staff_permission_check permission="add product">
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn  btn-outline--info importBtn">
                <i class="las la-upload"></i> @lang('Import Products')
            </button>
            <x-panel.ui.btn.add href="{{ route('user.product.create') }}" />
        </div>
    </x-staff_permission_check>
@endpush

@push('style')
    <style>
        .btn-outline--primary i {
            transition: .2s linear;
        }

        .btn-outline--primary.show i {
            transform: rotate(180deg);
        }

        .upload-dropzone {
            position: relative;
            border: 1px dashed rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.02));
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease, transform .2s ease;
            min-height: 180px;
        }

        .upload-dropzone__label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 28px 18px;
            cursor: pointer;
            text-align: center;
        }

        .upload-dropzone__icon {
            width: 56px;
            height: 56px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: rgba(84, 125, 255, 0.12);
            color: #6d8bff;
            font-size: 28px;
            box-shadow: inset 0 0 0 1px rgba(109, 139, 255, 0.25);
        }

        .upload-dropzone__title {
            font-weight: 600;
            color: #dfe6ff;
        }

        .upload-dropzone__subtitle {
            color: rgba(255, 255, 255, 0.65);
            font-size: 13px;
        }

        .upload-dropzone .form--control {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .thumb-form.drag-over,
        .upload-dropzone:hover {
            border-color: rgba(109, 139, 255, 0.8);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18);
            background: linear-gradient(145deg, rgba(109, 139, 255, 0.12), rgba(255, 255, 255, 0.02));
            transform: translateY(-1px);
        }

        .upload-dropzone .file-name {
            margin-top: 4px;
            color: rgba(255, 255, 255, 0.75);
        }


        .instruction-list__item {
            margin-bottom: 0.5rem;
        }

        .custom-border {
            border: 1px solid hsl(var(--black) / 0.2);
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            const $modal = $('.importModal');
            const $form = $('#import-form');
            const $drop = $('.thumb-form');
            const $input = $drop.find('input[type="file"]');

            $('.importBtn').on('click', () => $modal.modal('show'));

            $('.filter-form select').on('change', function() {
                $(this).closest('form').submit();
            });

            $form.on('submit', function(e) {
                e.preventDefault();
                const $this = $(this);
                const formData = new FormData($this[0]);
                const $submitBtn = $this.find('button[type="submit"]');
                const oldHtml = $submitBtn.html();

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $submitBtn.addClass('disabled').attr("disabled", true).html(`
                            <div class="button-loader d-flex gap-2 flex-wrap align-items-center justify-content-center">
                                <div class="spinner-border"></div><span>Loading...</span>
                            </div>
                        `);
                    },
                    complete: function() {
                        $submitBtn.removeClass('disabled').attr("disabled", false).html(oldHtml);
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            notify('success', res.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            notify('error', res.message || "Something went wrong");
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = xhr?.responseJSON?.message || "@lang('Something went wrong, please try later.')";
                        notify('error', errorMessage);
                    }
                });
            });


            $(document).on('dragover dragenter drop', e => e.preventDefault());

            $drop.on('dragover', () => $drop.addClass('drag-over'))
                .on('dragleave drop', () => $drop.removeClass('drag-over'));

            $drop.on('drop', e => {
                const files = e.originalEvent.dataTransfer.files;
                if (files.length) {
                    $input[0].files = files;
                    $('.file-name').text($input[0].files[0].name);
                }
            });

            $input.on('change', () => {
                $('.file-name').text($input[0].files[0].name);
            })

            $('.more_tags_btn').on('click', function() {
                const contactTags = $(this).data('tags');
                $('.contact-tags').html('');
                contactTags.forEach(tag => {
                    $('.contact-tags').append(`
                    <li>
                        <a href = "?tag_id=${tag.id}" class = "tag-list__link">${tag.name}</a>
                    </li>`);
                });
                $('.tags-modal').modal('show');
            });

            $('body').on('click', '.check-all', function(e) {
                const $this = $(this);
                const $checkboxes = $this.closest('table').find('input[type="checkbox"]');
                $checkboxes.prop('checked', $this.prop('checked'));
                $checkboxes.closest('tr').find('td').toggleClass('row-selected');
                toggleBulkDeleteBtn();
            });

            $('body').on('click', '.contact-checkbox', function(e) {
                const $this = $(this);
                $this.closest('tr').find('td').toggleClass('row-selected');
                toggleBulkDeleteBtn();
            });

            function toggleBulkDeleteBtn() {
                const selectedContacts = $('input.contact-checkbox:checked').length;
                const $bulkDeleteBtn = $('.bulk-delete');

                if (selectedContacts > 0) {
                    $bulkDeleteBtn.removeClass('disabled').removeAttr('disabled');
                } else {
                    $bulkDeleteBtn.addClass('disabled').attr('disabled', 'disabled');
                }
            }

        })(jQuery);
    </script>
@endpush
