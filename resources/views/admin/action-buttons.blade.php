@if($section_name!='receive-stock-orders')
<div class="btn-group btn-group-sm">
    <a href="{{ url('admin/'.$section_name.'/'.$id.'/edit') }}" title="Edit {{$section_title}}" class="btn btn-sm btn-info tip mr-1">
        <i class="fa fa-edit"></i>
    </a>
</div>
@endif
@if($section_name!='roles' && $section_name!='receive-stock-orders')
<span data-toggle="tooltip" title="Delete {{$section_title}}" data-trigger="hover">
    <button class="btn btn-sm btn-danger deleteRecord" data-id="{{$id}}" type="button" data-url="{{ url('admin/'.$section_name.'/'.$id) }}" data-section="{{$section_name}}_table">
        <i class="fa fa-trash"></i>
    </button>
</span>
@endif
@if($section_name!='receive-stock-orders')
<div class="btn-group btn-group-sm">
    <a href="javascript:void(0)" title="View {{$section_title}}" data-id="{{$id}}" class="btn btn-sm btn-warning tip mr-1 view-info" data-url="{{ route($section_name.'.show', [strtolower(str_replace(' ', '_', $section_title)) => $id]) }}">
        <i class="fa fa-eye"></i>
    </a>
</div>
@else
<span data-toggle="tooltip" title="Delete {{$section_title}}" data-trigger="hover">
    <button class="btn btn-sm btn-danger deleteStockOrderDocumentRecord" data-id="{{$id}}" type="button" data-section="{{$section_name}}_table" data-type="receive_stock_order">
        <i class="fa fa-trash"></i>
    </button>
</span>

<div class="btn-group btn-group-sm">
    <a href="javascript:void(0)" title="View Documents" data-id="{{$id}}" class="btn btn-sm btn-success tip mr-1 view-documents" data-url="{{route('stock-orders.get_documents', ['id' => $id])}}">
        View Documents
    </a>
</div>
@endif

@if(isset($order_status))
<div class="btn-group btn-group-sm">
    <a href="{{ url('admin/stock-orders/'.$id.'/receive') }}" title="Recive Documents" data-id="{{$id}}" class="btn btn-sm btn-success tip mr-1">
        Receive
    </a>
</div>
@endif