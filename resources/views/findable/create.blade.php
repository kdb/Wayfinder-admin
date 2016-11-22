@extends('layouts.app')

@section('contentheader_title', 'Create Findable')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('pois.index') }}">Findables</a></li>
  <li class="active">Creating</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Details</h3>
        </div>
        {!! Form::open(['route' => 'findables.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="box-body">

          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('identifier', 'Identifier', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('identifier', null, ['class' => 'form-control', 'placeholder' => 'Enter identifier']) !!}
            </div>
          </div>

          <div class="form-group">
            {!! Form::label('parameter_one_name', 'Parameter One Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('parameter_one_name', null, ['class' => 'form-control', 'placeholder' => 'Enter parameter one name']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('parameter_two_name', 'Parameter Two Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('parameter_two_name', null, ['class' => 'form-control', 'placeholder' => 'Enter parameter two name']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('parameter_three_name', 'Parameter Three Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('parameter_three_name', null, ['class' => 'form-control', 'placeholder' => 'Enter parameter three name']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('parameter_four_name', 'Parameter Four Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('parameter_four_name', null, ['class' => 'form-control', 'placeholder' => 'Enter parameter four name']) !!}
            </div>
          </div>                              
      
          <div class="form-group">
            {!! Form::label('parameter_five_name', 'Parameter Five Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('parameter_five_name', null, ['class' => 'form-control', 'placeholder' => 'Enter parameter five name']) !!}
            </div>
          </div>


        </div>
        <div class="box-footer">
          <a href="{{ route('pois.index') }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection

@section('footer')
<script>

var dirty = false;
$( document ).ready( function ( ) {

	$( '#identifier' ).focus( function () {
		dirty = true;
	} );
	
	$( '#name' ).keyup( function () {
		if ( dirty == false ) {
			$( '#identifier' ).val( $( '#name' ).val() );
		}
	} );

} );

</script>	
@endsection