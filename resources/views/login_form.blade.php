@extends('master')

@section('content')

<div class="container">
    <form>
        <div class="form-group row">
            <label for="inputName" class="col-sm-1-12 col-form-label"></label>
            <div class="col-sm-1-12">
                <input type="text" class="form-control" name="inputName" id="inputName" placeholder="">
            </div>
        </div>
        <fieldset class="form-group row">
            <legend class="col-form-legend col-sm-1-12">Group name</legend>
            <div class="col-sm-1-12">
                
            </div>
        </fieldset>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Action</button>
            </div>
        </div>
    </form>
</div>

@endsection