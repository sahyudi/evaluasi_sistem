<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Employee</h1>
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Data Employee
                <a href="#" onclick="reset_form()" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#modal-unit-comptency"><i class="fas fa-fw fa-plus"></i> Add Employee</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Min Score</th>
                                <th>Actions</th>
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