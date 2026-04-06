@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.dataTables.min.css') }}">
@endsection()

<div class="row card-header">
    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
        <h5 class="card-title">Liste des produits</h5>
    </div>
    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto mt-0">
        <a class="btn create-new btn-primary" href="#">
            {{ config('app.name') }}
        </a>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive text-nowrap">
        <table id="example" class="table table-bordered">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>En avant</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Prix vente</th>
                    <th>Promo</th>
                    <th>Stock</th>
                    <th>Vues</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($product->is_featured)
                            <span class="badge bg-success">Oui</span>
                        @else
                            <span class="badge bg-secondary">Non</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('backend.products.show', $product->token) }}">

                            <!-- Si $product->getImages()['data'] existe -->
                            @if(isset($product->getImages()['data']) && count($product->getImages()['data']) > 0)
                                <img src="{{ $product->getImages()['data'][0]['url_img'] }}" alt="{{ Str::limit($product->name, 20) }}" class="img-fluid rounded-3" style="width: 40px; height: 40px; border-radius: 100px; object-fit: cover;">
                            @else
                                <img src="{{ $product->getImages()[0]['data']['url_img'] }}" alt="{{ Str::limit($product->name, 20) }}" class="img-fluid rounded-3" style="width: 40px; height: 40px; border-radius: 100px; object-fit: cover;">
                            @endif
                            
                            {{ Str::limit($product->name, 40) }}
                        </a>
                    </td>
                    <td>
                        <a class="badge bg-primary" href="{{ route('backend.product_categories.show', $product->category->token) }}">
                            {{ $product->category->name }}
                        </a>
                    </td>
                    <td>{{ number_format($product->sale_price, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($product->promotional_price)
                            <span class="badge bg-warning text-dark">
                                {{ number_format($product->promotional_price, 0, ',', ' ') }} FCFA
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($product->stock == 0)
                            <span class="badge bg-danger">Rupture</span>
                        @elseif($product->stock <= 5)
                            <span class="badge bg-warning text-dark">{{ $product->stock }} restant(s)</span>
                        @else
                            <span class="badge bg-success">{{ $product->stock }} en stock</span>
                        @endif
                    </td>
                    <td>{{ $product->views }}</td>
                    <td>
                        @if($product->is_visible)
                            <span class="badge bg-success">Publié</span>
                        @else
                            <span class="badge bg-danger">Brouillon</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" id="delete-form-{{ $product->token }}" action="{{ route('backend.products.destroy', $product->token) }}">
                            @csrf
                            @method('delete')
                            <a href="{{ route('backend.products.show', $product->token) }}" class="btn btn-sm btn-warning">
                                <i class="icon-base ri ri-eye-line icon-12px me-1"></i>
                            </a>
                            @can('web.check.role.user', [1, 2])
                            <a href="{{ route('backend.products.edit', $product->token) }}" class="btn btn-sm btn-success">
                                <i class="icon-base ri ri-pencil-line icon-12px me-1"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ $product->token }}', 'Êtes-vous sûr de vouloir supprimer ce produit ?')">
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