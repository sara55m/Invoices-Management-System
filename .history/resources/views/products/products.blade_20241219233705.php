@extends('layouts.master')
@section('css')
@section('title')
{{__('messages.Products')}}
@stop

<!-- Internal Data table css -->
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Owl Carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{ URL::asset('assets/plugins/multislider/multislider.css') }}" rel="stylesheet">
    <!--- Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{__('messages.Settings')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{__('messages.Products')}}</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">

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


{{--here displays the success message when the product is updated--}}

@if(session()->has('Edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{session()->get('Edit')}}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

@if (session()->has('delete'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('delete') }}</strong>
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
                                    @can('Add Product')
                                    <div class="d-flex justify-content-between">
                                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">{{__('messages.Add')}} {{__('messages.product')}}</a>
                                    </div>
                                    @endcan

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                                            <thead>
                                                <tr>
                                                    <th class="border-bottom-0">#</th>
                                                    <th class="border-bottom-0">{{__('messages.product_name')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.description')}}</th>
                                                    <th class="border-bottom-0">{{__('messages.section_name')}}</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0;?>
                                                @foreach ($products as $product )
                                                <?php $i++;?>
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$product->product_name}}</td>
                                                    <td>{{$product->description}}</td>
                                                    <td>{{$product->section->section_name}}</td>
                                                    <td>
                                                        <button class="btn btn-outline-success btn-sm"
                                                            data-product_name="{{ $product->product_name }}" data-product_id="{{ $product->id }}"
                                                            data-description="{{ $product->description }}"
                                                            data-section_name="{{ $product->section->section_name }}" data-toggle="modal"
                                                            data-target="#edit_Product">{{__('messages.Edit')}}</button>

                                                        <button class="btn btn-outline-danger btn-sm " data-product_id="{{ $product->id }}"
                                                            data-product_name="{{ $product->product_name }}" data-toggle="modal"
                                                            data-target="#modaldemo9">{{__('messages.Delete')}}</button>
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

                                            <!-- add pop-up form -->
                    <div class="modal fade" id="modaldemo8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{__('messages.Add')}} {{__('messages.product')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                    <form action="{{route('products.store')}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{__('messages.product_name')}}</label>
                                            <input type="text" class="form-control" id="product_name" name="product_name" required >

                                        </div>

                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">{{__('messages.section_name')}}</label>
                                        <select name="section_id" id="section_id" class="form-control" required>
                                            <option value="" selected disabled> --{{__('messages.Choose Section')}}</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                            @endforeach
                                        </select>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">{{__('messages.description')}}</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">{{__('messages.Save')}}</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.Cancel')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- edit -->
                    @can('Edit Product')
        <div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('messages.Edit')}} {{__('messages.product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action='products/update' method="post">
                    @method('patch')
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" class="form-control" name="product_id" id="product_id" value="" >
                            <label for="title">{{__('messages.product_name')}} :</label>
                            <input type="text" class="form-control" name="product_name" id="product_name">
                        </div>

                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">{{__('messages.section_name')}}</label>
                        <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                            @foreach ($sections as $section)
                                <option>{{ $section->section_name }}</option>
                            @endforeach
                        </select>

                        <div class="form-group">
                            <label for="description">{{__('messages.description')}}: </label>
                            <textarea name="description" cols="20" rows="5" id='description'
                                class="form-control"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{__('messages.Save')}}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.Cancel')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    <!-- delete -->
    @can('Delete Product')
    <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('messages.Delete')}} {{__('messages.product')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="products/destroy" method="post">
                @method('delete')
                @csrf
                <div class="modal-body">
                    <p>{{__('messages.Are You Sure ?')}}</p><br>
                    <input type="hidden" name="product_id" id="product_id" value="">
                    <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.Cancel')}}</button>
                    <button type="submit" class="btn btn-danger">{{__('messages.Yes,Sure')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan

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
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
<!-- Internal Prism js-->
<script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
<!--Internal  Datepicker js -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<!-- Internal Select2 js-->
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Internal Modal js-->
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>

<script>
    $('#edit_Product').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var product_name = button.data('product_name')
        var product_id = button.data('product_id')
        var description = button.data('description')
        var section_name = button.data('section_name')
        var modal = $(this)
        modal.find('.modal-body #product_name').val(product_name);
        modal.find('.modal-body #description').val(description);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #product_id').val(product_id);
    })

    $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var product_id = button.data('product_id')
            var product_name = button.data('product_name')
            var modal = $(this)

            modal.find('.modal-body #product_id').val(product_id);
            modal.find('.modal-body #product_name').val(product_name);
        })
</script>
@endsection