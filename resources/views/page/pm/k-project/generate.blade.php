<form action="{{route('ckeditor.upload')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="upload">Create Image link</label>
    <br>
    <div class="row">
        <div class="col-md-8">
            <input class="form-control" type="file" name="upload">
        </div>
        <div class="col-md-4 text-center">
            <button class="btn btn-success">Generate</button>
        </div>
    </div>
</form>
