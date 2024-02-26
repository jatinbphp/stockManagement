<div style=" display: flex;">
    <select class="form-control stockOrderStatus" id="status{{$id}}"  data-id="{{$id}}" >';
        @foreach($stock_order_status as $key => $statusName)
            @php $selected = ($key == $status) ? 'selected' : ''; @endphp
            <option {{$selected}} value="{{$key}}">{{$statusName}}</option>
        @endforeach
    </select>
    <a href="javascript:void(0)" class="get-status-history" style="margin: 5px;" data-id="{{$id}}" data-url="{{route('stock-orders.get_history', ['id' => $id])}}"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></a>
</div>