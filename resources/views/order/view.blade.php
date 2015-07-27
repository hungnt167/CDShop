<div class="modal fade " id="popView" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                {{--{!!Form::open(array('action'=>''--}}
                {{--,'method'=>'POST','files'=>true))!!}--}}

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <ul class="nav nav-tabs responsive">
                        <li class="active "><a href="#order-info-tab" data-toggle="tab">Order Information</a>
                        </li>
                        <li>
                            <a href="#order-detail-tab" data-toggle="tab">Order Detail</a>
                        </li>
                        <li><a href="#delivery-detail-tab" data-toggle="tab">Customer Information</a>
                        </li>
                        <li><a href="#other-tab" data-toggle="tab">Other</a>
                        </li>
                    </ul>
                    <div class="tab-content responsive">
                        {{--Order Information--}}
                        <div class="tab-pane fade in active" id="order-info-tab">
                            <div class="panel panel-default ">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Order Information</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                            <tbody>
                                            <tr>
                                                <td class="col-md-4">ID</td>
                                                <td id="id"></td>
                                            </tr>
                                            <tr>
                                                <td>Customer name</td>
                                                <td id="name_customer"></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td id="email"></td>
                                            </tr>
                                            <tr>
                                                <td>Item</td>
                                                <td id="item"></td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td id="total"></td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td id="status"></td>
                                            </tr>
                                            <tr>
                                                <td>Time</td>
                                                <td id="time"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center btn-nav">
                                <a href="#order-detail-tab" class="btn-sm btn-info" data-toggle="tab">>>Order Detail</a>
                            </div>
                        </div>
                        {{--Order Detail--}}
                        <div class="tab-pane fade" id="order-detail-tab">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Order Detail</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <td class="">ID</td>
                                                <td>Product</td>
                                                <td>Root price</td>
                                                <td>Price</td>
                                                <td>Quantity</td>
                                                <td>Total</td>
                                            </tr>
                                            </thead>
                                            <tbody id="order_detail_row">
                                            <tr>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center btn-nav">
                                <a href="#order-info-tab" class="btn-sm btn-info" data-toggle="tab">Order
                                    Information<<</a>
                                <a href="#delivery-detail-tab" class="btn-sm btn-info" data-toggle="tab">Delivery Detail>></a>
                            </div>
                        </div>
                        {{--Customer Info--}}
                        <div class="tab-pane fade" id="delivery-detail-tab">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Delivery Detail</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                            <tbody>
                                            <tr>
                                                <td>Customer name</td>
                                                <td id="name_customer"></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td id="email"></td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td id="phone"></td>
                                            </tr>
                                            <tr>
                                                <td>Address1</td>
                                                <td id="address1"></td>
                                            </tr>
                                            <tr>
                                                <td>Address2</td>
                                                <td id="address2"></td>
                                            </tr>
                                            <tr>
                                                <td>City</td>
                                                <td id="city"></td>
                                            </tr>
                                            <tr>
                                                <td>State</td>
                                                <td id="state"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center btn-nav">
                                <a href="#order-detail-tab" class="btn-sm btn-info" data-toggle="tab">Delivery Detail<<</a>
                                <a href="#other-tab" class="btn-sm btn-info" data-toggle="tab">Other>></a>
                            </div>
                        </div>

                        {{--other--}}
                        <div class="tab-pane fade" id="other-tab">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Other</h3>
                                </div>
                                <div class="panel-body">
                                    <textarea class="form-control" disabled  name="" id="comment" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="text-center btn-nav">
                                <a href="#delivery-detail-tab" class="btn-sm btn-info" data-toggle="tab">Customer
                                    Information<<</a>
                            </div>
                            <hr/>

                        </div>
                    </div>
                </div>


                <div class="modal-footer">


                </div>

            </div>
        </div>
    </div>
</div>
