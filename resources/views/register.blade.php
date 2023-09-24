@extends('layout')

@section('contenu')
    <form action="/register" method="post">
        {{csrf_field()}}
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input id="txtEmail" type="email" class="form-control" name="txtEmail" 
                placeholder="Email" value="{{old('txtEmail')}}">
            @if($errors->has('txtEmail'))
                {{$errors->first('txtEmail')}}
            @endif
        </div>
        <br>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="txtPwd" type="password" class="form-control" name="txtPwd" placeholder="Password">
        </div>
        @if($errors->has('txtPwd'))
            <p class="alert alert-danger"> {{$errors->first('txtPwd')}}</p>
        @endif
        <br>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="txtCPwd" type="password" class="form-control" name="txtPwd_confirmation" placeholder="Confirm Password">
            @if($errors->has('txtPwd_confirmation'))
                {{$errors->first('txtPwd_confirmation')}}
            @endif
        </div>
        <div class="checkbox">
            <label><input type="checkbox"> Remember me</label>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
@endsection