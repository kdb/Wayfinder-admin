@extends('layouts.app')

@section('contentheader_title', 'Beacons')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li><a href="/"><i class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
  <li class="active">{{__('Beacons')}}</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{__('List')}}</h3>
        </div>
        <div class="box-body no-padding">
          <table class="table">
              <tbody>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>{{__('Name')}}</th>
                  <th>{{__('Major')}}</th>
				  <th>{{__('Minor')}}</th>
                  <th>{{__('Place')}}</th>
                  <th>{{__('Floor')}}</th>
                  <th class="text-right"></th>
                </tr>
              @foreach($beacons as $index => $beacon)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td><a href="{{ route('beacons.edit', $beacon->id) }}">{{ $beacon->name }}</a></td>
                  <td>{{ $beacon->major or 'n/a' }}</td>
                  <td>{{ $beacon->minor or 'n/a' }}</td>
                  <td>{{ $beacon->place->name or 'Not assigned' }}</td>
                  <td>{{ $beacon->floor->name or 'Not assigned' }}</td>
                  <td class="text-right">
                    {!! Form::open(['route' => ['beacons.destroy', $beacon->id], 'method' => 'DELETE']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                    <a href="{{ route('beacons.edit', $beacon->id) }}" class="btn btn-primary btn-sm">{{__('Edit')}}</a>
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