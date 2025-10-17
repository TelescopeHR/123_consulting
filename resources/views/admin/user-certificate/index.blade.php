@extends('admin.layouts.master')

@section('title', ucfirst(Str::plural($module)))

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">
@endsection

@section('content')
@include('admin.layouts.breadcrumb', ['module_title' => ucfirst(Str::plural($module))])

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <table id="certificate_table" class="table ">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Course</th>
                                    <th>Name of Certificate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade certificate-modal-lg" id="certificateModal" tabindex="-1" role="dialog" aria-labelledby="certificateLabelModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="col-md-12 col-sm-12">
                <div class="modal-header">
                    <h5 class="modal-title" id="certificateModalLabel">Certificate Name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="certificate_name">Certificate Name</label>
                            <input type="text" class="form-control" id="certificate_name" name="certificate_name" placeholder="Enter Certificate Name">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-certificate-name">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('js/jquery-impromptu.js') }}"></script>
<script>
    const dataTable = $('#certificate_table').DataTable({
        lengthChange: false,
        language: {
            search: '',
            searchPlaceholder: "Search..."
        },
        responsive: window.screen.width < 1024,
        aaSorting: [],
        serverSide: true,
        aoColumnDefs: [{
            bSortable: false,
            aTargets: [-1]
        }],
        ajax: "{{ route('user-certificate.index') }}",
        columns: [
            {
                data: 'user.first_name',
                render: function(data, type, row) {
                    if (row.user) {
                        let user = row.user.first_name + ' ' + row.user.last_name;
                        return user;
                    }
                    return '<b>User Deleted</b>';
                }
            },
            {
                data: 'course.title',
                render: function(data, type, full) {
                    return full.course ? full.course.title : '<b>Course Deleted</b>';
                }
            },
            {data: 'certificate_name', className: 'all'},
            {data: 'action', className: 'all', searchable: false, orderable: false},
        ]
    });

    $(document).on('click', '.edit-certificate-name', function() {
        let id = $(this).data('id');
        let certificate_name = $(this).data('certificate_name');

        let modal = $('#certificateModal');
        modal.find('#certificate_name').val(certificate_name);
        modal.find('#save-certificate-name').data('id', id);
        modal.modal('show');
    });

    $(document).on('click', '#save-certificate-name', function() {
        let id = $(this).data('id');
        let certificate_name = $('#certificate_name').val();

        let url = "{{ route('user-certificate.update', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'PUT',
            url: url,
            data: {
                'certificate_name': certificate_name,
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.success) {
                    $('#certificateModal').modal('hide');
                    toastr.success(response.message);
                    dataTable.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });
</script>
@endsection