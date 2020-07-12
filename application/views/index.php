<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Information License Employee</h1>
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <!-- <div class="card-header">
                <i class="fas fa-table mr-1"></i>
            </div> -->
            <div class="card-body">
                <!-- Navbar Search-->
                <form id="form-nik-employee" action="<?= base_url('information') ?>" method="GET">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="input-group col-md-6">
                            <input class="form-control" type="text" name="nip" value="<?= $this->input->get('nip') ?>" placeholder="insert nip for..." aria-label="Search" aria-describedby="basic-addon2" />
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <?php if ($unit) { ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="box box-primary mt-5">
                                    <div class="box-body box-profile">
                                        <center>
                                            <img class="profile-user-img text-center img-responsive img-circle" width="100px" height="100px" src="<?= base_url('assets/img/') . $unit[0]->profile ?>" alt="User profile picture">
                                        </center>

                                        <h3 class="profile-username text-center mt-2"><?= $unit[0]->full_name ?></h3>

                                        <p class="text-muted text-center text-bold"><?= $unit[0]->nip ?></p>
                                        <div class="table-responsive">
                                            <table class="table table-stripped table-bordered">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>No</th>
                                                        <th>Unit of Competency</th>
                                                        <th>Expiry Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($unit as $key => $value) { ?>
                                                        <tr>
                                                            <td class="text-center"><?= $key + 1 ?></td>
                                                            <td><?= $value->license ?></td>
                                                            <td class="text-center"><?= date('d F Y', strtotime($value->exp_date)) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                        
                </form>
            </div>
        </div>
    </div>
</main>