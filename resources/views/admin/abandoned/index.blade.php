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
                        <div class="card-body">
                            <table id="data-table" class="table">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Course</th>
                                        <th>Policy</th>
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
            ajax: "{{ route('abandoned.ajax') }}",
            columns: [
                {
                    data: 'user',
                    render: function(data, type, full) {
                        return data ? data.first_name + ' ' + data.last_name : null;
                    }
                },
                {
                    data: 'course',
                    render: function(data, type, full) {
                        return data ? data.title : null;
                    }
                },
                {
                    data: 'policy',
                    render: function(data, type, full) {
                        return data ? data.title : null;
                    }
                },
                {
                    data: 'action'
                }
            ]
        });
    </script>
@endsection
