@extends('layouts.master')
@section('css')
@section('title')
{{__('messages.Invoices')}}
@stop
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal Notify-->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet">

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{__('messages.Invoices')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{__('messages.Invoices Menu')}}</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
@if(app()->getLocale() == 'ar')
@if (session()->has('delete_invoice'))
    <script>
        window.onload = function() {
            notif({
                msg: "تم حذف الفاتورة بنجاح",
                type: "success"
            })
        }
    </script>
    @endif
    @if (session()->has('archive_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم أرشفة الفاتورة بنجاح",
                    type: "success"
                })
            }

        </script>
    @endif
    @else
    @if (session()->has('delete_invoice'))
    <script>
        window.onload = function() {
            notif({
                msg: "Invoice Deleted Successfully",
                type: "success"
            })
        }
    </script>
    @endif
    @if (session()->has('archive_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "Invoice Archived Successfully",
                    type: "success"
                })
            }
        </script>
    @endif
    @endif


@if($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error )
		<li>{{$error}}</li>
		@endforeach
	</ul>
</div>
@endif

@if(session()->has('Add'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{session()->get('Add')}}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif
				<!-- row -->
				<div class="row">
                    {{-- here goes the page content  --}}
                        <!--div-->
                        <div class="col-xl-12">
                            <div class="card mg-b-20">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between">
                                        <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="colr:white"><i class="fas fa-plus"></i>&nbsp; {{__('messages.Add Invoice')}}</a>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table key-buttons text-md-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="border-bottom-0">#</th>
                                                    <th class="border-bottom-0">{{__('messages.invoice_number')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.invoice_date')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.due_date')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.product')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.section')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.discount')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.rate_vat')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.value_vat')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.total')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.status')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.Notes')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.Actions')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i=0;
                                            @endphp
                                                @foreach ($invoices as $invoice)
                                                @php
                                                    $i++;
                                                @endphp
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td><a href="/invoicesDetails/{{$invoice->id}}">{{$invoice->invoice_number}}</a></td>
                                                    <td>{{$invoice->invoice_Date}}</td>
                                                    <td>{{$invoice->Due_date}}</td>
                                                    <td>{{$invoice->product}}</td>
                                                    <td>{{$invoice->Section->section_name}}</td>
                                                    <td>{{$invoice->Discount}}</td>
                                                    <td>{{$invoice->Value_VAT}}</td>
                                                    <td>{{$invoice->Rate_VAT}}</td>
                                                    <td>{{$invoice->Total}}</td>
                                                    <td>
                                                        @if ($invoice->Value_Status == 1)
                                                            <span class="text-success">{{ $invoice->Status }}</span>
                                                        @elseif($invoice->Value_Status == 2)
                                                            <span class="text-danger">{{ $invoice->Status }}</span>
                                                        @else
                                                            <span class="text-warning">{{ $invoice->Status }}</span>
                                                        @endif

                                                    </td>
                                                    <td>{{$invoice->note}}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary btn-sm"
                                                            data-toggle="dropdown" type="button">{{__('messages.Actions')}}<i class="fas fa-caret-down ml-1"></i></button>
                                                            <div  class="dropdown-menu tx-13">
                                                                <a class="dropdown-item" href="{{ url('edit_invoice') }}/{{ $invoice->id }}">{{__('messages.Edit Invoice')}}</a>

                                                                <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                                    data-toggle="modal" data-target="#delete_invoice"><i
                                                                        class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;{{__('messages.Delete Invoice')}}</a>


                                                                        <a class="dropdown-item"
                                                                        href="{{ URL::route('Status_show', [$invoice->id]) }}"><i
                                                                            class=" text-success fas fa-money-bill"></i>&nbsp;&nbsp;{{__('messages.Change Status')}}</a>

                                                                            <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}"
                                                                                data-toggle="modal" data-target="#Transfer_invoice"><i
                                                                                    class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;{{__('messages.Move To Archive')}}</a>

                                                                                <a class="dropdown-item" href="Print_invoice/{{ $invoice->id }}"><i
                                                                                    class="text-success fas fa-print"></i>&nbsp;&nbsp;{{__('messages.Print Invoice')}}
                                                                            </a>
                                                            </div>
                                                        </div>
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
                        </div>
                    </div>

                    <!-- حذف الفاتورة -->
    <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>{{__('messages.Delete Invoice')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
            </div>
            <div class="modal-body">
                {{__('messages. Are You Sure ?')}}
                <input type="hidden" name="invoice_id" id="invoice_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.Cancel')}}</button>
                <button type="submit" class="btn btn-danger">{{__('messages.Yes,Sure')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>

 <!-- ارشيف الفاتورة -->
 <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">{{__('messages.Move To Archive')}}</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                 {{ method_field('delete') }}
                 {{ csrf_field() }}
         </div>
         <div class="modal-body">
            {{__('messages. Are You Sure ?')}}
             <input type="text" name="invoice_id" id="invoice_id" value="">
             {{--this id is for identifying the archive operation from the delete operation:--}}
             <input type="hidden" name="id_page" id="id_page" value="2">

         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.Cancel')}}</button>
             <button type="submit" class="btn btn-success">{{__('messages.Yes,Sure')}}</button>
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
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!-- Internal Notify js-->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

<script>
    $('#delete_invoice').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_id = button.data('invoice_id')
        var modal = $(this)
        modal.find('.modal-body #invoice_id').val(invoice_id);
    })

</script>

<script>
    $('#Transfer_invoice').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var invoice_id = button.data('invoice_id')
        var modal = $(this)
        modal.find('.modal-body #invoice_id').val(invoice_id);
    })

</script>
@endsection
