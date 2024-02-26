<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" for="supplier_id">Supplier :<span class="text-red d-none">*</span></label>
            {!! Form::select("supplier_id", ['' => 'Please Select'] + ($supplier->toArray() ?? []), null, ["class" => "form-control select2", "id" => "supplier_id"]) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" for="brand_id">Brand :<span class="text-red d-none">*</span></label>
            {!! Form::select("brand_id", ['' => 'Please Select'], null, ["class" => "form-control select2", "id" => "brand_id"]) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" for="practice_id">Practice :<span class="text-red d-none">*</span></label>
            {!! Form::select("practice_id", ['' => 'Please Select'] + ($practice->toArray() ?? []), null, ["class" => "form-control select2", "id" => "practice_id"]) !!}        
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" for="status">Status :<span class="text-red d-none">*</span></label>
            {!! Form::select("status", ['' => 'Please Select'] + ($status ?? []), null, ["class" => "form-control select2", "id" => "status"]) !!}  
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" for="daterange">Date Created :<span class="text-red d-none">*</span></label>
            <input class="form-control" type="text" name="daterange" placeholder="Please select" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" for="datetype">Date Type :</label>
            <select class="form-control select2" id="datetype" name="datetype">
                <option value="date-created">Date Created</option>
                <option value="date-received">Date Received</option>
            </select>
        </div>
    </div>
    <div class="col-md-1" style="margin-top: 30px;">
        <button type="button" id="clear-filter" class="btn btn-danger" data-type="{{$type}}"><i class="fa fa-times" aria-hidden="true"></i></button>
        <button type="button" id="apply-filter" class="btn btn-info" data-type="{{$type}}"><i class="fa fa-filter" aria-hidden="true"></i></button>
    </div>
</div>