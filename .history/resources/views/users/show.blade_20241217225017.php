@extends('layouts.master')
@section('css')
<!--Internal  Font Awesome -->
<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />

@section('title')
{{__('messages.Show User')}}
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{__('messages.USERS')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{__('messages.Show User')}}</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->


<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('roles.index') }}">{{__('messages.Back')}}</a>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Image:</strong>
                            <img src="{{ asset('images/' . $user->image) }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                        </div>
                    </div>

                    <!-- col -->
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $user->name }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            {{ $user->email }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Roles:</strong>
                            @if(!empty($userRoles))
                            @foreach($userRoles as $v)
                            <label class="badge badge-success">{{ $v->name }}</label>
                            @endforeach
                            @endif
                        </div>
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
@endsection
@section('js')
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>

@endsection
