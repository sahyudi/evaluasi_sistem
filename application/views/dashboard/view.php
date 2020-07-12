<main>
    <div class="container-fluid">

        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <?= $this->session->flashdata('message'); ?>
        <div class="row my-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white text-center">
                    <div class="card-block">
                        <h5 class="card-title mt-1">Employee</h5>
                        <h2><i class="fa fa-users fa-2x"></i></h2>
                    </div>
                    <div class="row px-2 no-gutters">
                        <div class="col-12">
                            <h3><?= $employee ?></h3>
                        </div>
                    </div>
                    <div class="card-footer text-white">
                        <a href="<?= base_url('resource') ?>" class="text-white">Detail >></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white text-center">
                    <div class="card-block">
                        <h5 class="card-title mt-1">Units Of Competency</h5>
                        <h2><i class="fa fa-clipboard-list fa-2x"></i></h2>
                    </div>
                    <div class="row px-2 no-gutters">
                        <div class="col-12">
                            <h3><?= $unit_comp ?></h3>
                        </div>
                    </div>
                    <div class="card-footer text-white">
                        <a href="<?= base_url('competency/unit_competency') ?>" class="text-white">Detail >></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white text-center">
                    <div class="card-block">
                        <h5 class="card-title mt-1">Licenses</h5>
                        <h2><i class="fa fa-id-badge fa-2x"></i></h2>
                    </div>
                    <div class="row px-2 no-gutters">
                        <div class="col-12">
                            <h3><?= $license ?></h3>
                        </div>
                    </div>
                    <div class="card-footer text-white">
                        <a href="#" class="text-white">Detail >></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white text-center">
                    <div class="card-block">
                        <h5 class="card-title mt-1">Will Expired</h5>
                        <h2><i class="fas fa-calendar-minus fa-2x"></i></h2>
                    </div>
                    <div class="row px-2 no-gutters">
                        <div class="col-12">
                            <h3><?= $expire ?></h3>
                        </div>
                    </div>
                    <div class="card-footer text-white">
                        <a href="#" class="text-white">Detail >></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                New Evaluatian
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Uni Competency</th>
                                <th>Date</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
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
<script>
    $(document).ready(function() {
        get_license();
    });

    function handleAjaxError(xhr, textStatus, error) {
        if (textStatus === 'timeout') {
            alert('The server took too long to send the data.');
        } else {
            alert('An error occurred on the server. Please try again in a minute.');
        }
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
            'sAjaxSource': "<?= base_url('competency/getJsonLincense') ?>",
            'fnServerData': function(sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "limit",
                    "value": 10
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
                    "data": "employee"
                },
                {
                    "data": "lincense"
                },
                {
                    "data": "comp_date"
                },
                {
                    "data": "exp_date"
                },
                {
                    "data": "status",
                    "render": function(data, type, obj) {
                        if (obj['status'] == "PASSED") {
                            return `<span class="badge badge-success">${obj['status']}</span>`
                        } else {
                            return `<span class="badge badge-danger">${obj['status']}</span>`
                        }
                    }
                },
                {
                    "data": "id",
                    "render": function(data, type, oObj) {
                        var id = oObj['id'];
                        var btnDelete = `<a href="#" class="btn btn-delete" onclick="delete_data(${id})"><i class="fas fa-fw fa-trash"></i></a>`;
                        var btnPrint = `<a href="<?= base_url('competency/print/') ?>${id}" class="btn btn-print"><i class="fas fa-fw fa-print"></i></a>`;
                        return `<td class="text-center">${btnDelete} ${btnPrint}</right>`;
                    }
                }
            ]
        })
    }
</script>