<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Menu</h1>
        <!-- <ol class="breadcrumb mt-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol> -->
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Data menu
                <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#modal-menu"><i class="fas fa-fw fa-plus"></i> Add Menu</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Parent ID</th>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Icon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menu as $key => $value) { ?>
                                <tr>
                                    <td class="text-center"><?= $key + 1 ?></td>
                                    <td><?= get_parent_menu($value->parent_id) ?></td>
                                    <td><?= $value->title ?></td>
                                    <td><?= $value->link ?></td>
                                    <td><?= $value->icon ?></td>
                                    <td class="text-right">
                                        <a href="<?= base_url('setting/deleteMenu/') . $value->id ?>" class="btn btn-xs btn-danger" onclick="return confirm_delete()"><i class="fas fa-fw fa-trash"></i></a>
                                        <a href="#" data-id="<?= $value->id ?>" data-toggle="modal" data-target="#modal-menu" class="btn btn-xs btn-success btn-edit"><i class="fas fa-fw fa-pencil-alt"></i></a>
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
        $(".table").DataTable();
        $('.select2').select2();
    });

    function confirm_delete() {
        return confirm('Apakah anda yakin akan mengahapus menu ini ?');
    }

    function clear_form() {
        $('#form-menu')[0].reset();
    }

    $('.btn-edit').click(function() {
        const id = $(this).data('id');
        // $('#form-menu')[0].reset();
        $.ajax({
            url: "<?= base_url() . 'setting/get_menu/'; ?>" + id,
            async: false,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#parent').val(data.parent_id);
                $('#title').val(data.title);
                $('#link').val(data.link);
                $('#icon').val(data.icon);
            }
        });
    });
</script>
<!-- /.content-wrapper -->