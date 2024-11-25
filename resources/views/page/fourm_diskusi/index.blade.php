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
        </div>
    </div>
    <div class="card-body">
        <div class="chat-box" style="max-height: 400px; overflow-y: auto; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
            {{-- Display chats dynamically --}}
            
            @foreach($chat as $message)
            @php
                $user = \App\Models\User::find($message->user_id);
            @endphp
                <div class="chat mb-3">
                    <div class="d-flex align-items-center mb-1">
                        <img src="{{asset('storage/user_profile/'.$user->id.'/'.$user->profile)}}" alt={{$user->profile}}" class="rounded-circle me-2" style="width: 40px; height: 40px;">
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
        </div>

        {{-- Chat input form --}}
        <div class="row mt-3">
            <div class="card" style="background-color: gray; color: white;">
                <div class="card-body">
                    <form action="{{ route('forum.message', $forum->id) }}" method="POST" enctype="multipart/form-data" id="chatForm">
                        @csrf
                            <div class="row mt-2">
                                <div class="col-md-10">
                                    <input type="text" name="message" class="form-control " placeholder="Type a message..." >
                                    <input type="hidden" name="project_id" value="{{$forum->id}}">
                                </div>
                                <div class="col-md-1">

                                    {{-- Hidden file input --}}
                                    <input type="file" name="file" id="fileInput" accept="image/*" style="display: none;">
        
                                    {{-- Attach file button --}}
                                    <button type="button" id="fileButton" class="btn btn-secondary ">
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
