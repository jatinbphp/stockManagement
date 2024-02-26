<!-- Modal content -->
<div class="modal-header">
    <h5 class="modal-title" id="commonModalLabel">Stock Order Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 25%;">Id:</th>
                                        <td>#{{ $stock_order->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Supplier Information:</th>
                                        <td>
                                            {{ $stock_order->supplier->name }} <br>
                                            {{ $stock_order->supplier->email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Brand Name:</th>
                                        <td>{{ $stock_order->brand->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Practice Information:</th>
                                        <td>
                                            {{ $stock_order->practice->name }} <br>
                                            {{ $stock_order->practice->email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Order Copy:</th>
                                        <td>
                                            @if (!empty($stock_order->order_copy) && file_exists($stock_order->order_copy))
                                                <a target="_blank" href="{{ $stock_order->order_copy }}" download>
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Instructions:</th>
                                        <td>{{ $stock_order->instructions }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            @if($stock_order->status == 'incomplete')
                                                <span class="badge badge-warning">Order Received Incomplete</span>
                                            @elseif($stock_order->status == 'completed')
                                                <span class="badge badge-success">Order Received Complete</span>
                                            @elseif($stock_order->status == 'open')
                                                <span class="badge badge-primary">Dispatched</span>
                                            @elseif($stock_order->status == 'newone')
                                                <span class="badge badge-secondary">Displayed</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Date Created:</th>
                                        <td>{{ $stock_order->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Goods Received:</th>
                                        <td>
                                            <a class="btn-sm btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" onclick="reloadStockOrdersTable();">
                                                Click here
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row collapse" id="collapseExample">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Uploaded Documents</h3>
                                </div>
                                <div class="card card-body">
                                    <input type="hidden" id="receive_route_name" value="{{ route('stock-orders.index_receive_stock_order') }}">
                                    <input type="hidden" id="stock_order_id" value="{{$stock_order->id}}">
                                    @include ('admin.stock-order.receive-stock-order-table')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>