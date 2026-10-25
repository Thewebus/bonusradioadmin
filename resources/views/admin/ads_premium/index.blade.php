@extends('admin.layout.page-app')
@section('page_title', __('Label.ads_premium'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="page-title-sm">{{ __('Label.ads_premium') }}</h1>
                <a href="{{ route('adspremium.stats') }}" class="btn btn-default mw-120"><i class="fa-solid fa-chart-column mr-2"></i>{{ __('Label.ads_stats') }}</a>
            </div>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Label.Dashboard') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Label.ads_premium') }}</li>
                    </ol>
                </div>
            </div>

            <div class="card custom-border-card mt-3">
                <h5 class="card-header">{{ __('Label.add_ads_premium') }}</h5>
                <div class="card-body">
                    <form id="ads_premium" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>{{ __('Label.nom_crea') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="crea_name" class="form-control" placeholder="Enter Nom CREA" autofocus>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Label.ads_display_duration') }}<span class="text-danger">*</span></label>
                                            <input type="number" name="display_duration" class="form-control" value="12" min="3" max="120">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Label.Status') }}</label>
                                            <select name="status" class="form-control">
                                                <option value="1">{{ __('Label.Active') }}</option>
                                                <option value="0">{{ __('Label.ads_inactive') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Label.ads_link_url') }}</label>
                                    <input type="text" name="link_url" class="form-control" placeholder="https://wa.me/225XXXXXXXX">
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Label.ads_image_url') }}</label>
                                    <input type="text" name="image_url" class="form-control" placeholder="https://example.com/your-image.png">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>{{ __('Label.ads_poster') }}<span class="text-danger">*</span></label>
                                    <div class="avatar-upload-landscape">
                                        <div class="avatar-edit-landscape">
                                            <input type='file' name="image" id="imageUploadLandscape" accept=".png, .jpg, .jpeg, .webp" />
                                            <label for="imageUploadLandscape" title="Select File"></label>
                                        </div>
                                        <div class="avatar-preview-landscape">
                                            <img src="{{ asset('assets/imgs/upload_img.png') }}" alt="upload_img.png" id="imagePreviewLandscape">
                                        </div>
                                    </div>
                                    <label class="mt-3 text-gray">{{ __('Label.ads_poster_hint') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" class="btn btn-default mw-120" onclick="save_ads_premium()">{{ __('Label.SAVE') }}</button>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                    </form>
                </div>
            </div>

            <div class="card custom-border-card mt-3">
                <div class="page-search mb-3">
                    <div class="input-group" title="Search">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass fa-xl light-gray"></i></span>
                        </div>
                        <input type="text" id="input_search" class="form-control" placeholder="Search Ads Premium" aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                </div>

                <div class="table-responsive table">
                    <table class="table table-striped text-center table-bordered" id="datatable">
                        <thead>
                            <tr style="background: #F9FAFF;">
                                <th>{{ __('Label.#') }}</th>
                                <th>{{ __('Label.ads_poster') }}</th>
                                <th>{{ __('Label.nom_crea') }}</th>
                                <th>{{ __('Label.ads_display_duration') }}</th>
                                <th>{{ __('Label.Status') }}</th>
                                <th>{{ __('Label.ads_views') }}</th>
                                <th>{{ __('Label.ads_clicks') }}</th>
                                <th>{{ __('Label.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade" id="EditModel" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Label.ads_premium') }}</h5>
                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="edit_ads_premium" autocomplete="off" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label>{{ __('Label.nom_crea') }}<span class="text-danger">*</span></label>
                                            <input type="text" name="crea_name" id="edit_crea_name" class="form-control" placeholder="Enter Nom CREA">
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ __('Label.ads_display_duration') }}<span class="text-danger">*</span></label>
                                                    <input type="number" name="display_duration" id="edit_display_duration" class="form-control" min="3" max="120">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ __('Label.Status') }}</label>
                                                    <select name="status" id="edit_status" class="form-control">
                                                        <option value="1">{{ __('Label.Active') }}</option>
                                                        <option value="0">{{ __('Label.ads_inactive') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Label.ads_link_url') }}</label>
                                            <input type="text" name="link_url" id="edit_link_url" class="form-control" placeholder="https://wa.me/225XXXXXXXX">
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Label.ads_image_url') }}</label>
                                            <input type="text" name="image_url" id="edit_image_url" class="form-control" placeholder="https://example.com/your-image.png">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>{{ __('Label.ads_poster') }}</label>
                                            <div class="avatar-upload-landscape">
                                                <div class="avatar-edit-landscape">
                                                    <input type='file' name="image" id="imageUploadLandscapeModel" accept=".png, .jpg, .jpeg, .webp" />
                                                    <label for="imageUploadLandscapeModel" title="Select File"></label>
                                                </div>
                                                <div class="avatar-preview-landscape">
                                                    <img src="{{ asset('assets/imgs/upload_img.png') }}" alt="upload_img.png" id="imagePreviewLandscapeModel">
                                                </div>
                                            </div>
                                            <label class="mt-3 text-gray">{{ __('Label.ads_poster_hint') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id" id="edit_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default mw-120" onclick="update_ads_premium()">{{ __('Label.UPDATE') }}</button>
                                <button type="button" class="btn btn-cancel mw-120" data-dismiss="modal">{{ __('Label.CLOSE') }}</button>
                                <input type="hidden" name="_method" value="PATCH">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                dom: "<'top'f>rt<'row'<'col-2'i><'col-1'l><'col-9'p>>",
                searching: false,
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                lengthMenu: [
                    [10, 100, 500, -1],
                    [10, 100, 500, "All"]
                ],
                language: {
                    paginate: {
                        previous: "<i class='fa-solid fa-chevron-left'></i>",
                        next: "<i class='fa-solid fa-chevron-right'></i>"
                    }
                },
                ajax: {
                    url: "{{ route('adspremium.index') }}",
                    data: function(d) {
                        d.input_search = $('#input_search').val();
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'image_preview',
                        name: 'image_preview',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return '<img src="' + data + '" style="height: 50px; width: 90px; object-fit: cover; border-radius: 6px;">';
                        }
                    },
                    {
                        data: 'crea_name',
                        name: 'crea_name',
                        render: function(data, type, row) {
                            var html = data ? $('<div>').text(data).html() : '-';
                            if (row.link_url) {
                                html += '<br><a href="' + row.link_url + '" target="_blank" class="small"><i class="fa-solid fa-link"></i> lien</a>';
                            }
                            return html;
                        }
                    },
                    {
                        data: 'display_duration',
                        name: 'display_duration',
                        render: function(data) {
                            return data + ' s';
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            return data == 1 ?
                                '<span class="badge badge-success">{{ __('Label.Active') }}</span>' :
                                '<span class="badge badge-secondary">{{ __('Label.ads_inactive') }}</span>';
                        }
                    },
                    {
                        data: 'total_views',
                        name: 'total_views',
                        render: function(data) {
                            return parseInt(data || 0).toLocaleString('fr-FR');
                        }
                    },
                    {
                        data: 'total_clicks',
                        name: 'total_clicks',
                        render: function(data) {
                            return parseInt(data || 0).toLocaleString('fr-FR');
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            $('#input_search').keyup(function() {
                table.draw();
            });
        });

        function save_ads_premium() {
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if (Check_Admin == 1) {
                $("#dvloader").show();
                var formData = new FormData($("#ads_premium")[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("adspremium.store") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'ads_premium', '{{ route("adspremium.index") }}');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $("#dvloader").hide();
                        toastr.error(errorThrown, textStatus);
                    }
                });
            } else {
                toastr.error('You have no right to add, edit, and delete.');
            }
        }

        $(document).on("click", ".edit_ads_premium", function() {
            $(".modal-body #edit_id").val($(this).data('id'));
            $(".modal-body #edit_crea_name").val($(this).data('crea_name'));
            $(".modal-body #edit_image_url").val($(this).data('image_url'));
            $(".modal-body #edit_link_url").val($(this).data('link_url'));
            $(".modal-body #edit_display_duration").val($(this).data('display_duration'));
            $(".modal-body #edit_status").val($(this).data('status'));
            $("#imageUploadLandscapeModel").val('');
            $("#imagePreviewLandscapeModel").attr("src", $(this).data('image_preview'));
        });

        function update_ads_premium() {
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if (Check_Admin == 1) {
                $("#dvloader").show();
                var formData = new FormData($("#edit_ads_premium")[0]);

                var Edit_Id = $("#edit_id").val();
                var url = '{{ route("adspremium.update", ":id") }}';
                url = url.replace(':id', Edit_Id);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    enctype: 'multipart/form-data',
                    type: 'POST',
                    url: url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        if (resp.status == '200') {
                            $('#EditModel').modal('toggle');
                        }
                        get_responce_message(resp, resp.status == '200' ? 'edit_ads_premium' : '', resp.status == '200' ? '{{ route("adspremium.index") }}' : '');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $("#dvloader").hide();
                        toastr.error(errorThrown, textStatus);
                    }
                });
            } else {
                toastr.error('You have no right to add, edit, and delete.');
            }
        }
    </script>
@endsection
