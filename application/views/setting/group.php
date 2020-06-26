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
                                <th>No</th>
                                <th>Group</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($groups as $key => $value) { ?>
                                <tr>
                                    <td class="text-center"><?= $key + 1 ?></td>
                                    <td><?= $value->group_name ?></td>
                                    <td class="text-right">
                                        <a href="<?= base_url('setting/privelage/') . $value->id ?>" class="btn btn-xs btn-info" title="Hak Akses Group"><i class="fas fa-fw fa-user-shield"></i></a>
                                        <a href="<?= base_url('setting/deleteGroup/') . $value->id ?>" class="btn btn-xs btn-danger" title="Delete Group" onclick="return confirm_delete()"><i class="fas fa-fw fa-trash"></i></a>
                                        <a href="#" data-id="<?= $value->id ?>" data-toggle="modal" data-target="#modal-group" title="Edit Group" class="btn btn-xs btn-success btn-edit"><i class="fas fa-fw fa-pencil-alt"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
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
        $(".table").DataTable();
    });

    function confirm_delete() {
        return confirm('Apakah anda yakin akan mengahapus menu ini ?');
    }

    function clear_form() {
        $('#form-group')[0].reset();
    }

    $('.btn-edit').click(function() {
        const id = $(this).data('id');
        // $('#form-group')[0].reset();
        $.ajax({
            url: "<?= base_url() . 'setting/get_group/'; ?>" + id,
            async: false,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#group').val(data.group_name);
            }
        });
    });
</script>
<!-- /.content-wrapper -->