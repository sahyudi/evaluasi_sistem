<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Group</h1>
        <!-- <ol class="breadcrumb mt-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol> -->
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Data Group
                <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#modal-group"><i class="fas fa-fw fa-plus"></i> Add Group</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th width="30px">No</th>
                                <th>Group</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modal-group">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('setting/add_group') ?>" id="form-group" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Group</label>
                        <input type="text" class="form-control form-control-sm" name="group" id="group" placeholder="Group Name">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function() {
        // $(".table").DataTable();
        get_group();
    });

    function handleAjaxError(xhr, textStatus, error) {
        if (textStatus === 'timeout') {
            alert('The server took too long to send the data.');
        } else {
            alert('An error occurred on the server. Please try again in a minute.');
        }
    }


    function get_group() {
        if (oTable) {
            oTable.fnDestroy();
        }
        $('#dataTable').dataTable().fnDestroy();
        var oTable = $('#dataTable').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            'searching': true,
            'sAjaxSource': "<?= base_url('setting/getGroupJson') ?>",
            'fnServerData': function(sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "status",
                    "value": "1"
                });
                $.ajax({
                    'dataType': 'json',
                    'type': 'POST',
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback,
                    "error": handleAjaxError
                });

            },
            'fnDrawCallback': function(oSettings) {
                $('#modal-loading').modal('hide');
            },
            "columns": [{
                    "data": null,
                    "className": "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "group_name"
                },
                {
                    "data": "id",
                    "className": "text-center",
                    "render": function(data, type, oObj) {
                        var id = oObj['id'];
                        var btnDelete = `<a href="#" class="btn btn-xs btn-danger" title="Delete Group" onclick="delete_data('${id}')"><i class="fas fa-fw fa-trash"></i></a>`;
                        var btnEdit = `<a href="#" onclick="edit_data(${id})" data-toggle="modal" data-target="#modal-group" title="Edit Group" class="btn btn-xs btn-success btn-edit"><i class="fas fa-fw fa-pencil-alt"></i></a>`;
                        var btnPrivelega = `<a href="<?= base_url('setting/privelage/') ?>${id}" class="btn btn-xs btn-info" title="Hak Akses Group"><i class="fas fa-fw fa-user-shield"></i></a>`;
                        return `<td class="text-center">${btnDelete} ${btnEdit} ${btnPrivelega}</right>`;
                    }
                }
            ]
        })
    }

    function delete_data(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                execute_delete(id)
            }
        })
    }

    function execute_delete(id) {
        $.ajax({
            url: "<?= base_url() . 'setting/deleteGroup'; ?>",
            async: false,
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your unit competency has been deleted',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Your unit comptency has failed to deleted',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                get_group();
            }
        });
    }

    function clear_form() {
        $('#form-group')[0].reset();
    }

    // $('.btn-edit').click(function() {
    function edit_data(id) {
        $.ajax({
            url: "<?= base_url() . 'setting/get_group/'; ?>" + id,
            async: false,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                $('#id').val(data.id);
                $('#group').val(data.group_name);
            }
        });
    }
    // });
</script>
<!-- /.content-wrapper -->