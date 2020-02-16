@extends('master')
@section('title', 'Edit a post')

@section('content')
    <div class="container col-md-8 col-md-offset-2">
        <div class="card mt-5">
            <div class="card-header ">
                <h5 class="float-left">Edit post</h5>
                <div class="clearfix"></div>
            </div>
            <div class="card-body mt-2">
                <form method="post">
                    @foreach ($errors->all() as $error)
                        <p class="alert alert-danger">{{ $error }}</p>
                    @endforeach
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <fieldset>
                        <div class="form-group">
                            <label for="title" class="col-lg-2 control-label">Title</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="title" placeholder="Title" name="Ticket[title]" value="{{ $ticket->title }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-lg-2 control-label">Content</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" rows="3" id="content" name="Ticket[content]">{{ $ticket->content }}</textarea>
                                <span class="help-block">Feel free to ask us any question.</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10">
                            <label for="select_tags">Hash Tags</label>
                                <select class="form-control select2" id="select_tags" name="tags[]" multiple>
                                    @foreach ($tags as $tag)
                                        <option value="{{$tag->id}}" @if(in_array($tag->id,$list_tagged)) selected @endif>{{$tag->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="Ticket[status]" {{ $ticket->status?"":"checked"}} > Close this ticket?
                            </label>
                        </div>

                        
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection