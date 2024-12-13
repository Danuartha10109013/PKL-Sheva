@extends('layout.main')
@section('title')
Forum Diskusi || {{ Auth::user()->name }}
@endsection
@section('pages')
Forum Diskusi
@endsection
@section('content')
<div class="card">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
            <h6>Forum Diskusi || {{ $project->judul }}</h6>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPostModal">
                <i class="fa fa-plus"></i> Create New Post
            </a>
            <!-- Create Post Modal -->
            <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    @if (Auth::user()->role == 3)
                    @else    
                        <h5 class="modal-title" id="createPostModalLabel">Create New Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    @endif
                    </div>
                    <form action="{{route('forum.post')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                        <label for="judul" class="form-label">Title</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                        <label for="desc" class="form-label">Description</label>
                        <textarea class="form-control" id="desc" name="desc" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input type="file" class="form-control" id="file" name="file">
                        </div>
                        <input type="hidden" name="forum_id" value="{{ $forum->id }}"> <!-- Adjust forum_id as needed -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Post</button>
                    </div>
                    </form>
                </div>
                </div>
            </div>
    
        </div>
    </div>
    <div class="card-body">
        <div class="chat-box" style="max-height: 400px; overflow-y: auto; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
            {{-- Postingan --}}
            @forelse($posts as $post)
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>{{ $post->judul }}</h3>
                        @php
                                $userin = \App\Models\User::find($post->user_id);
                        @endphp
                        <div class="d-flex align-items-center mb-1">
                            <img src="{{ asset('storage/user_profile/'.$userin->id.'/'.$userin->profile) }}" alt="{{ $userin->profile }}" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                            <small><strong>{{ $userin->name }}</strong></small>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>{{ $post->desc }}</p>
                        
                        @if($post->file)
                            <div class="mt-1">
                                @if(in_array(pathinfo($post->file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('storage/chat/' . $post->file) }}" width="50%" alt="Post Image" class="img-fluid">
                                @else
                                    <a href="{{ asset('storage/chat/' . $post->file) }}" target="_blank" class="btn btn-secondary">
                                        <i class="fa fa-download"></i> Download File
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#replies-{{ $post->id }}" aria-expanded="false" aria-controls="replies-{{ $post->id }}">
                            Reply ({{ $chat->where('post_id', $post->id)->count() }})
                        </button>
                    </div>
                    
                    {{-- Replies Section --}}
                    <div id="replies-{{ $post->id }}" class="collapse">
                        @foreach($chat->where('post_id', $post->id) as $message)
                            @php
                                $user = \App\Models\User::find($message->user_id);
                            @endphp
                            <div class="chat mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <img src="{{ asset('storage/user_profile/'.$user->id.'/'.$user->profile) }}" alt="{{ $user->profile }}" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                    <small><strong>{{ $user->name }}</strong></small>
                                </div>
                                <div class="chat-content">
                                    <p>{{ $message->chat }}</p>
                                    @if($message->file)
                                        <a href="{{ asset('storage/chat/' . $message->file) }}" target="_blank">
                                            <img src="{{ asset('storage/chat/' . $message->file) }}" alt="File" class="img-fluid" style="max-width: 50px;">
                                        </a>
                                    @endif
                                    <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
        
                        {{-- Chat Input Form --}}
                        <div class="row mt-3">
                            <div class="card" style="background-color: gray; color: white;">
                                <div class="card-body">
                                    <form action="{{ route('forum.message', $post->id) }}" method="POST" enctype="multipart/form-data" id="chatForm-{{ $post->id }}">
                                        @csrf
                                        <div class="row mt-2">
                                            <div class="col-md-10">
                                                <input type="text" name="message" class="form-control" placeholder="Type a reply...">
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                            </div>
                                            <div class="col-md-1">
                                                {{-- Hidden file input --}}
                                                <input type="file" name="file" id="fileInput-{{ $post->id }}" accept="image/*" style="display: none;">
                                                
                                                {{-- Attach file button --}}
                                                <button type="button" id="fileButton-{{ $post->id }}" class="btn btn-secondary">
                                                    <i class="fa-solid fa-paperclip"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-1">
                                                {{-- Send message button --}}
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa-solid fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No posts available.</p>
            @endforelse
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @foreach($posts as $post)
                document.getElementById('fileButton-{{ $post->id }}').addEventListener('click', function () {
                    document.getElementById('fileInput-{{ $post->id }}').click();
                });
                @endforeach
            });
        </script>
        
    </div>
</div>

<script>
    // JavaScript to handle the file input
    document.getElementById('fileButton').addEventListener('click', function() {
        document.getElementById('fileInput').click();
    });

    document.getElementById('fileInput').addEventListener('change', function() {
        if (this.files.length > 0) {
            alert(`File selected: ${this.files[0].name}`);
        }
    });
</script>
@endsection
