@extends('admin.layout.page-app')
@section('page_title', __('Label.video_series'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <h1 class="page-title-sm">{{ __('Label.video_series') }}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Label.Dashboard') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Label.video_series') }}</li>
                    </ol>
                </div>
            </div>

            <div class="card custom-border-card mt-3">
                <h5 class="card-header">{{ __('Label.add_video_series') }}</h5>
                <div class="card-body">
                    <form id="video_series" enctype="multipart/form-data">
                        <input type="hidden" name="id">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Label.Title') }}<span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter Title" autofocus>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Label.Category') }}</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">-</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ __('Label.Status') }}<span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="1">Published</option>
                                        <option value="0">Hidden</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>{{ __('Label.Description') }}</label>
                                    <textarea name="description" class="form-control" rows="2" placeholder="Describe Here,"></textarea>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Portrait Image<span class="text-danger">*</span></label>
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' name="portrait_img" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload" title="Select File"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <img src="{{asset('assets/imgs/upload_img.png')}}" alt="upload_img.png" id="imagePreview">
                                        </div>
                                    </div>
                                    <label class="mt-3 text-gray">Maximum size 2MB.</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Landscape Image<span class="text-danger">*</span></label>
                                    <div class="avatar-upload-landscape">
                                        <div class="avatar-edit-landscape">
                                            <input type='file' name="landscape_img" id="imageUploadLandscape" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUploadLandscape" title="Select File"></label>
                                        </div>
                                        <div class="avatar-preview-landscape">
                                            <img src="{{asset('assets/imgs/upload_img.png')}}" alt="upload_img.png" id="imagePreviewLandscape">
                                        </div>
                                    </div>
                                    <label class="mt-3 text-gray">Maximum size 2MB.</label>
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" class="btn btn-default mw-120" onclick="save_video_series()">{{ __('Label.SAVE') }}</button>
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
                        <input type="text" id="input_search" class="form-control" placeholder="Search Series" aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                </div>

                <div class="table-responsive table">
                    <table class="table table-striped text-center table-bordered" id="datatable">
                        <thead>
                            <tr style="background: #F9FAFF;">
                                <th>{{ __('Label.#') }}</th>
                                <th>{{ __('Label.Image') }}</th>
                                <th>{{ __('Label.Title') }}</th>
                                <th>{{ __('Label.episodes') }}</th>
                                <th>{{ __('Label.Status') }}</th>
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
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Label.video_series') }}</h5>
                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="edit_video_series" autocomplete="off" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="id" id="edit_id">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Label.Title') }}<span class="text-danger">*</span></label>
                                            <input type="text" name="title" id="edit_title" class="form-control" placeholder="Enter Title">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ __('Label.Category') }}</label>
                                            <select name="category_id" id="edit_category_id" class="form-control">
                                                <option value="">-</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ __('Label.Status') }}<span class="text-danger">*</span></label>
                                            <select name="status" id="edit_status" class="form-control">
                                                <option value="1">Published</option>
                                                <option value="0">Hidden</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>{{ __('Label.Description') }}</label>
                                            <textarea name="description" id="edit_description" class="form-control" rows="2" placeholder="Describe Here,"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Portrait Image</label>
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' name="portrait_img" id="imageUploadModel" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUploadModel" title="Select File"></label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <img src="{{asset('assets/imgs/upload_img.png')}}" alt="upload_img.png" id="imagePreviewModel">
                                                </div>
                                            </div>
                                            <label class="mt-3 text-gray">Maximum size 2MB.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Landscape Image</label>
                                            <div class="avatar-upload-landscape">
                                                <div class="avatar-edit-landscape">
                                                    <input type='file' name="landscape_img" id="imageUploadLandscapeModel" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUploadLandscapeModel" title="Select File"></label>
                                                </div>
                                                <div class="avatar-preview-landscape">
                                                    <img src="{{asset('assets/imgs/upload_img.png')}}" alt="upload_img.png" id="imagePreviewLandscapeModel">
                                                </div>
                                            </div>
                                            <label class="mt-3 text-gray">Maximum size 2MB.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default mw-120" onclick="update_video_series()">{{ __('Label.UPDATE') }}</button>
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
                    url: "{{ route('videoseries.index') }}",
                    data: function(d) {
                        d.input_search = $('#input_search').val();
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'landscape_img',
                        name: 'landscape_img',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return '<img src="' + data + '" style="height:50px; width:auto; border-radius:6px;">';
                        }
                    },
                    {
                        data: 'title',
                        name: 'title',
                        render: function(data) {
                            return data ? $('<div>').text(data).html() : '-';
                        }
                    },
                    { data: 'episode_count', name: 'episode_count', orderable: false, searchable: false },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });

            $('#input_search').keyup(function() {
                table.draw();
            });
        });

        function save_video_series() {
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if (Check_Admin == 1) {
                $("#dvloader").show();
                var formData = new FormData($("#video_series")[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("videoseries.store") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'video_series', '{{ route("videoseries.index") }}');
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

        $(document).on("click", ".edit_video_series", function() {
            $("#edit_id").val($(this).data('id'));
            $("#edit_title").val($(this).data('title'));
            $("#edit_description").val($(this).data('description'));
            $("#edit_category_id").val($(this).data('category_id'));
            $("#edit_status").val($(this).data('status'));
            $("#imagePreviewModel").attr("src", $(this).data('portrait_img'));
            $("#imagePreviewLandscapeModel").attr("src", $(this).data('landscape_img'));
        });

        function update_video_series() {
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if (Check_Admin == 1) {
                $("#dvloader").show();
                var formData = new FormData($("#edit_video_series")[0]);

                var Edit_Id = $("#edit_id").val();
                var url = '{{ route("videoseries.update", ":id") }}';
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
                        $('#EditModel').modal('toggle');
                        get_responce_message(resp, 'edit_video_series', '{{ route("videoseries.index") }}');
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
