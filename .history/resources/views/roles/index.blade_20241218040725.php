@extends('layouts.master')
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@section('title')
{{__('messages.User Roles')}}
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{__('messages.USERS')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{__('messages.User Roles')}}</span>
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
                msg: "تم اضافة الدور بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('Edit'))
    <script>
        window.onload = function() {
            notif({
                msg:"تم تعديل الدور بنجاح",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('Delete'))
    <script>
        window.onload = function() {
            notif({
                msg:"تم حذف الدور بنجاح",
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
                msg: "Role Added SUccessfully",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('Edit'))
    <script>
        window.onload = function() {
            notif({
                msg: "Role Updated SUccessfully",
                type: "success"
            });
        }

    </script>
@endif

@if (session()->has('Delete'))
    <script>
        window.onload = function() {
            notif({
                msg: "Role Deleted SUccessfully",
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
                                <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">{{__('messages.Add')}} {{__('messages.User Roles')}}</a>
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
                                <th>{{__('messages.Role Name')}}</th>
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
                                            <a class="modal-effect btn btn-sm btn-danger"
   data-effect="effect-scale"
   data-role_id="{{ $role->id }}"
   data-rolename="{{ $role->name }}"
   data-toggle="modal"
   href="#modaldemo8"
   title="Delete">
   {{ __('messages.Delete') }}
</a>
                                                {{--{!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                                                $role->id], 'style' => 'display:inline']) !!}
                                                {!! Form::submit(__('messages.Delete'), ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}--}}
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

    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('messages.Delete') }} {{ __('messages.User Role') }}</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('roles.destroy','id') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>{{ __('messages.Are You Sure ?') }}</p><br>
                        <input type="form-control" name="role_id" id="role_id" value="">
                        <input class="form-control" name="rolename" id="rolename" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            {{ __('messages.Cancel') }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            {{ __('messages.Yes,Sure') }}
                        </button>
                    </div>
                </form>
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
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

<script>
    $('#modaldemo8').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var role_id = button.data('role_id'); // Extract role_id from data-* attribute
        var rolename = button.data('rolename'); // Extract rolename from data-* attribute

        var modal = $(this);
        modal.find('.modal-body #role_id').val(role_id); // Set role_id in the modal
        modal.find('.modal-body #rolename').val(rolename); // Set rolename in the modal
        // Update the form action dynamically
       modal.find('form').attr('action', '/roles/' + role_id);
    });
</script>


@endsection
