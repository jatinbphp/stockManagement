@if($section_name!='contactus' && $section_name!='orders')
<div class="btn-group btn-group-sm">
    <a href="{{ url('admin/'.$section_name.'/'.$id.'/edit') }}" title="Edit {{$section_title}}" class="btn btn-sm btn-info tip mr-1">
        <i class="fa fa-edit"></i>
    </a>
</div>
@endif
@if($section_name!='content')
<span data-toggle="tooltip" title="Delete {{$section_title}}" data-trigger="hover">
    <button class="btn btn-sm btn-danger deleteRecord" data-id="{{$id}}" type="button" data-url="{{ url('admin/'.$section_name.'/'.$id) }}" data-section="{{$section_name}}_table">
        <i class="fa fa-trash"></i>
    </button>
</span>
@endif