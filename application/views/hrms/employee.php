<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Employee</h1>
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Data Employee
                <a href="#" onclick="reset_form()" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#modal-employee"><i class="fas fa-fw fa-plus"></i> Add Employee</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>NIP</th>
                                <th>Full Name</th>
                                <th>Departement</th>
                                <th>telehgram ID</th>
                                <th>Image</th>
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

<div class="modal fade" id="modal-employee">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Employee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-employee" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">NIP</label>
                        <input type="text" name="nip" id="nip" class="form-control form-control-sm" placeholder="NIP ..">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control form-control-sm" placeholder="Full name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Departement</label>
                        <select name="depart_id" id="depart_id" class="form-control form-control-sm select2">
                            <option value=""></option>
                            <?php foreach ($depart as $key => $value) { ?>
                                <option value="<?= $value->id ?>"><?= $value->full_name ?></option>
                            <?php } ?>
                        </select>
                        <!-- <input type="text" name="depart_id" id="depart_id" class="form-control form-control-sm" placeholder="Departement"> -->
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Telegram ID</label>
                        <input type="text" name="telegram_id" id="telegram_id" class="form-control form-control-sm" placeholder="Telegram ..">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Profile</label>
                        <input type="file" name="profile" id="profile" class="form-control form-control" placeholder="Telegram ..">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" onclick="save_data()" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function() {
        getEmployee();
        $('.select2').select2();
    });

    function handleAjaxError(xhr, textStatus, error) {
        if (textStatus === 'timeout') {
            alert('The server took too long to send the data.');
        } else {
            alert('An error occurred on the server. Please try again in a minute.');
        }
    }

    function save_data() {
        var formdata = new FormData($('#form-employee')[0]);
        // console.log($('#form-employee')[0]);;
        // var profile = $('#profile')[0].file[0];
        var file = $('#profile').prop('files')[0];
        formdata.append('profile', file);
        $.ajax({
            url: "<?= base_url() . 'resource/saveEmployee'; ?>",
            async: false,
            type: 'POST',
            data: formdata,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#modal-employee').modal('hide');
                console.log(data.status);
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
                getEmployee();
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
            url: "<?= base_url() . 'resource/deleteEmployee'; ?>",
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
                getEmployee();
            }
        });
    }

    function edit_unit(id) {
        $.ajax({
            url: "<?= base_url() . 'resource/editEmployee'; ?>",
            async: false,
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                $('#id').val(data.id);
                $('#full_name').val(data.full_name);
                $('#depart_id').select2('val', data.depart_id);
                $('#telegram_id').val(data.telegram_id);
                $('#nip').val(data.nip);
                // $('#profile').val(data.profile);
            }
        });
    }

    function reset_form() {
        $('#form-employee')[0].reset();
        $('.select2').select2('val', 's');
    }


    function getEmployee() {
        if (oTable) {
            oTable.fnDestroy();
        }
        $('#dataTable').dataTable().fnDestroy();
        var oTable = $('#dataTable').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            'searching': true,
            'sAjaxSource': "<?= base_url('resource/getJsonEmployee') ?>",
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
                    "data": "nip"
                },
                {
                    "data": "full_name"
                },
                {
                    "data": "depart_name",
                },
                {
                    "data": "telegram_id",
                },
                {
                    "data": "profile",
                    "render": function(data, type, index) {
                        if (index['profile']) {
                            return `<img src="<?= base_url('assets/img/') ?>${index['profile']}" width="120px">`
                        } else {
                            return `N/A`;
                        }
                    }
                },
                {
                    "data": "id",
                    "className": "text-center",
                    "render": function(data, type, oObj) {
                        var id = oObj['id'];
                        var btnDelete = `<button onclick="delete_unit(${id})" title="Detele" class="btn btn-delete"><i class="fas fa-fw fa-trash"></i></button>`;
                        var btnEdit = `<a href="#" data-toggle="modal" title="Edit" data-target="#modal-employee" onclick="edit_unit(${id})" class="btn btn-print"><i class="fas fa-fw fa-pencil-alt"></i></a>`;

                        return `<td class="text-center">${btnDelete} ${btnEdit}</right>`;
                    }
                }
            ]
        })
    }
</script>