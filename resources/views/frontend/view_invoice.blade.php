@extends('layout.frontend.master')
@section('content')
<div class="panel panel-success">
	  <div class="panel-heading">
			<h3 class="panel-title">Invoice list</h3>
	  </div>
	  <div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Count</th>
							<th>ID</th>
							<th>Time</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($invoices as $k=>$invoice)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$invoice['id']}}</td>
                                <td>{{$invoice['created_at']}}</td>
                                <td>
                                    <a href="{{action('FrontendController@viewInvoice',['id'=>$invoice['id']])}}"
                                       class="btn btn-info btn-sm"><span class="glyphicon glyphicon-eye-open"></span>View</a>
                                </td>
                            </tr>
                            @endforeach
					</tbody>
				</table>
			</div>
	  </div>
</div>
@stop