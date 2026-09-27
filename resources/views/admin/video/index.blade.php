@extends('admin.layout.page-app')
@section('page_title', __('Label.videos_vod'))

@section('content')
    @include('admin.layout.sidebar')

    <div class="right-content">
        @include('admin.layout.header')

        <div class="body-content">
            <!-- mobile title -->
            <h1 class="page-title-sm">{{__('Label.videos_vod')}}</h1>

            <div class="border-bottom row mb-3">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__('Label.Dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('Label.videos_vod')}}</li>
                    </ol>
                </div>
            </div>

            <!-- Add Video -->
            <div class="card custom-border-card mt-3">
                <h5 class="card-header">{{__('Label.add_video_vod')}}</h5>
                <div class="card-body">
                    <form id="video" enctype="multipart/form-data">
                        <input type="hidden" name="id">
                    <div class="form-row">
                        <div class="col-md-8">
                            <div class="form-row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>{{__('Label.Title')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('Label.Category')}}<span class="text-danger">*</span></label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="">-</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Source<span class="text-danger">*</span></label>
                                        <select name="video_source" id="video_source" class="form-control video_source_select" data-prefix="">
                                            <option value="1">{{__('Label.video_source_link')}}</option>
                                            <option value="2">{{__('Label.video_source_upload')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group" id="link_box">
                                        <label>Link (YouTube, Vimeo, .mp4, .m3u8)<span class="text-danger">*</span></label>
                                        <input type="text" name="link" id="link" class="form-control" placeholder="https://...">
                                    </div>
                                    <div class="form-group" id="upload_box" style="display:none;">
                                        <label>File (mp4, webm, mov)<span class="text-danger">*</span></label>
                                        <div id="video_container">
                                            <a id="video_pick" class="btn text-white" style="background-color:#4e45b8;">{{__('Label.video_source_upload')}}</a>
                                            <span id="video_filelist" class="ml-2"></span> <b id="video_progress"></b>
                                        </div>
                                        <input type="hidden" name="video_file" id="video_file">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Paid<span class="text-danger">*</span></label>
                                        <div class="radio-group">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_paid" id="is_paid_yes" class="custom-control-input paid_value" value="1">
                                                <label class="custom-control-label" for="is_paid_yes">{{__('Label.Yes')}}</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_paid" id="is_paid_no" class="custom-control-input paid_value" value="0" checked>
                                                <label class="custom-control-label" for="is_paid_no">{{__('Label.No')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" id="price_box" style="display:none;">
                                    <div class="form-group">
                                        <label>Price<span class="text-danger">*</span></label>
                                        <input type="number" name="price" id="price" class="form-control" placeholder="Enter Price">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('Label.Status')}}<span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Published</option>
                                            <option value="0">Hidden</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('Label.available_until')}}</label>
                                        <input type="date" name="date" id="date" class="form-control">
                                        <small class="text-gray">Leave empty for no expiry.</small>
                                    </div>
                                </div>
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
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('Label.Description')}}</label>
                                <textarea name="description" id="description" class="form-control" rows="2" placeholder="Describe Here,"></textarea>
                            </div>
                        </div>
                    </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" id="video_save_btn" class="btn btn-default mw-120" onclick="save_video()">{{__('Label.SAVE')}}</button>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search && Table -->
            <div class="card custom-border-card mt-3">
                <div class="page-search mb-3">
                    <div class="input-group" title="Search">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass fa-xl light-gray"></i></span>
                        </div>
                        <input type="text" id="input_search" class="form-control" placeholder="Search Video" aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                </div>

                <div class="table-responsive table">
                    <table class="table table-striped text-center table-bordered" id="datatable">
                        <thead>
                            <tr style="background: #F9FAFF;">
                                <th>{{__('Label.#')}}</th>
                                <th>{{__('Label.Image')}}</th>
                                <th>{{__('Label.Title')}}</th>
                                <th>{{__('Label.Category')}}</th>
                                <th>{{__('Label.available_until')}}</th>
                                <th>Paid</th>
                                <th>Price</th>
                                <th>Source</th>
                                <th>{{__('Label.Status')}}</th>
                                <th>{{__('Label.Action')}}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Edit Model -->
            <div class="modal fade" id="EditModel" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Video</h5>
                            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="update_video" autocomplete="off">
                            <div class="modal-body">
                                <input type="hidden" name="id" id="edit_id">
                            <div class="form-row">
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>{{__('Label.Title')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="title" id="edit_title" class="form-control" placeholder="Enter Title">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('Label.Category')}}<span class="text-danger">*</span></label>
                                                <select name="category_id" id="edit_category_id" class="form-control">
                                                    <option value="">-</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Source<span class="text-danger">*</span></label>
                                                <select name="video_source" id="edit_video_source" class="form-control video_source_select" data-prefix="edit_">
                                                    <option value="1">{{__('Label.video_source_link')}}</option>
                                                    <option value="2">{{__('Label.video_source_upload')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group" id="edit_link_box">
                                                <label>Link (YouTube, Vimeo, .mp4, .m3u8)<span class="text-danger">*</span></label>
                                                <input type="text" name="link" id="edit_link" class="form-control" placeholder="https://...">
                                            </div>
                                            <div class="form-group" id="edit_upload_box" style="display:none;">
                                                <label>File (mp4, webm, mov)<span class="text-danger">*</span></label>
                                                <div id="edit_video_container">
                                                    <a id="edit_video_pick" class="btn text-white" style="background-color:#4e45b8;">{{__('Label.video_source_upload')}}</a>
                                                    <span id="edit_video_filelist" class="ml-2"></span> <b id="edit_video_progress"></b>
                                                </div>
                                                <input type="hidden" name="video_file" id="edit_video_file">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Paid<span class="text-danger">*</span></label>
                                                <div class="radio-group">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="is_paid" id="edit_is_paid_yes" class="custom-control-input edit_paid_value" value="1">
                                                        <label class="custom-control-label" for="edit_is_paid_yes">{{__('Label.Yes')}}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="is_paid" id="edit_is_paid_no" class="custom-control-input edit_paid_value" value="0" checked>
                                                        <label class="custom-control-label" for="edit_is_paid_no">{{__('Label.No')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="edit_price_box" style="display:none;">
                                            <div class="form-group">
                                                <label>Price<span class="text-danger">*</span></label>
                                                <input type="number" name="price" id="edit_price" class="form-control" placeholder="Enter Price">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('Label.Status')}}<span class="text-danger">*</span></label>
                                                <select name="status" id="edit_status" class="form-control">
                                                    <option value="1">Published</option>
                                                    <option value="0">Hidden</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('Label.available_until')}}</label>
                                                <input type="date" name="date" id="edit_date" class="form-control">
                                                <small class="text-gray">Leave empty for no expiry.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Portrait Image<span class="text-danger">*</span></label>
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
                                        <label>Landscape Image<span class="text-danger">*</span></label>
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
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{__('Label.Description')}}</label>
                                        <textarea name="description" id="edit_description" class="form-control" rows="2" placeholder="Describe Here,"></textarea>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="edit_video_save_btn" class="btn btn-default mw-120" onclick="update_video()">{{__('Label.UPDATE')}}</button>
                                <button type="button" class="btn btn-cancel mw-120" data-dismiss="modal">{{__('Label.CLOSE')}}</button>
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
        // ---- paid <-> price, link <-> upload toggles (add form prefix "", edit modal prefix "edit_")
        function togglePrice(prefix) {
            var paid = $('input[name=is_paid]:checked', prefix === '' ? '#video' : '#update_video').val();
            $('#' + prefix + 'price_box').toggle(paid == 1);
        }
        $(document).on('change', '.paid_value', function() { togglePrice(''); });
        $(document).on('change', '.edit_paid_value', function() { togglePrice('edit_'); });

        function toggleSource(prefix) {
            var isUpload = $('#' + prefix + 'video_source').val() == 2;
            $('#' + prefix + 'link_box').toggle(!isUpload);
            $('#' + prefix + 'upload_box').toggle(isUpload);
        }
        $(document).on('change', '.video_source_select', function() { toggleSource($(this).data('prefix')); });

        // ---- chunked video upload (authenticated route, 1 MB chunks)
        function initVideoUploader(prefix) {
            var uploader = new plupload.Uploader({
                runtimes: 'html5',
                browse_button: prefix + 'video_pick',
                container: document.getElementById(prefix + 'video_container'),
                chunk_size: '1mb',
                url: '{{ route("video.savechunk") }}',
                unique_names: true,
                send_file_name: true,
                multi_selection: false,
                filters: {
                    mime_types: [{ title: "Videos", extensions: "mp4,webm,mov" }],
                    prevent_duplicates: true
                },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                init: {
                    FilesAdded: function(up, files) {
                        while (up.files.length > 1) { up.removeFile(up.files[0]); }
                        $('#' + prefix + 'video_filelist').text(files[0].name + ' (' + plupload.formatSize(files[0].size) + ')');
                        $('#' + prefix + 'video_file').val('');
                        // Block the save button for the whole upload — clicking Save before it
                        // finishes is the main reason "video_file" ends up empty on submit.
                        $('#' + prefix + 'video_save_btn').prop('disabled', true).text('Upload en cours...');
                        up.start();
                    },
                    UploadProgress: function(up, file) {
                        $('#' + prefix + 'video_progress').text(file.percent + '%');
                    },
                    FileUploaded: function(up, file, info) {
                        var response = JSON.parse(info.response);
                        var btn = $('#' + prefix + 'video_save_btn');
                        var label = prefix === '' ? '{{__('Label.SAVE')}}' : '{{__('Label.UPDATE')}}';
                        btn.prop('disabled', false).text(label);
                        if (response.result) {
                            $('#' + prefix + 'video_file').val(response.result);
                            $('#' + prefix + 'video_progress').text('100% - uploaded');
                        } else {
                            toastr.error("L'upload a échoué, réessaie.");
                        }
                    },
                    Error: function(up, err) {
                        $('#' + prefix + 'video_progress').text('');
                        var label = prefix === '' ? '{{__('Label.SAVE')}}' : '{{__('Label.UPDATE')}}';
                        $('#' + prefix + 'video_save_btn').prop('disabled', false).text(label);
                        toastr.error(err.message, 'Upload error');
                    }
                }
            });
            uploader.init();
            return uploader;
        }
        var addUploader = initVideoUploader('');
        var editUploader = initVideoUploader('edit_');
        // plupload mis-positions its hidden <input> for buttons inside a closed modal
        $('#EditModel').on('shown.bs.modal', function() { editUploader.refresh(); });

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
                    url: "{{ route('video.index') }}",
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
                    { data: 'category', name: 'category', orderable: false, searchable: false },
                    { data: 'available_until', name: 'available_until', orderable: false, searchable: false },
                    {
                        data: 'is_paid',
                        name: 'is_paid',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return data == 1 ? 'Paid' : 'Free';
                        }
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: function(data) {
                            return data ? data : 0;
                        }
                    },
                    { data: 'source', name: 'source', orderable: false, searchable: false },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });

            $('#input_search').keyup(function() {
                table.draw();
            });
        });

        // Catches the most common reasons the server would reject the form, with a
        // specific message, before even sending it — in particular the upload race
        // condition where "SAVE" is clicked before the chunked video upload finished
        // (video_file is still empty at that point, and the server would otherwise
        // just report "The video file field is required.").
        function validateVideoForm(prefix, requireImages) {
            var form = prefix === '' ? '#video' : '#update_video';
            if (!$('#' + prefix + 'title').val()) {
                toastr.error('Le titre est obligatoire.'); return false;
            }
            if (!$('#' + prefix + 'category_id').val()) {
                toastr.error("Choisis une catégorie (crée-en une d'abord sur la page Video Categories si la liste est vide)."); return false;
            }
            if ($('#' + prefix + 'video_source').val() == 2) {
                if (!$('#' + prefix + 'video_file').val()) {
                    toastr.error("L'upload du fichier vidéo n'est pas terminé (attends 100 % avant d'enregistrer), ou aucun fichier n'a été choisi.");
                    return false;
                }
            } else if (!$('#' + prefix + 'link').val()) {
                toastr.error('Le lien vidéo est obligatoire.'); return false;
            }
            if ($('input[name=is_paid]:checked', form).val() == 1 && !$('#' + prefix + 'price').val()) {
                toastr.error('Le prix est obligatoire pour une vidéo payante.'); return false;
            }
            if (requireImages) {
                if (!$('#imageUpload')[0].files.length) {
                    toastr.error("L'image portrait est obligatoire."); return false;
                }
                if (!$('#imageUploadLandscape')[0].files.length) {
                    toastr.error("L'image paysage est obligatoire."); return false;
                }
            }
            return true;
        }

        function save_video() {
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if (Check_Admin == 1) {
                if (!validateVideoForm('', true)) { return; }
                $("#dvloader").show();
                var formData = new FormData($("#video")[0]);
                $.ajax({
                    type: 'POST',
                    url: '{{ route("video.store") }}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(resp) {
                        $("#dvloader").hide();
                        get_responce_message(resp, 'video', '{{ route("video.index") }}');
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

        $(document).on("click", ".edit_video", function() {
            var source = $(this).data('video_source');
            var link = $(this).data('link');

            $("#edit_id").val($(this).data('id'));
            $("#edit_title").val($(this).data('title'));
            $("#edit_description").val($(this).data('description'));
            $("#edit_category_id").val($(this).data('category_id'));
            $("#edit_date").val($(this).data('date'));
            $("#edit_price").val($(this).data('price'));
            $("#edit_status").val($(this).data('status'));
            $("#imagePreviewModel").attr("src", $(this).data('portrait_img'));
            $("#imagePreviewLandscapeModel").attr("src", $(this).data('landscape_img'));

            $("#edit_video_source").val(source);
            if (source == 2) {
                $("#edit_link").val('');
                $("#edit_video_file").val(link);
                $("#edit_video_filelist").text(link);
            } else {
                $("#edit_link").val(link);
                $("#edit_video_file").val('');
                $("#edit_video_filelist").text('');
            }
            $("#edit_video_progress").text('');
            toggleSource('edit_');

            $("#edit_is_paid_" + ($(this).data('is_paid') == 1 ? 'yes' : 'no')).prop("checked", true);
            togglePrice('edit_');
        });

        function update_video() {
            var Check_Admin = '<?php echo Check_Admin_Access(); ?>';
            if (Check_Admin == 1) {
                if (!validateVideoForm('edit_', false)) { return; }
                $("#dvloader").show();
                var formData = new FormData($("#update_video")[0]);

                var Edit_Id = $("#edit_id").val();
                var url = '{{ route("video.update", ":id") }}';
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
                        get_responce_message(resp, 'update_video', '{{ route("video.index") }}');
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
