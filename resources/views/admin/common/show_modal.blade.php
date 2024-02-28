<!-- Modal content -->
<div class="modal-header">
    <h5 class="modal-title" id="commonModalLabel">{{ ucwords(str_replace('_', ' ', $type)) }} Details</h5>
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
                                    @foreach ($required_columns as $key)
                                        @if (array_key_exists($key, $section_info))
                                            <tr>
                                                <th style="width: 25%;">
                                                    {!! $key != 'created_at' ? ucwords(str_replace('_', ' ', $key)) : 'Date Created' !!} :
                                                </th>
                                                <td>
                                                    @switch($key)
                                                        @case('image')
                                                            {!! renderImageColumn($section_info[$key]) !!}
                                                            @break
                                                        @case('created_at')
                                                            {!! formatDate($section_info[$key]) !!}
                                                            @break
                                                        @case('id')
                                                            {!! renderIdColumn($section_info[$key]) !!}
                                                            @break
                                                        @case('status')
                                                            {!! renderStatusColumn($section_info[$key]) !!}
                                                            @break
                                                        @case('role')
                                                            {{ ucwords(str_replace('_', ' ', $section_info[$key])) }}
                                                            @break
                                                        @case('access_rights')
                                                            @if(!empty($section_info[$key]))
                                                                @php
                                                                    $access_rights = json_decode($section_info[$key]);
                                                                @endphp
                                                                @foreach($access_rights as $accessRight)
                                                                    <span class="badge badge-success">{{ ucfirst($accessRight) }}</span>
                                                                @endforeach
                                                            @endif
                                                            @break
                                                        @case('supplier')
                                                            @if(is_array($section_info[$key]))
                                                                {{ $section_info[$key]['name'] }} <br>
                                                                {{ $section_info[$key]['email'] }}
                                                            @else
                                                                {{ $section_info[$key]->name }} <br>
                                                                {{ $section_info[$key]->email }}
                                                            @endif
                                                            @break
                                                        @default
                                                            {!! $section_info[$key] !!}
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
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
    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times pr-1"></i></i> Close</button>
</div>

@php
function renderImageColumn($info) {
    if (!empty($info) && file_exists($info)) {
        return '<img src="' . url($info) . '" height="50">';
    } else {
        return '<img src="' . url('assets/admin/dist/img/no-image.png') . '" height="50">';
    }
}

function formatDate($info) {
    return date('Y-m-d H:i:s', strtotime($info));
}

function renderIdColumn($info) {
    return '#' . $info;
}

function renderStatusColumn($info) {
    $class = $info == 'active' ? 'success' : 'danger';
    return '<span class="badge badge-' . $class . '">' . ucfirst($info) . '</span>';
}
@endphp
