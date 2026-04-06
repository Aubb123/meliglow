<div class="chat-history-body ps">
    <ul class="list-unstyled chat-history">
        <h5 class="fw-bold text-decoration-underline"> ({{$blog->comments->count()}}) Commentaire(s)</h5>
        @foreach($comments as $comment)
        <!-- Commentaire   -->
        <li class="p-3 chat-message @if($comment->is_visible == false) bg-danger @endif">
            <div class="d-flex overflow-hidden">
                <div class="user-avatar flex-shrink-0 me-4">
                    <div class="avatar avatar-sm">
                        <img src="{{ $comment->user->getCoverImageUrl()['url_img']}}" alt="Avatar" class="rounded-circle">
                    </div>
                </div>
                <div class="chat-message-wrapper flex-grow-1">
                    <a class="text-primary text-primary" href="{{ route('backend.users.show', $comment->user->token) }}">{{$comment->user->lastname}} {{$comment->user->firstname}}</a>
                    <div class="chat-message-text">
                        <p class="mb-0">{{Str::limit($comment->content, 300)}}</p>
                    </div>
                    <div class="text-body-secondary mt-1">
                        <small>{{ mb_convert_case(\Carbon\Carbon::parse($comment->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, "UTF-8") }}</small>
                        <a href="{{ route('backend.comments.show', $comment->token) }}" class="badge bg-label-primary"><i class="ri-eye-2-line"></i> Détails</a>
                    </div>
                </div>
            </div>
        </li>
         
            {{-- <!-- Réponse  -->
            @foreach($comment->replys as $replie)
            <li class="border border-4 border-dark p-3 chat-message mt-2 @if($replie->is_visible == false) bg-danger @endif">
                <div class="d-flex overflow-hidden">
                    <div class="user-avatar flex-shrink-0 me-4">
                        <div class="avatar avatar-sm">
                            <img src="{{ $replie->user->getCoverImageUrl()['url_img'] }}" alt="Avatar" class="rounded-circle">
                        </div>
                    </div>
                    <div class="chat-message-wrapper flex-grow-1">
                        <span> Réponse de: <a class="text-primary text-primary" href="{{ route('backend.users.show', $replie->user->token) }}">{{$replie->user->lastname}} {{$replie->user->firstname}}</a> à <a class="text-primary text-primary" href="{{ route('backend.users.show', $replie->comment->user->token) }}">{{$replie->comment->user->lastname}} {{$replie->comment->user->firstname}}</a></span>
                        <div class="chat-message-text">
                            <p class="mb-0">{{Str::limit($replie->content, 300)}}</p>
                        </div>
                        <div class="text-body-secondary mt-1">
                            <small>{{ mb_convert_case(\Carbon\Carbon::parse($replie->created_at)->locale(app()->getLocale())->isoFormat('D MMMM YYYY - HH:mm:ss'), MB_CASE_TITLE, "UTF-8") }}</small>
                            <a href="{{ route('backend.replies.show', $replie->token) }}" class="badge bg-label-primary"><i class="ri-eye-2-line"></i> Détails</a>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
            <!-- Réponse  --> --}}
        <hr>
        @endforeach
        {{ $comments->appends(request()->input())->links('vendor.pagination.bootstrap-4') }} 
    </ul>
</div>