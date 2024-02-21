@if(!isset($store_order_status) || $store_order_status !== 'completed')
    <div class="btn-group btn-group-sm">
        <a href="{{ url('admin/'.$section_name.'/'.$id.'/edit') }}" title="Edit {{$section_title}}" class="btn btn-sm btn-info tip ">
            <i class="fa fa-edit"></i>
        </a>
    </div>
@endif

@if(isset($store_order_status) && ($store_order_status!='completed'))
    <span data-toggle="tooltip" title="Delete {{$section_title}}" data-trigger="hover">
        <button class="btn btn-sm btn-danger deleteStockOrderDocumentRecord" data-id="{{$id}}" type="button" data-section="{{$section_name}}_table" data-type="receive_stock_order">
            <i class="fa fa-trash"></i>
        </button>
    </span>
@endif

<div class="btn-group btn-group-sm">
    <a href="javascript:void(0)" title="View Documents" data-id="{{$id}}" class="btn btn-sm btn-success tip  view-documents" data-url="{{route('stock-orders.get_documents', ['id' => $id])}}">
        <i class="fa fa-eye"></i>
    </a>
</div>