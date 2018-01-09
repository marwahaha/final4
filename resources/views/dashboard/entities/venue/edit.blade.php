@extends('dashboard.base')

@section('title')
    Edit {{ $venue->name }}
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <form action="{{ action('VenueController@update', ['id' => $venue->id]) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Venue Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $venue->name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" class="form-control" value="{{ $venue->longitude }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" class="form-control" value="{{ $venue->latitude }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ $venue->postal_code }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="timezone">Timezone</label>
                                    <input type="text" name="timezone" id="timezone" class="form-control" value="{{ $venue->timezone }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city" class="form-control" value="{{ $venue->city }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" name="country" id="country" class="form-control" value="{{ $venue->country }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" cols="30" rows="5" class="form-control">{{ $venue->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <img src="/img/venue-photos/{{ $venue->photo }}" alt="" class="img-thumbnail">

                                <div class="form-group">
                                    <div class="input-group input-group-file" data-plugin="inputGroupFile">
                                        <input type="text" class="form-control" readonly value="{{ $venue->photo }}">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                <i class="icon wb-upload"></i>
                                                <input type="file" name="venue_photo" id="venue_photo">
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-success" value="Update">
                        <a href="{{ action('VenueController@index') }}" class="text-muted">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer.scripts')
    <script src="{{ asset('js/dashboard/plugins/input-group-file.js') }}"></script>
@stop