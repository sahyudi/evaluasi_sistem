<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Unit Competency Detail</h1>
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Data Unit Competency Detail
                <a href="#" onclick="reset_form()" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#modal-unit-comptency-detail"><i class="fas fa-fw fa-plus"></i> Add Unit Competency</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Unit Competency</label>
                        <div class="form-control">
                            <?= $competency->name ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Minimal Score</label>
                        <div class="form-control">
                            <?= $competency->min_score ?>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="criteria-table">
                        <thead>
                            <tr>
                                <th>Criteria</th>
                                <th>Value / Bobot (%)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right">Max Value / Bobot</th>
                                <th id="total-bobot"></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modal-unit-comptency-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Unit Competency Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-unit-comptency-detail" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Criteria</label>
                        <input type="text" name="criteria" id="criteria" class="form-control form-control-sm" placeholder="Criteria">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Value / Bobot (%)</label>
                        <input type="number" name="value_weight" id="value_weight" class="form-control form-control-sm" placeholder="Value bobot">
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
    var Id = "<?= $competency->id ?>";
    $(document).ready(function() {
        get_detail_competency();
    });

    function reset_form() {
        $('#form-unit-comptency-detail')[0].reset();
        $('#id').val('')
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

    function edit_data(id) {
        $.ajax({
            url: "<?= base_url() . 'competency/editUnitCompDetail'; ?>",
            async: false,
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                $('#id').val(data.id);
                $('#criteria').val(data.name);
                $('#value_weight').val(data.value_weight);
            }
        });
    }

    function execute_delete(id) {
        $.ajax({
            url: "<?= base_url() . 'competency/deleteUnitCompDetail'; ?>",
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
                get_detail_competency();
            }
        });
    }

    function save_data() {
        $.ajax({
            url: "<?= base_url() . 'competency/saveUnitDetailCompetency/'; ?>" + Id,
            async: false,
            type: 'POST',
            data: $('#form-unit-comptency-detail').serialize(),
            dataType: 'json',
            success: function(data) {
                $('#modal-unit-comptency-detail').modal('hide');
                reset_form();
                if (data.status == 1) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your unit competency detail has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Your unit comptency detail has failed to saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                get_detail_competency();
            }
        });
    }

    function get_detail_competency() {

        var unitData = [];
        var totalBobot = 0;

        $.ajax({
            url: "<?= base_url() . 'competency/get_detail_competency'; ?>",
            async: false,
            type: 'POST',
            data: {
                id: Id
            },
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                $('tbody tr').remove()
                $.each(data, function(index, unit) {
                    unitData += `
                        <tr>
                            <td>${unit.name}</td>
                            <td>${unit.value_weight}</td>
                            <td class="text-right">
                                <a href="#"  data-toggle="modal" data-target="#modal-unit-comptency-detail" class="btn btn-sm btn-primary" onclick="edit_data('${unit.id}')"><i class="fas fa fa-pencil-alt"></i></a>
                                <a href="#" class="btn btn-sm btn-danger" onclick="delete_data('${unit.id}')"><i class="fas fa fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    `;

                    totalBobot += parseInt(unit.value_weight);
                });
                $('#total-bobot').html(totalBobot + ' %');
                $('#criteria-table tbody').append(unitData);
            }
        });
    }
</script>