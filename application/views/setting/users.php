<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Users</h1>
        <!-- <ol class="breadcrumb mt-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol> -->
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Data Users
                <a href="<?= base_url('setting/create_user') ?>" class="btn btn-primary float-right btn-sm"><i class="fas fa-fw fa-plus"></i> Add Users</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Group Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $key => $value) { ?>
                                <tr>
                                    <td class="text-center"><?= $key + 1 ?></td>
                                    <td><?= $value->name ?></td>
                                    <td><?= $value->email ?></td>
                                    <td><?= $value->group_name ?></td>
                                    <td class="text-center"><?= ($value->is_active == 1) ? '<label class="badge badge-success">Aktif</label>' : '<label class="badge badge-danger">Non aktif</label>' ?></td>
                                    <td class="text-right">
                                        <a href="<?= base_url('setting/delete_user/') . $value->id ?>" onclick="return delete_confirm()" class="btn btn-xs btn-danger"><i class="fas fa-fw fa-trash"></i></a>
                                        <a href="#" data-id="<?= $value->id ?>" data-toggle="modal" data-target="#modal-users" class="btn btn-xs btn-success btn-edit"><i class="fas fa-fw fa-pencil-alt"></i></a>
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


<script>
    $(document).ready(function() {
        $(".table").DataTable();
    });


    function delete_confirm() {
        return confirm('Apakah anda yakin akan menghapus users ?');
    }
    $('.btn-edit').click(function() {
        const id = $(this).data('id');
        // alert(id);
        $.ajax({
            url: "<?= base_url() . 'vendor/get_data/'; ?>" + id,
            async: false,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#nama').val(data.nama);
                $('#no_telp').val(data.no_telp);
                $('#alamat').val(data.alamat);
                if (data.is_active == 1) {
                    $('#is_active').attr('checked', 'checked');
                } else {
                    $('#is_active').removeAttr('checked');
                }
            }
        });
    });
</script>
<!-- /.content-wrapper -->