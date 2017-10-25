@extends('dashboard.base')

@section('title')
    Edit {{ ucfirst($rate->name) }}
@stop

@section('content')
    <form action="{{ action('RateController@update', ['id' => $rate->id]) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $rate->name }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="color_code">Color Code</label>
                    <input type="text" name="color_code" id="color_code" class="form-control" value="{{ $rate->color_code }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" id="price" class="form-control" value="{{ $rate->price }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="available">Total Available</label>
                    <input type="text" name="available" id="available" class="form-control" readonly value="{{ $rate->available }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="available_online">Available Online</label>
                    <select name="available_online" id="available_online" class="form-control">
                        <option value="0" {{ $rate->available_online == false ? 'selected': '' }}>No</option>
                        <option value="1" {{ $rate->available_online == true ? 'selected': '' }}>Yes</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="available_box_office">Available Box Office</label>
                    <select name="available_box_office" id="available_box_office" class="form-control">
                        <option value="0" {{ $rate->available_box_office == true ? 'selected': '' }}>No</option>
                        <option value="1" {{ $rate->available_box_office == true ? 'selected': '' }}>Yes</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="online_fee">Online Fee</label>
                    <input type="text" name="online_fee" id="online_fee" class="form-control" value="{{ $rate->online_fee }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="box_office_fee">Box Office Fee</label>
                    <input type="text" name="box_office_fee" id="box_office_fee" class="form-control" value="{{ $rate->box_office_fee }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="online_comission">Online Comission</label>
                    <input type="text" name="online_comission" id="online_comission" class="form-control" value="{{ $rate->online_comission }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="box_office_comission">Box Office Comission</label>
                    <input type="text" name="box_office_comission" id="box_office_comission" class="form-control" value="{{ $rate->box_office_comission }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tax_percentage">Tax Percentage</label>
                    <input type="text" name="tax_percentage" id="tax_percentage" class="form-control" value="{{ $rate->tax_percentage }}">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="zones">Zones</label>
                    <select name="zones" id="zones" class="form-control" multiple>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-success" value="Update">
        <a href="{{ action('RateController@index') }}" class="text-muted">Cancel</a>
    </form>
@stop