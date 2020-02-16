<div class="card mt-3">
    <form method="post" action="/comment">

        @foreach($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
        @endforeach

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="Comment[commentable_id]" value="{{ $commentable_id }}">
        <input type="hidden" name="Comment[commentable_type]" value="{{ $commentable_type }}">

        <fieldset>
            <legend class="ml-3">Reply</legend>
            <div class="form-group">
                <div class="col-lg-12">
                    <textarea class="form-control" rows="3" id="content" name="Comment[content]"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-primary">Post</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>