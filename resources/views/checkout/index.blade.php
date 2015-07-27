@extends('layout.frontend.master')

@section('content')
    <div class="panel-group checkout-page accordion scrollable" id="checkout-page">
        {{--{{adump(Session::all())}}--}}
        <!-- BEGIN CHECKOUT -->
        @include('checkout.option')
        <!-- END CHECKOUT -->

        <?php $option = Session::get('option');?>

        @if($option['type']=='register')
            <!-- BEGIN PAYMENT ADDRESS -->
            @include('checkout.payment_address')

            <script>
                document.getElementById('checkout-content').setAttribute('class', 'panel-collapse collapse');
                window.document.getElementById('payment-address-content').setAttribute('class', 'panel-collapse collapse in')
            </script>
            <!-- END PAYMENT ADDRESS -->

        @elseif($option['type']=='guest')
            <!-- BEGIN SHIPPING ADDRESS -->
            @include('checkout.shipping_address')
            <script>
                document.getElementById('checkout-content').setAttribute('class', 'panel-collapse collapse');
                document.getElementById('shipping-address-content').setAttribute('class', 'panel-collapse collapse in');
            </script>
            <!-- END SHIPPING ADDRESS -->
            @if($option['shi_add'])
                <!-- BEGIN PAYMENT METHOD -->
                @include('checkout.payment_method')
                <!-- END PAYMENT METHOD -->
                <script>
                    document.getElementById('shipping-address-content').setAttribute('class', 'panel-collapse collapse');
                    document.getElementById('payment-method-content').setAttribute('class', 'panel-collapse collapse in');
                </script>
            @endif
            @if($option['conf'])
                <!-- BEGIN CONFIRM -->
                @include('checkout.confirm')
                <!-- END CONFIRM -->
                <script>
                    document.getElementById('checkout-content').setAttribute('class', 'panel-collapse collapse');
                    document.getElementById('payment-method-content').setAttribute('class', 'panel-collapse collapse');
                    document.getElementById('confirm-content').setAttribute('class', 'panel-collapse collapse in');
                </script>
            @endif
            {{--if has logged , --}}
        @elseif($option['type']=='logged')
            <!-- BEGIN PAYMENT METHOD -->
            @include('checkout.payment_method')
            <!-- END PAYMENT METHOD -->
            <script>
                document.getElementById('checkout-content').setAttribute('class', 'panel-collapse collapse');
                document.getElementById('payment-method-content').setAttribute('class', 'panel-collapse collapse in');
            </script>
            @if($option['conf'])
                <!-- BEGIN CONFIRM -->
                @include('checkout.confirm')
                <!-- END CONFIRM -->
                <script>
                    document.getElementById('checkout-content').setAttribute('class', 'panel-collapse collapse');
                    document.getElementById('payment-method-content').setAttribute('class', 'panel-collapse collapse');
                    document.getElementById('confirm-content').setAttribute('class', 'panel-collapse collapse in');
                </script>
            @endif
        @elseif(is_null($option))
            <script>
                document.getElementById('checkout-content').setAttribute('class', 'panel-collapse collapse in');
            </script>
        @endif


    </div>
    <script>
        function toggle(mode) {
            var OPTION = 'checkout-content';
            var PAY_ADD = 'payment-address-content';
            var PAY_MED = 'payment-method-content';
            var SHI_ADD = 'shipping-address-content';
            var CONFIRM = 'confirm-content';
            if (mode == 'opt') {
                document.getElementById(OPTION).setAttribute('class', 'panel-collapse collapse');
            } else if (mode == 'pay_add') {
                document.getElementById(PAY_ADD).setAttribute('class', 'panel-collapse collapse');
            } else if (mode == 'pay_med') {
                document.getElementById(PAY_MED).setAttribute('class', 'panel-collapse collapse');
            } else if (mode == 'conf') {
                document.getElementById(PAY_ADD).setAttribute('class', 'panel-collapse collapse ');
                document.getElementById(PAY_MED).setAttribute('class', 'panel-collapse collapse ');
            } else if (mode == 'shi_add') {
                document.getElementById(SHI_ADD).setAttribute('class', 'panel-collapse collapse');
            }
        }
    </script>

    <!-- BEGIN CHECKOUT PAGE -->
    <div class="col-md-12 col-sm-12">
        <div class="modal fade " id="fgpw" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Let type your email.</h4>
                    </div>
                    <div class="modal-body">
                        {{----}}
                        <form action="{{action('AuthController@resetPassword')}}" method="POST" class="form-horizontal"
                              role="form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <td>Email:</td>
                                    <td><input type="email" name="email" id="" class="form-control" value="" title="">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel
                                </button>
                                <input type="submit" data-target="#pgpw" class="btn btn-primary Focus btnAddFocus"
                                       value="Send">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CHECKOUT PAGE -->
    </div>
    <!-- END CONTENT -->
    </div>
    <!-- END SIDEBAR & CONTENT -->
    </div>
    </div>

    <!-- BEGIN STEPS -->
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