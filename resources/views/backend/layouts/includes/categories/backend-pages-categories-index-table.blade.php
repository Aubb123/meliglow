@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.dataTables.min.css') }}">
@endsection()

<!--  -->
<div class="row card-header">
    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
        <h5 class="card-title">Liste des catégories</h5>
    </div>
    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto mt-0">
        <a class="btn create-new btn-primary" href="{{ route('backend.categories.create') }}">
            Créer
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
                    <th>Nom</th>
                    <th>Blog</th>
                    <th>Ajouter</th>
                    <th>Modifier</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $categorie)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <a href="{{ route('backend.categories.show', $categorie->token) }}">
                            <img style="width: 40px; height: 40px; border-radius: 100px;" src="{{ asset(getEnvFolder() . $categorie->path_img)}}" alt="">
                            {{$categorie->name}}
                        </a>
                    </td>
                    <td><a href="{{ route('backend.categories.blogs', $categorie->token) }}" class="badge text-bg-primary">{{ $categorie->blogs->count() }} Blog(s)</a></td>
                    <td>{{ mb_convert_case(\Carbon\Carbon::parse($categorie->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, "UTF-8") }}</td>
                    <td>{{ mb_convert_case(\Carbon\Carbon::parse($categorie->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, "UTF-8") }}</td>
                    <td>
                        <form method="POST" id="delete-form-{{$categorie->token}}" action="{{ route('backend.categories.destroy', $categorie->token) }}">
                            @csrf
                            @method('delete')
                            <a href="{{ route('backend.categories.show', $categorie->token) }}" class="btn btn-sm btn-warning"><i class="icon-base ri ri-eye-line icon-12px me-1"></i></a>
                            <a href="{{ route('backend.categories.edit', $categorie->token) }}" class="btn btn-sm btn-success"><i class="icon-base ri ri-pencil-line icon-12px me-1"></i></a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{$categorie->token}}', 'Êtes-vous sûr de vouloir supprimer cette catégories ?')">
                                <i class="icon-base ri ri-delete-bin-6-line icon-12px me-1"></i>
                            </button>
                        </form>
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