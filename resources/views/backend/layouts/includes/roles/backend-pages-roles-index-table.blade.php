@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.dataTables.min.css') }}">
@endsection()

<!--  -->
<div class="row card-header">
    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
        <h5 class="card-title">Liste des roles</h5>
    </div>
    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto mt-0">
        <a class="btn create-new btn-primary">
            {{ config('app.name') }}
        </a>
    </div>
</div>
<!--  -->
<div class="card-body">
    <div class="table-responsive text-nowrap">
        <table id="example" class="table table-bordered">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Libellé</th>
                    <th>Compte</th>
                    <th>Ajouter</th>
                    <th>Modifier</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach($roles as $role)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td><a href="{{ route('backend.roles.show', $role->token) }}">{{$role->label}}</a></td>
                    <td><a href="{{ route('backend.roles.users', $role->token) }}" class="badge bg-primary">{{$role->users->count()}} Compte(s)</a></td>
                    <td>{{ mb_convert_case(\Carbon\Carbon::parse($role->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, "UTF-8") }}</td>
                    <td>{{ mb_convert_case(\Carbon\Carbon::parse($role->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, "UTF-8") }}</td>
                    <td>
                        <a href="{{ route('backend.roles.show', $role->token) }}" class="btn btn-sm btn-warning"><i class="icon-base ri ri-eye-line icon-12px me-1"></i></a>
                        <a href="{{ route('backend.roles.edit', $role->token) }}" class="btn btn-sm btn-success"><i class="icon-base ri ri-pencil-line icon-12px me-1"></i></a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
<!--  -->

@section('script')
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.print.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                dom: '<"row"<"col-md-6"B><"col-md-6"f>>' +
                    '<"row"<"col-md-12"tr>>' +
                    '<"row"<"col-md-5"l><"col-md-7"p>>',
            });
        });
    </script>
@endsection()