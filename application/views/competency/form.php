<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Form Evaluasi Competency</h1>
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-form mr-1"></i>
                Form Evaluasi Competency
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group">
                        <label for="employee">Employee</label>
                        <select name="employee" id="employee" class="form-control select2">
                            <option value=""></option>
                            <?php foreach ($employee as $key => $emp) { ?>
                                <option value="<?= $emp->id ?>"><?= $emp->full_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>