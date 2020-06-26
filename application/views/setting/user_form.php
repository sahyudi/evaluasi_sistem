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
                Form Users
            </div>
            <div class="card-body">
                <form action="<?= base_url('setting/create_user') ?>" method="post">
                    <div class="input-group">
                        <select type="text" name="group" id="group" class="form-control form-control-sm select2" placeholder="Full name" value="<?= set_value('group') ?>">
                            <option value=""></option>
                            <?php foreach ($groups as $key => $value) { ?>
                                <option value="<?= $value->id ?>" <?= (set_value('group') == $value->id) ? 'selected' : '' ?>><?= $value->group_name ?></option>
                            <?php } ?>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-users"></span>
                            </div>
                        </div>
                    </div>
                    <?= form_error('group', '<small class="text-danger">', '</small>'); ?>
                    <div class="input-group mt-3">
                        <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Full name" value="<?= set_value('name') ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                    <div class="input-group mt-3">
                        <input type="text" name="email" id="email" class="form-control form-control-sm" value="<?= set_value('email') ?>" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                    <div class="input-group mt-3">
                        <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                    <div class="input-group mt-3">
                        <input type="password" name="password2" id="password2" class="form-control form-control-sm" placeholder="Retype password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="button" onclick="button_back()" class="btn btn-danger btn-sm">Back</button>
                            <button type="submit" class="btn btn-primary btn-sm float-right">Register</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
<!-- /.content-wrapper -->