@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(getEnvFolder() . 'others/backend/datatables/buttons.dataTables.min.css') }}">
@endsection()

<!--  -->
<div class="row card-header">
    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
        <h5 class="card-title">Liste des commentaires</h5>
    </div>
    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto mt-0">
        <a class="btn create-new btn-primary" href="#">
            {{config('app.name')}}
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
                    <th>Contenu</th>
                    <th>Référence</th>
                    <th>Visible</th>
                    <th>Auteur</th>
                    {{--<th>Réponse(s)</th>--}}
                    <th>Ajouter</th>
                    <th>Modifier</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td><a href="{{ route('backend.comments.show', $comment->token) }}">{{Str::limit($comment->content, 30)}}</a></td>
                    <td>
                        @if($comment->commentable_type == 'App\Models\Blog')
                            <a href="{{ route('backend.blogs.show', $comment->commentable ? $comment->commentable->token : 'null') }}">Blog: {{Str::limit($comment->commentable->title, 20)}}</a>
                        @endif
                    </td>
                    <td>
                        @if($comment->is_visible == false)
                            <span class="badge bg-danger">Non</span>
                        @endif
                        @if($comment->is_visible == true)
                            <span class="badge bg-success">Oui</span>
                        @endif
                    </td>
                    <td><a href="{{ route('backend.users.show', $comment->user->token) }}">{{$comment->user->lastname}} {{$comment->user->firstname}}</a></td>
                    {{--<td><a href="{{ route('backend.comments.replies', $comment->token) }}" class="badge bg-primary">{{$comment->replys ? $comment->replys->count() : 0}} Réponses</a></td>--}}
                    <td>{{ mb_convert_case(\Carbon\Carbon::parse($comment->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, "UTF-8") }}</td>
                    <td>{{ mb_convert_case(\Carbon\Carbon::parse($comment->updated_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, "UTF-8") }}</td>
                    <td>
                        <form method="POST" id="delete-form-{{$comment->token}}" action="{{ route('backend.comments.destroy', $comment->token) }}">
                            @csrf
                            @method('delete')
                            <a href="{{ route('backend.comments.show', $comment->token) }}" class="btn btn-sm btn-warning"><i class="icon-base ri ri-eye-line icon-12px me-1"></i></a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{$comment->token}}', 'Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
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