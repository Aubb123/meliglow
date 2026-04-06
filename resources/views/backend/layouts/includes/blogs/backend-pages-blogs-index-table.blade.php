@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.dataTables.min.css') }}">
@endsection()

<!--  -->
<div class="row card-header">
    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
        <h5 class="card-title">Liste des blogs</h5>
    </div>
    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto mt-0">
        <a class="btn create-new btn-primary" href="{{ route('backend.blogs.create') }}">
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
                    <th>Titre</th>
                    <th>Vue(s)</th>
                    <th>Temps</th>
                    <th>Visible ?</th>
                    <th>Catégorie</th>
                    <th>Auteur</th>
                    <th>Comment(s)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $blog)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <a href="{{ route('backend.blogs.show', $blog->token) }}">
                            <img style="width: 40px; height: 40px; border-radius: 100px;" src="{{ asset(getEnvFolder() . $blog->path_img )}}" alt="">
                            {{Str::limit($blog->title, 50)}}
                        </a>
                    </td>
                    <td>{{$blog->views}}</td>
                    <td>{{$blog->time_read}} min(s)</td>
                    <td>
                        @if($blog->is_visible == false)
                            <span class="badge bg-danger">Blog masqué</span>
                        @endif
                        @if($blog->is_visible == true)
                            <span class="badge bg-success">Blog démasqué</span>
                        @endif
                    </td>
                    <td><a class="badge bg-primary" href="{{ route('backend.categories.show', $blog->categorie->token) }}">{{$blog->categorie->name}}</a></td>
                    <td><a class="badge bg-label-primary" href="{{ route('backend.users.show', $blog->user->token) }}">{{$blog->user->lastname}} {{$blog->user->firstname}}</a></td>
                    <td><a href="{{ route('backend.blogs.comments', $blog->token) }}" class="badge bg-info">{{$blog->comments ? $blog->comments->count() : 0}} Comment(s)</a></td>
                    {{-- <td><a href="{{ route('backend.blogs.replies', $blog->token) }}" class="badge bg-info">{{ $blog->comments->sum(function ($comment) { return $comment->replys->count(); }) }} Réponse(s)</a></td> --}}
                    <td>
                        <form method="POST" id="delete-form-{{$blog->token}}" action="{{ route('backend.blogs.destroy', $blog->token) }}">
                            @csrf
                            @method('delete')
                            <a href="{{ route('backend.blogs.show', $blog->token) }}" class="btn btn-sm btn-warning"><i class="icon-base ri ri-eye-line icon-12px me-1"></i></a>
                            <a href="{{ route('backend.blogs.edit', $blog->token) }}" class="btn btn-sm btn-success"><i class="icon-base ri ri-pencil-line icon-12px me-1"></i></a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{$blog->token}}', 'Êtes-vous sûr de vouloir supprimer ce blog ?')">
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