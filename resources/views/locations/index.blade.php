@extends('layouts.app')

@section('contentheader_title', 'Locations')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
  <li><a href="{{ route('places.index') }}">{{__('Places')}}</a></li>
  <li><a href="{{ route('places.show', $placeId) }}">{{ $place->name }}</a></li>
  <li><a href="{{ route('floors.show', [$placeId, $floorId]) }}">{{ $floor->name }}</a></li>
  <li class="active">{{__('Locations')}}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{__('Location list')}}</h3>
        </div>
        <div class="box-body no-padding">
          <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10px">{{__('#')}}</th>
                  <th>{{__('Name')}}</th>
                  <th>{{__('Place')}}</th>
                  <th>{{__('Floor')}}</th>
                  <th>{{__('POI')}}</th>
                  <th class="text-right">{{__('Actions')}}</th>
                </tr>
              @foreach($locations as $index => $location)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td><a href="{{ route('locations.show', [$placeId, $floorId, $location->id]) }}">{{ $location->name }}</a></td>
                  <td>{{ $location->place->name }}</td>
                  <td>{{ $location->floor->name }}</td>
                  <td>{{ $location->poi->name }}</td>
                  <td class="text-right">
                    {!! Form::open(['route' => ['locations.destroy', $placeId, $floorId, $location->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    <a href="{{ route('locations.edit', [$placeId, $floorId, $location->id]) }}" class="btn btn-primary btn-sm">{{__('Edit')}}</a>
                    {!! Form::close() !!}
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
        </div>
      </div>
  </div>
</div>
@endsection