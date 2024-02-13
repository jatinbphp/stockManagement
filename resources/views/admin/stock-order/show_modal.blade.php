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
                                        <td>{{ ucfirst($stock_order->status) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created Date:</th>
                                        <td>{{ $stock_order->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                </tbody>
                            </table>
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
