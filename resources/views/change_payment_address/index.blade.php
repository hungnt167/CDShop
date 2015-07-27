@extends('layout.frontend.master')
@section('content')
        <div class="panel panel-info">
        	  <div class="panel-heading">
        			<h3 class="panel-title">Panel title</h3>
        	  </div>
        	  <div class="panel-body">
                  <div class="col-md-6 col-sm-6">
                      <h3>Your Personal Details</h3>

                      <form action="{{action('AuthController@postUpdatePaymentAddressCustomer')}}" method="post">
                          <input value="{{csrf_token()}}" name="_token" type="hidden"/>


                          <div class="form-group">
                              <label for="telephone">Telephone <span class="require">*</span></label>
                              <input name="phone" value="{{$info['user']['phone']}}" type="tel" id="telephone" class="form-control">
                          </div>

                  </div>
                  <div class="col-md-6 col-sm-6">
                      <h3>Your Address</h3>


                      <div class="form-group">
                          <label for="address1">Address 1</label>
                          <input name="address1" value="{{$info['address1']}}" type="text" id="address1" class="form-control">
                      </div>
                      <div class="form-group">
                          <label for="address2">Address 2</label>
                          <input name="address2" value="{{$info['address2']}}" type="text" id="address2" class="form-control">
                      </div>

                      <div class="form-group">
                          <label for="country">City <span class="require">*</span></label>
                          <select name="city_id" value="{{$info['city_id']}}" class="form-control input-sm" id="city_id">
                              @foreach($cities as $city)
                                  <option value="{{$city['id']}}"
                                          @if($city['id'] == $currentCity)
                                              selected="selected"
                                              @endif
                                          > {{$city['name']}}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="region-state">Region/State <span class="require">*</span></label>
                          <select name="state_id" value="{{$info['state_id']}}" class="form-control input-sm" id="state">
                                  <option value="{{$state['id']}}"> {{$state['name']}}</option>
                          </select>
                      </div>

                  </div>

                  <hr>
                  <div class="col-md-12">

                      <div class="checkbox">
                          <label>
                              <input name="check" type="checkbox" checked="checked"> My delivery and billing addresses are the
                              same.
                          </label>
                      </div>
                      <input type="hidden" name="id" value="{{$info['id']}}">
                      <button class="btn btn-primary  pull-right"  type="submit"
                              data-toggle="collapse"
                              data-parent="#checkout-page" data-target="#confirm-content"
                              id="button-confirm">Update
                      </button>

                      </form>
                  </div>
        	  </div>
        </div>
@stop
@section('script')
    <script>
        $(document).ready(function () {
            $('#city_id').click(function () {
                id = $(this).val();
                $.ajax({
                    url: '{{action('FrontendController@listState')}}',
                    method: 'post',
                    data: {id: id, _token: '{{csrf_token()}}'},
                    dataType: 'json'
                }).success(function (data) {
                    tagOption = '';
                    $.each(data, function (key, value) {
                        tagOption += '<option value="';
                        tagOption += value.id;
                        tagOption += '">' + value.name + '</option>';
                    });
                    $('#state').html(tagOption);
                });
            });
        });
    </script>
@stop