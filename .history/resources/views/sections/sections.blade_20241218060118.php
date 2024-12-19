@extends('layouts.master')

@section('css')

@section('title')
{{__('messages.Sections')}}
@stop

<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{__('messages.Settings')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{__('messages.Sections')}}</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

@if($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error )
		<li>{{$error}}</li>
		@endforeach
	</ul>
</div>
@endif
{{--here displays the error message when the section is added--}}
@if(session()->has('Add'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{session()->get('Add')}}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif
{{--here displays the error message when the section can not be  added--}}

@if(session()->has('Error'))
<div class="alert alert-damage alert-dismissible fade show" role="alert">
	<strong>{{session()->get('Error')}}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

{{--here displays the success message when the section can not be  updated--}}
@if(session()->has('edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{session()->get('edit')}}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

{{--here displays the success message when the section can not be  updated--}}
@if(session()->has('delete'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{session()->get('delete')}}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif
				<!-- row -->
				<div class="row">
					    {{-- here goes the page content  --}}
						{{--here displays the success message when the section is added--}}

                        <!--div-->
                        <div class="col-xl-12">
                            <div class="card mg-b-20">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between">
                                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">{{__('messages.Add')}} {{__('messages.section')}}</a>

                                    </div>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table key-buttons text-md-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="border-bottom-0">#</th>
                                                    <th class="border-bottom-0">{{__('messages.section_name')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.description')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.Actions')}}</th>

                                                </tr>
                                            </thead>
                                            <tbody>
												<?php $i=0; ?>
												@foreach ($sections as $section )
												<?php $i++; ?>
												<tr>
													<td>{{$i}}</td>
													<td>{{$section->section_name}}</td>
													<td>{{$section->description}}</td>
													<td>

														<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                       data-id="{{ $section->id }}" data-section_name="{{ $section->section_name }}"
                                                       data-description="{{ $section->description }}" data-toggle="modal" href="#exampleModal2"
                                                       title="Edit"><i class="las la-pen"></i></a>

                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                       data-id="{{ $section->id }}" data-section_name="{{ $section->section_name }}" data-toggle="modal"
                                                       href="#modaldemo9" title="Delete"><i class="las la-trash"></i></a>

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
								<!-- Basic modal -->

		<div class="modal" id="modaldemo8">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">{{__('messages.Add')}} {{__('messages.section')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>

					    <div class="modal-body">
							<form action="{{route('sections.store')}}" method="post">
								@csrf
						        <div class='form-group'>
							        <label for="exampleInputEmail">{{__('messages.section_name')}}</label>
							        <input type="text" class="form-control" id="section_name" name="section_name" required>
						        </div>

						        <div class='form-group'>
							        <label for="exampleFormControlTextarea1">{{__('messages.description')}}</label>
							        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
						        </div>
					            <div class="modal-footer">
						            <button class="btn btn-success" type="submit">{{__('messages.Save')}}</button>
						            <button class="btn btn-secondary" data-dismiss="modal" type="button">{{__('messages.Cancel')}}</button>
					            </div>
					        </form>
			        	</div>
			</div>
		</div>
		<!-- End Basic modal -->



				</div>
				                        <!-- edit -->
										<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
										aria-hidden="true">
									   <div class="modal-dialog" role="document">
										   <div class="modal-content">
											   <div class="modal-header">
												   <h5 class="modal-title" id="exampleModalLabel">{{__('messages.Edit')}} {{__('messages.section')}}</h5>
												   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
													   <span aria-hidden="true">&times;</span>
												   </button>
											   </div>
											   <div class="modal-body">

												   <form action="sections/update" method="post" autocomplete="off">
													   @method('patch')
													   @csrf
													   <div class="form-group">
														   <input type="text" name="id" id="id" value="">
														   <label for="recipient-name" class="col-form-label">{{__('messages.section_name')}} :</label>
														   <input class="form-control" name="section_name" id="section_name" type="text">
													   </div>
													   <div class="form-group">
														   <label for="message-text" class="col-form-label">{{__('messages.description')}} :</label>
														   <textarea class="form-control" id="description" name="description"></textarea>
													   </div>
											   </div>
											   <div class="modal-footer">
												   <button type="submit" class="btn btn-primary">{{__('messages.Save')}}</button>
												   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close{{__('messages.Cancel')}}</button>
											   </div>
											   </form>
										   </div>
									   </div>
								   </div>
								   <!--End Of Edit-->

								   <!-- delete -->
								   <div class="modal" id="modaldemo9">
									<div class="modal-dialog modal-dialog-centered" role="document">
										<div class="modal-content modal-content-demo">
											<div class="modal-header">
												<h6 class="modal-title">Delete Section</h6><button aria-label="Close" class="close" data-dismiss="modal"
																							   type="button"><span aria-hidden="true">&times;</span></button>
											</div>
											<form action="sections/destroy" method="post">
												@method('delete')
												@csrf
												<div class="modal-body">
													<p>Are You Sure You Want To Delete ?</p><br>
													<input type="hidden" name="id" id="id" value="">
													<input class="form-control" name="section_name" id="section_name" type="text" readonly>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
													<button type="submit" class="btn btn-danger">Delete</button>
												</div>
										</div>
										</form>
									</div>
								</div>
								<!--End Of Delete-->
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
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script>
	$('#exampleModal2').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var section_name = button.data('section_name')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #section_name').val(section_name);
		modal.find('.modal-body #description').val(description);
	})
</script>

<script>
	$('#modaldemo9').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var section_name = button.data('section_name')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #section_name').val(section_name);
		modal.find('.modal-body #description').val(description);
	})
</script>
@endsection
