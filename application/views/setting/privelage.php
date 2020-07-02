<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Role Access</h1>
        <!-- <ol class="breadcrumb mt-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol> -->
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Form Role Access
            </div>
            <form method="POST" action="<?= base_url('setting/update_privelage') ?>">
                <input type="hidden" name="group_id" id="group_id" value="<?= $group_id ?>">
                <div class="card-body">
                    <table class="table table-striped table-bordered tree">
                        <!-- Loop menu -->
                        <tr>
                            <th>Menu</th>
                            <th colspan="3">Actions</th>
                        </tr>
                        <?php foreach ($menu as $key => $value_menu) { ?>
                            <?php if ($value_menu->parent_id == 0) { ?>
                                <tr>
                                    <td><input type="checkbox" name="menu[]" id="checkbox-<?= $value_menu->id; ?>" value="<?= $value_menu->id; ?>" <?= check_menu($group_id, $value_menu->id) ?>> <?= $value_menu->title; ?></td>
                                </tr>
                                <!-- Loop submenu -->
                                <?php foreach ($menu as $key => $submenu) { ?>
                                    <?php if ($submenu->parent_id == $value_menu->id) { ?>
                                        <tr class="m-3" style="margin-left:10%;">
                                            <td><input class="ml-5" type="checkbox" id="checkbox-<?= $submenu->id; ?>" name="menu[]" value="<?= $submenu->id ?>" <?= check_menu($group_id, $submenu->id) ?>> <?= $submenu->title; ?></td>
                                            <td><input class="ml-5" type="checkbox" id="read" name="menu_akses[]" value="read"> Read</td>
                                            <td><input class="ml-5" type="checkbox" id="delete" name="menu_akses[]" value="delete"> Delete</td>
                                            <td><input class="ml-5" type="checkbox" id="update" name="menu_akses[]" value="update"> Update</td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </table>
                </div>
                <div class="card-footer mb-5">
                    <button type="button" onclick="window.history.back();" class="btn btn-danger btn-sm float-left">Back</button>
                    <button type="submit" class="btn btn-primary btn-sm float-right">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</main>
<script>
    $(document).ready(function() {
        $("#example1").DataTable();
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