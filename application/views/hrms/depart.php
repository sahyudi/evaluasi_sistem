<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Departement</h1>
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Data Departement
                <a href="#" onclick="reset_form()" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#modal-departement"><i class="fas fa-fw fa-plus"></i> Add Departement</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Short Name</th>
                                <th>Actions</th>
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

<div class="modal fade" id="modal-departement">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Departement</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-departement" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control form-control-sm" placeholder="Full name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Short Name</label>
                        <input type="text" name="short_name" id="short_name" class="form-control form-control-sm" placeholder="Short Name">
                    </div>
                </div>
            </form>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" onclick="save_data()" class="btn btn-primary btn-sm">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function() {
        getDepartment();
    });

    function handleAjaxError(xhr, textStatus, error) {
        if (textStatus === 'timeout') {
            alert('The server took too long to send the data.');
        } else {
            alert('An error occurred on the server. Please try again in a minute.');
        }
    }

    function save_data() {
        $.ajax({
            url: "<?= base_url() . 'resource/saveDepartement'; ?>",
            async: false,
            type: 'POST',
            data: $('#form-departement').serialize(),
            dataType: 'json',
            success: function(data) {
                $('#modal-departement').modal('hide');
                reset_form();
                if (data.status == 1) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your unit competency has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Your unit comptency has failed to saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                getDepartment();
            }
        });
    }

    function delete_unit(id) {
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
            url: "<?= base_url() . 'resource/deleteDepartement'; ?>",
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
                getDepartment();
            }
        });
    }

    function edit_unit(id) {
        $.ajax({
            url: "<?= base_url() . 'resource/editDepartement'; ?>",
            async: false,
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                $('#id').val(data.id);
                $('#full_name').val(data.full_name);
                $('#short_name').val(data.short_name);
            }
        });
    }

    function reset_form() {
        $('#form-departement')[0].reset();
    }


    function getDepartment() {
        if (oTable) {
            oTable.fnDestroy();
        }
        $('#dataTable').dataTable().fnDestroy();
        var oTable = $('#dataTable').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            'searching': true,
            'sAjaxSource': "<?= base_url('resource/getJsonDepartment') ?>",
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
                    "data": "full_name"
                },
                {
                    "data": "short_name",
                },
                {
                    "data": "id",
                    "className": "text-center",
                    "render": function(data, type, oObj) {
                        var id = oObj['id'];
                        var btnDelete = `<button onclick="delete_unit(${id})" title="Detele" class="btn btn-delete"><i class="fas fa-fw fa-trash"></i></button>`;
                        var btnEdit = `<a href="#" data-toggle="modal" title="Edit" data-target="#modal-departement" onclick="edit_unit(${id})" class="btn btn-print"><i class="fas fa-fw fa-pencil-alt"></i></a>`;

                        return `<td class="text-center">${btnDelete} ${btnEdit}</right>`;
                    }
                }
            ]
        })
    }
</script>