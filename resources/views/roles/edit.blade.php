@extends('panel.main')
@section('panel')
    <div class="card">
        <div class="card-header">
            @lang('users.edit role')
        </div>
        <div class="card-body">
            @if(session('successUpdate'))
                <div class="alert alert-success">
                    @lang('users.update success')
                </div>
            @endif
            <form method="post" action="{{route('roles.update', $role->id)}}">
                @csrf
                <div class="form-row">
                    <div class="col">
                        <input type="text" name="name" class="form-control" value="{{$role->name}}"
                               placeholder=" @lang('users.role name') ">

                        <small class="form-text text-danger"> </small>

                    </div>
                    <div class="col">
                        <input type="text" name="persian_name" class="form-control" value="{{$role->persian_name}}"
                               placeholder=" @lang('users.role persian name') ">

                        <small class=" form-text text-danger"> </small>

                    </div>
                </div>
                <div class="form-group mt-5">
                <span>
                    @lang('users.add permission to role')
                </span>
                    <hr>
                </div>
                <div class="form-group">
                    @forelse($permissions as $permission)
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" name='permissions[]' value="{{$permission->name}}"
                               class="custom-control-input" id="{{'id'.$permission->id}}"
                                {{$role->permission->contains($permission)? 'checked': ''}}>
                        <label class="custom-control-label" for="{{'id'.$permission->id}}">{{$permission->persian_name}}</label>
                    </div>
                    @empty

                    @endforelse

                </div>
                <div class=" form-group">
                    <button class="btn btn-primary">@lang('users.edit')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
