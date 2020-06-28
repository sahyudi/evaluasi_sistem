<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Unit Competency</h1>
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Data Unit Competency
                <a href="#" onclick="reset_form()" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#modal-unit-comptency"><i class="fas fa-fw fa-plus"></i> Add Unit Competency</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Min Score</th>
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

<div class="modal fade" id="modal-unit-comptency">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Unit Competency</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-unit-comptency" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Name unit competency">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Minimal Score</label>
                        <input type="text" name="min_score" id="min_score" class="form-control form-control-sm" placeholder="Minimal score">
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
        // $(".table").DataTable();
        get_license();
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

        $.ajax({
            url: "<?= base_url() . 'competency/saveUnitCompetency'; ?>",
            async: false,
            type: 'POST',
            data: $('#form-unit-comptency').serialize(),
            dataType: 'json',
            success: function(data) {
                $('#modal-unit-comptency').modal('hide');
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
                get_license();
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
            url: "<?= base_url() . 'competency/deleteUnitCompetency'; ?>",
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
                get_license();
            }
        });
    }

    function edit_unit(id) {
        $.ajax({
            url: "<?= base_url() . 'competency/editUnitCompetency'; ?>",
            async: false,
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#min_score').val(data.min_score);
            }
        });
    }

    function reset_form() {
        $('#form-unit-comptency')[0].reset();
    }


    function get_license() {
        if (oTable) {
            oTable.fnDestroy();
        }
        $('#dataTable').dataTable().fnDestroy();
        var oTable = $('#dataTable').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            'searching': true,
            'sAjaxSource': "<?= base_url('competency/getJsonUnitComp') ?>",
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
                    "data": "name"
                },
                {
                    "data": "min_score",
                    "className": "text-center"
                },
                {
                    "data": "id",
                    "className": "text-center",
                    "render": function(data, type, oObj) {
                        var id = oObj['id'];
                        var btnDelete = `<button onclick="delete_unit(${id})" class="btn btn-delete"><i class="fas fa-fw fa-trash"></i></button>`;
                        var btnEdit = `<a href="#" data-toggle="modal" data-target="#modal-unit-comptency" onclick="edit_unit(${id})" class="btn btn-print"><i class="fas fa-fw fa-pencil-alt"></i></a>`;
                        var btnCertif = `<a href="#" class="btn btn-certif"><i class="fas fa-fw fa-file"></i></a>`;
                        return `<td class="text-center">${btnDelete} ${btnEdit} ${btnCertif}</right>`;
                    }
                }
            ]
        })
    }
</script>
<!-- /.content-wrapper -->