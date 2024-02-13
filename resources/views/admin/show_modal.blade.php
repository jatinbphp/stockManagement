<!-- Modal content -->
<div class="modal-header">
    <h5 class="modal-title" id="commonModalLabel">{{$type}} Details</h5>
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
                                    @if(!empty($section_info))
                                        @foreach ($section_info as $key => $info)

                                            @if(in_array($key, $required_columns))
                                                <tr>
                                                    <th style="width: 25%;">
                                                        {{ ucwords(str_replace('_', ' ', $key)) }} :
                                                    </th>
                                                    <td>
                                                        @if($key=='image')
                                                            @if (!empty($info) && file_exists($info))
                                                                <img src="{{url($info)}}" height="50">
                                                            @else
                                                                <img src="{{url('uploads/users/user-default-image.png')}}" height="50">
                                                            @endif
                                                        @elseif($key=='created_at')
                                                            {{date('Y-m-d H:i:s', strtotime($info))}}
                                                        @else
                                                            {{$info}}
                                                        @endif
                                                    </td>
                                                </tr>          
                                            @endif                                  
                                        @endforeach
                                    @endif
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