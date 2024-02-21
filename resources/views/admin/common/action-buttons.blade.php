<!-- below is condition for the edit button hidden in the role management for the admin role. -->
@if(!isset($login_user))
    <div class="btn-group btn-group-sm">
        <a href="{{ url('admin/'.$section_name.'/'.$id.'/edit') }}" title="Edit {{$section_title}}" class="btn btn-sm btn-info tip ">
            <i class="fa fa-edit"></i>
        </a>
    </div>
@endif
<!-- remove delete button from the role management -->
@if($section_name!='roles')
    <span data-toggle="tooltip" title="Delete {{$section_title}}" data-trigger="hover">
        <button class="btn btn-sm btn-danger deleteRecord" data-id="{{$id}}" type="button" data-url="{{ url('admin/'.$section_name.'/'.$id) }}" data-section="{{$section_name}}_table">
            <i class="fa fa-trash"></i>
        </button>
    </span>
@endif

<div class="btn-group btn-group-sm">
    <a href="javascript:void(0)" title="View {{$section_title}}" data-id="{{$id}}" class="btn btn-sm btn-warning tip  view-info" data-url="{{ route($section_name.'.show', [strtolower(str_replace(' ', '_', $section_title)) => $id]) }}">
        <i class="fa fa-eye"></i>
    </a>
</div>

<!-- below button only for stock-order management -->
@if(isset($order_status))
    <div class="btn-group btn-group-sm">
        <a href="{{ url('admin/stock-orders/'.$id.'/receive') }}" title="Recive Documents" data-id="{{$id}}" class="btn btn-sm btn-success tip ">
            Receive
        </a>
    </div>
@endif