@extends('layouts.app')

@section('contentheader_title', 'Create IMS')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('places.index') }}">Places</a></li>
  <li><a href="{{ route('places.show', $placeId) }}">{{ $place->name }}</a></li>
  <li><a href="{{ route('floors.show', [$placeId, $floorId]) }}">{{ $floor->name }}</a></li>
  <li class="active">Create IMS</li>
</ol>
@endsection

@section('content')
{!! Form::open(['route' => ['locations.store', $placeId, $floorId], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
{!! Form::hidden('place_id', $placeId) !!}
{!! Form::hidden('floor_id', $floorId) !!}
{!! Form::hidden('type', 'ims') !!}

<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Details</h3>
        </div>
        <div class="box-body">

          <div class="form-group">
            {!! Form::label('parameter_one', 'IMS Identifier', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('parameter_one', null, ['class' => 'form-control', 'placeholder' => 'Enter IMS Identifier']) !!}
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}

            <div class="col-sm-10">
              {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter location name']) !!}
            </div>
          </div>

        </div>
        <div class="box-footer">
          <a href="{{ route('floors.show', [$placeId, $floorId]) }}" class="btn btn-default">Cancel</a>
          <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
      </div>
  </div>
</div>
{!! Form::close() !!}
@endsection