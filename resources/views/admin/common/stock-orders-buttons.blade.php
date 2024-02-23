<div class="btn-group">
    <button type="button" class="btn btn-info"><i class="fa fa-cogs" aria-hidden="true"></i></button>
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(68px, -165px, 0px);">
        <a class="dropdown-item" href="{{ url('admin/'.$section_name.'/'.$id.'/edit') }}" title="Edit {{$section_title}}"">Edit</a>
        <a class="dropdown-item deleteRecord" href="javascript:void(0)" data-id="{{$id}}" type="button" data-url="{{ url('admin/'.$section_name.'/'.$id) }}" data-section="{{$section_name}}_table">Delete</a>

        <a class="dropdown-item view-info" href="javascript:void(0)" title="View {{$section_title}}" data-id="{{$id}}" data-url="{{ route($section_name.'.show', [strtolower(str_replace(' ', '_', $section_title)) => $id]) }}">View</a>

        <a class="dropdown-item" href="{{ url('admin/stock-orders/'.$id.'/receive') }}" title="Recive Documents" data-id="{{$id}}">Receive</a>
    </div>
</div>