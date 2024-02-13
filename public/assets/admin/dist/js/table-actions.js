$(function () {

    //Role Table
    var roles_table = $('#roleTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500, ],
        ajax: $("#route_name").val(),
        columns: [
            {
                data: 'id', width: '10%', name: 'id',
                render: function(data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },
            {data: 'name', name: 'name'},
            {data: 'status', "width": "12%", name: 'status', orderable: false},
            {data: 'action', "width": "5%", orderable: false},
        ],
        "order": []
    });

    //User Table
    var users_table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {
                data: 'id', width: '10%', name: 'id',
                render: function(data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },
            {data: 'name', name: 'name'},
            {data: 'email',  name: 'email'},
            {data: 'role',  name: 'role'},
            /*{data: 'image', "width": "10%",  name: 'image', orderable: false, searchable: false, render: function (data,type,row){
                    return '<img src="'+data+'" height="50" alt="Image"/>';
                }
            },*/
            {data: 'status', "width": "12%",  name: 'status', orderable: false},  
            {data: 'created_at', "width": "18%", name: 'created_at'},  
            {data: 'action', "width": "10%", orderable: false},                
        ],
        "order": [[0, "DESC"]]
    });

    //Supplier Table
    var suppliers_table = $('#supplierTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500, ],
        ajax: $("#route_name").val(),
        columns: [
            {
                data: 'id', width: '10%', name: 'id',
                render: function(data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'status', "width": "12%",  name: 'status', orderable: false},
            {data: 'created_at', "width": "18%", name: 'created_at'},
            {data: 'action', "width": "10%", orderable: false},
        ],
        "order": [[0, "DESC"]]
    });

    //Brand Table
    var brands_table = $('#brandTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {
                data: 'id', width: '10%', name: 'id',
                render: function(data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },
            {data: 'name', name: 'name'},
            {data: 'supplier.full_name', name: 'supplier.full_name',
                render: data => {
                    const [name, email] = data.split(' (');
                    return `${name}<br>${email.slice(0, -1)}`;
                }
            },
            /*{data: 'image', "width": "10%", name: 'image', orderable: false, searchable: false, render: function (data,type,row){
                    return '<img src="'+data+'" height="50" alt="Image"/>';
                }
            },*/
            {data: 'status', "width": "12%",  name: 'status', orderable: false},
            {data: 'created_at', "width": "18%", name: 'created_at'},
            {data: 'action', "width": "10%", orderable: false},
        ],
        "order": [[0, "DESC"]]
    });

    //Practice Table
    var practices_table = $('#practiceTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500, ],
        ajax: $("#route_name").val(),
        columns: [
            {
                data: 'id', width: '10%', name: 'id',
                render: function(data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            /*{data: 'telephone', name: 'telephone'},
            {data: 'manager_name', name: 'manager_name'},*/
            {data: 'status', "width": "12%", name: 'status', orderable: false},
            {data: 'created_at', "width": "18%", name: 'created_at'},
            {data: 'action', "width": "10%", orderable: false},
        ],
        "order": [[0, "DESC"]]
    });

    //Stock Order Table
    var stock_orders_table = $('#stockOrderTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500, ],
        ajax: $("#route_name").val(),
        columns: [
            {
                data: 'id', width: '10%', name: 'id',
                render: function(data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },            
            {data: 'supplier.full_name', name: 'supplier.full_name',
                render: data => {
                    const [name, email] = data.split(' (');
                    return `${name}<br>${email.slice(0, -1)}`;
                }
            },
            {data: 'brand.name', name: 'brand'},
            {data: 'practice.full_name', name: 'practice.full_name',
                render: data => {
                    const [name, email] = data.split(' (');
                    return `${name}<br>${email.slice(0, -1)}`;
                }
            },
            {data: 'status', "width": "20%", name: 'status', orderable: false},
            {data: 'created_at', "width": "20%", name: 'created_at'},
            {data: 'action', "width": "12%", orderable: false},
        ],
        "order": [[0, "DESC"]]
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
                        } else if (section == 'brands_table'){
                            brands_table.row('.selected').remove().draw(false);
                        } else if (section == 'suppliers_table'){
                            suppliers_table.row('.selected').remove().draw(false);
                        } else if (section == 'practices_table'){
                            practices_table.row('.selected').remove().draw(false);
                        } else if (section == 'stock-orders_table'){
                            stock_orders_table.row('.selected').remove().draw(false);
                        } else if (section == 'roles_table'){
                            roles_table.row('.selected').remove().draw(false);
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
                } else if (section == 'brands_table'){
                    brands_table.draw(false);
                } else if (section == 'suppliers_table'){
                    suppliers_table.draw(false);
                } else if (section == 'practices_table'){
                    practices_table.draw(false);
                }
            }
        });
    });

    //change order status
    $('#stockOrderTable tbody').on('change', '.stockOrderStatus', function (event) {
        event.preventDefault();
        var orderId = $(this).attr('data-id');
        var status = $(this).val();
        swal({
            title: "Are you sure?",
            text: "To update status of this stock order",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            confirmButtonText: 'Yes, Sure',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {

                $.ajax({
                    url: $("#order_update").val(),
                    type: "post",
                    data: {'id': orderId, 'status': status, '_token': $('meta[name=_token]').attr('content') },
                    success: function(data){
                        
                        swal({
                            title: "Enter your notes!",
                            text: "<textarea class='form-control' id='notes_text'></textarea>",
                            html: true,
                            showCancelButton: true,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                            animation: "slide-from-top",
                            inputPlaceholder: "Write something"
                        }, function(inputValue) {

                            // get value using textarea id
                            var notes_text = document.getElementById('notes_text').value;

                            $.ajax({
                                url: $("#add_history").val(),
                                type: "post",
                                data: {'stock_order_id': orderId, 'status': status, 'notes_text': notes_text, '_token': $('meta[name=_token]').attr('content') },
                                success: function(data){
                                    swal("Success", "Order status is updated", "success");
                                }
                            });
                        });
                    }
                });
            } else {
                swal("Cancelled", "Your data is safe!", "error");
            }
        });
    });

    $('.datatable-dynamic tbody').on('click', '.get-status-history', function (event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");

        $.ajax({
            method: "GET",
            url: url,
            dataType: "json",
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(response) {
                if (response.status) {
                    var html = "";
                    $.each(response.data, function(k, v) {

                        var formattedCreatedAt = moment(v.created_at).format('YYYY-MM-DD HH:mm:ss');
                        var status = v.status.charAt(0).toUpperCase() + v.status.slice(1);

                        html += `<tr>
                                    <td>#${v.id} </td>
                                    <td> ${status} </td>
                                    <td> ${(v.notes_text != null) ? v.notes_text : ' - ' } </td>
                                    <td> ${v.user.name} </td>
                                    <td> ${formattedCreatedAt} </td>
                                </tr>`;
                    });
                    $("#status-histories-list").find(".status-histories-list-view").html(html);
                    $("#status-histories-list").modal("show");
                }
            }
        });
    });
});

