<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Unit Competency Detail</h1>
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Data Unit Competency Detail
                <a href="#" onclick="reset_form()" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#modal-unit-comptency"><i class="fas fa-fw fa-plus"></i> Add Unit Competency</a>
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Criteria</th>
                                <th>Value (Bobot)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control">
                                </td>
                                <td>
                                    <input type="text" class="form-control">
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right">Max Value / Bobot</th>
                                <th id="total-bobot"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>