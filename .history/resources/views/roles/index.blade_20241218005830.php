@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@section('title')
{{__('messages.Users Authorities')}}
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{__('messages.USERS')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{__('messages.Users Authorities')}}</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
@if(app()->getLocale() == 'ar')
@if (session()->has('Add'))
    <script>
        window.onload = function() {
            notif({
                msg: "تم اضافة الصلاحية بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('Edit'))
    <script>
        window.onload = function() {
            notif({
                msg:"تم تعديل الصلاحية بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('Delete'))
    <script>
        window.onload = function() {
            notif({
                msg:"تم حذف الصلاحية بنجاح",
                type: "error"
            });
        }

    </script>
@endif
@else
@if (session()->has('Add'))
    <script>
        window.onload = function() {
            notif({
                msg: "Authority Added SUccessfully",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('Edit'))
    <script>
        window.onload = function() {
            notif({
                msg: "Authority Updated SUccessfully",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('Delete'))
    <script>
        window.onload = function() {
            notif({
                msg: "Authority Deleted SUccessfully",
                type: "error"
            });
        }

    </script>
@endif
@endif

<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            @can('Add Authority')
                                <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">{{__('messages.Add User')}}</a>
                            @endcan
                        </div>
                    </div>
                    <br>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap table-hover ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('messages.Authority Name')}}</th>
                                <th>{{__('messages.Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @can('Show Authority')
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('roles.show', $role->id) }}">{{__('messages.Show')}}</a>
                                        @endcan

                                        @can('Edit Authority')
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('roles.edit', $role->id) }}">{{__('messages.Edit')}}</a>
                                        @endcan

                                        @if ($role->name !== 'Admin')
                                            @can('Delete Authority')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                                                $role->id], 'style' => 'display:inline']) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        @endif


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
