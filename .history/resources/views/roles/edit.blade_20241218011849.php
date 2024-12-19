@extends('layouts.master')
@section('css')
<!--Internal  Font Awesome -->
<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@section('title')
{{__('messages.Edit')}} {{__('messages.User Authority')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{__('messages.Users Authorities')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{__('messages.Edit')}} {{__('messages.User Authority')}}</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{__('messages.Back')}}</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


{!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('roles.index') }}">{{__('messages.Back')}}</a>
                    </div>
                </div>
                <div class="main-content-label mg-b-5">
                    <div class="form-group">
                        <p>{{__('messages.Authority Name')}} :</p>
                        <input name="name" class=form-control value={{$role->name}}>
                    </div>
                </div>
                <div class="row">
                    <!-- col -->
                    <div class="col-lg-4">
                        <ul id="treeview1">
                            <li><a href="#">{{__('messages.Authorities')}}</a>
                                <ul>
                                    <li>
                                        @foreach($permissions as $permission)
            <div>
                <input
                    type="checkbox"
                    id="permission_{{ $permission->id }}"
                    name="permissions[]"
                    value="{{ $permission->id }}"
                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                <label for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
            </div>
        @endforeach
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-main-primary">{{__('messages.Edit')}}</button>
                    </div>
                    <!-- /col -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
{!! Form::close() !!}
@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection
