<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">License</h1>
        <!-- <ol class="breadcrumb mt-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol> -->
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Data License
                <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#modal-menu"><i class="fas fa-fw fa-plus"></i> Add Menu</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <!-- <th>No</th> -->
                                <th>Nama</th>
                                <th>Uni Competency</th>
                                <th>Assesor</th>
                                <th>Acknoledge</th>
                                <th>Date</th>
                                <th>Expiry Date</th>
                                <th>Score</th>
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

<div class="modal fade" id="modal-menu">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('setting/add_menu') ?>" id="form-menu" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Parent Menu</label>
                        <select name="parent" id="parent" class="form-control form-control-sm select2">
                            <option value="0" selected>Parent ID</option>
                            <?php foreach ($parent as $key => $value) { ?>
                                <option value="<?= $value->id ?>"><?= $value->title ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" name="title" id="title" class="form-control form-control-sm" placeholder="title menu">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Url Menu</label>
                        <input type="text" name="link" id="link" class="form-control form-control-sm" placeholder="Url ..">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Icon Menu</label>
                        <input name="icon" id="icon" class="form-control form-control-sm" placeholder="Icon Menu ...">
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
                    "data": "employee"
                },
                {
                    "data": "lincense"
                },
                {
                    "className": "text-center",
                    "data": "assesor"
                },
                {
                    "data": "ack_by"
                },
                {
                    "data": "comp_date"
                },
                {
                    "data": "expiry_date"
                },
                {
                    "data": "score"
                },
                {
                    "data": "id",
                    "render": function(data, type, oObj) {
                        var status = oObj['id'];
                        var btnDelete = `<a href="" class="btn btn-delete"><i class="fas fa-fw fa-trash"></i></a>`;
                        var btnPrint = `<a href="" class="btn btn-print"><i class="fas fa-fw fa-print"></i></a>`;
                        var btnCertif = `<a href="" class="btn btn-certif"><i class="fas fa-fw fa-file"></i></a>`;
                        return `<td class="text-center">${btnDelete} ${btnPrint} ${btnCertif}</right>`;
                    }
                }
            ]
        })
    }
</script>
<!-- /.content-wrapper -->