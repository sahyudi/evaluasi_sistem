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
                <a href="<?= base_url('competency/send_notif_telegram') ?>" class="btn btn-sm btn-info float-right"><i class="fab fa-telegram"></i> Send Notif</a>
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
                        var btnCertif = `<a href="" class="btn btn-certif"><i class="fas fa-fw fa-file"></i></a>`;
                        return `<td class="text-center">${btnDelete} ${btnPrint} ${btnCertif}</right>`;
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
            url: "<?= base_url() . 'competency/deleteLicense'; ?>",
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
</script>
<!-- /.content-wrapper -->