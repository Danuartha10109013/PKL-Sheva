@extends('layout.main')
@section('title')
Checklist Progres || {{ Auth::user()->name }}
@endsection
@section('pages')
Checklist Progres
@endsection
@section('content')

<div class="card">
    <div class="card-header pb-0 p-3">
        <div class="d-flex justify-content-between">
            <h6 class="mb-2">List Of Task</h6>
        </div>
    </div>
    <div class="card-body">
        @if (!empty($data))
        <form action="{{route('pm.k-progres.update',$id)}}" method="POST">
            @csrf
            
            @foreach ($data as $index => $item)
                <div class="form-check">
                    <div class="mb-3 dynamic-input">
                        <input type="text" readonly name="scrum_name[]" value="{{ $item['scrum_name'] }}" placeholder="Fase {{ $index + 1 }}">
                        <input type="date" readonly name="start[]" value="{{ $item['start'] }}">
                        <input type="date" readonly name="end[]" value="{{ $item['end'] }}">
                        <input 
                                type="checkbox" 
                                class="form-check-input" 
                                id="status{{ $index }}" 
                                name="status[{{ $index }}]" 
                                value="1" 
                                {{ isset($item['status']) && $item['status'] == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="status{{ $index }}">
                                {{ isset($item['status']) && $item['status'] == 1 ? 'Sudah Selesai' : 'Belum Selesai' }}
                            </label>


                    </div>
                </div>
                @endforeach

                <button type="submit" class="btn btn-primary mt-2">Update</button>
            </form>
            <hr>
        @else
        <p>Belum Ada Task</p>
        @endif
    </div>
</div>
@endsection
