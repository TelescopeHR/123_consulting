@extends('admin.layouts.master')

@section('title', ucfirst(Str::plural($module)))

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link href="{{ asset('css/jquery-impromptu.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('admin.layouts.breadcrumb', ['module_title' => Str::singular($module)])

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="{{ route('blog.create')}}" class="btn btn-primary">Add New</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="data-table" class="table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Status</th>
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

@endsection

@section('js')
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/jquery-impromptu.js') }}"></script>
    <script>
        const dataTable = $('#data-table').DataTable({
            lengthChange: false,
            language: {
                search: '',
                searchPlaceholder: "Search..."
            },
            responsive: window.screen.width < 1024,
            aaSorting: [],
            aoColumnDefs: [{
                bSortable: false,
                aTargets: [-1]
            }],
            ajax: "{{ route('blog.ajax') }}",
            columns: [
                {data: 'title', className: 'all'},
                {data: 'image_div'},
                {data: 'status'},
                {data: 'action', className: 'all', searchable: false, orderable: false},
            ]
        });

        $('body').on('click', '.delete', function() {
            let url = $(this).attr('target-url');
            var token = $('input[name="_token"]').val();
            $.prompt("Are you sure want to delete this record?", {
                title: "Are you sure?",
                buttons: {
                    "No": false,
                    "Yes": true
                },
                focus: 1,
                submit: function(e, v, m, f) {
                    if (v) {
                        e.preventDefault();
                        $.ajax({
                            headers: {
                                'X-CSRF-Token': token
                            },
                            type: "DELETE",
                            url: url,
                            success: function(data) {
                                if (data.status) {
                                    location.reload();
                                }
                            }
                        });
                    }
                    $.prompt.close();
                }
            });
        });
    </script>
@endsection
