@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.dataTables.min.css') }}">
@endsection()

<!--  -->
<div class="row card-header">
    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
        <h5 class="card-title">Liste des catégories de produits</h5>
    </div>
    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto mt-0">
        <a class="btn create-new btn-primary" href="{{ route('backend.product_categories.create') }}">
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
                    <th>Description</th>
                    <th>Produit(s)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('backend.product_categories.show', $category->token) }}">

                            @if($category->hasCoverImage())
                                <img src="{{ $category->getCoverImageUrl()['url_img'] }}" alt="{{ $category->name }}" class="img-fluid rounded-3" style="width: 40px; height: 40px; border-radius: 100px; object-fit: cover;">
                            @else
                                <img src="{{ $category->getCoverImageUrl()['url_img'] }}" alt="{{ $category->name }}" class="img-fluid rounded-3" style="width: 40px; height: 40px; border-radius: 100px; object-fit: cover;">
                            @endif
                            
                            {{ $category->name }}
                        </a>
                    </td>
                    <td>{{ $category->description ? Str::limit($category->description, 60) : '—' }}</td>
                    <td>
                        <a href="{{ route('backend.product_categories.show', $category->token) }}" class="badge bg-info">
                            {{ $category->products_count ?? 0 }} Produit(s)
                        </a>
                    </td>
                    <td>
                        <form method="POST" id="delete-form-{{ $category->token }}" action="{{ route('backend.product_categories.destroy', $category->token) }}">
                            @csrf
                            @method('delete')
                            <a href="{{ route('backend.product_categories.show', $category->token) }}" class="btn btn-sm btn-warning">
                                <i class="icon-base ri ri-eye-line icon-12px me-1"></i>
                            </a>
                            <a href="{{ route('backend.product_categories.edit', $category->token) }}" class="btn btn-sm btn-success">
                                <i class="icon-base ri ri-pencil-line icon-12px me-1"></i>
                            </a>
                            @can('web.check.role.user', [1, 2])
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ $category->token }}', 'Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                <i class="icon-base ri ri-delete-bin-6-line icon-12px me-1"></i>
                            </button>
                            @endcan
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