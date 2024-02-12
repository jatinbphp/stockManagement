$(function () {
    //User Table
    var users_table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'name', name: 'name'},
            {data: 'role',  name: 'role'},
            {data: 'email',  name: 'email'},
            {data: 'phone',  name: 'phone'},
            {data: 'image',  name: 'image', orderable: false, searchable: false, render: function (data,type,row){
                    return '<img src="'+data+'" height="50" alt="Image"/>';
                }
            },
            {data: 'status', "width": "12%",  name: 'status', orderable: false},    
            {data: 'action', "width": "10%",  name: 'action', orderable: false},                
        ]
    });

    //Brand Table
    var brand_table = $('#brandTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'name', "width": "15%", name: 'name'},
            {data: 'supplier.name', "width": "15%", name: 'supplier.name'},
            {data: 'image', "width": "15%", name: 'image', orderable: false, searchable: false, render: function (data,type,row){
                    return '<img src="'+data+'" height="50" alt="Image"/>';
                }
            },
            {data: 'status', "width": "12%",  name: 'status', orderable: false},
            {data: 'action', "width": "10%",  name: 'action', orderable: false},
        ]
    });

    //supplier Table
    var supplier_table = $('#supplierTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500, ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'telephone', name: 'telephone'},
            {data: 'account_number', name: 'account_number'},
            {data: 'status', "width": "12%",  name: 'status', orderable: false},
            {data: 'action', "width": "10%",  name: 'action', orderable: false},
        ]
    });

    //practice Table
    var practice_table = $('#practiceTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500, ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'name', name: 'name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'status', "width": "12%", name: 'status', orderable: false},
            {data: 'action', "width": "10%", name: 'action', orderable: false},
        ]
    });

    //Stock Order Table
    var stock_order_table = $('#stockOrderTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500, ],
        ajax: $("#route_name").val(),
        columns: [
            {data: 'supplier.name', name: 'supplier'},
            {data: 'brand.name', name: 'brand'},
            {data: 'practice.name', name: 'practice'},
            {data: 'instructions', name: 'instructions'},
            {data: 'status', "width": "12%", name: 'status', orderable: false},
            {data: 'action', "width": "10%", name: 'action', orderable: false},
        ]
    });

    //Delete Record
    $('.datatable-dynamic tbody').on('click', '.deleteRecord', function (event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        var url = $(this).attr("data-url");
        var section = $(this).attr("data-section");

        swal({
            title: "Are you sure?",
            text: "You want to delete this record?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    success: function(data){
                        if(section=='users_table'){
                            users_table.row('.selected').remove().draw(false);    
                        } else if (section == 'brand_table'){
                            brand_table.row('.selected').remove().draw(false);
                        } else if (section == 'supplier_table'){
                            supplier_table.row('.selected').remove().draw(false);
                        } else if (section == 'practice_table'){
                            practice_table.row('.selected').remove().draw(false);
                        } else if (section == 'stock-order_table'){
                            stock_order_table.row('.selected').remove().draw(false);
                        }
                 
                        swal("Deleted", "Your data successfully deleted!", "success");
                    }
                });
            } else {
                swal("Cancelled", "Your data safe!", "error");
            }
        });
    });

    //Change Status
    $('.datatable-dynamic tbody').on('click', '.assign_unassign', function (event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");
        var type = $(this).attr("data-type");
        var table_name = $(this).attr("data-table_name");
        var section = $(this).attr("data-table_name");

        var l = Ladda.create(this);
        l.start();
        $.ajax({
            url: url,
            type: "post",
            data: {
                'id': id,
                'type': type,
                'table_name': table_name,
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data){
                l.stop();

                if(type=='unassign'){
                    $('#assign_remove_'+id).hide();
                    $('#assign_add_'+id).show();
                } else {
                    $('#assign_remove_'+id).show();
                    $('#assign_add_'+id).hide();
                }

                if(section=='users_table'){
                    users_table.draw(false);
                } else if (section == 'brand_table'){
                    brand_table.draw(false);
                } else if (section == 'supplier_table'){
                    supplier_table.draw(false);
                } else if (section == 'practice_table'){
                    practice_table.draw(false);
                }
            }
        });
    });
});

