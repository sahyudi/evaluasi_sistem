<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Employee</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <!-- /.card -->
                <?= $this->session->flashdata('message'); ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Employee</h3>
                        <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" onclick="reset_form()" data-target="#modal-material"><i class="fas fa-fw fa-plus"></i> Add Employee</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>No KTP</th>
                                        <th>Nama</th>
                                        <th>No Telp</th>
                                        <th>Agama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tanggal_lahir</th>
                                        <th>Usia</th>
                                        <th>Alamat</th>
                                        <th>Pendidikan</th>
                                        <th>Gol Darah</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($emp as $key => $value) { ?>
                                        <tr>
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td><?= $value->no_ktp  ?></td>
                                            <td><?= $value->nama  ?></td>
                                            <td><?= $value->no_telp  ?></td>
                                            <td><?= $value->agama  ?></td>
                                            <td><?= $value->jenis_kel  ?></td>
                                            <td><?= $value->tgl_lahir  ?></td>
                                            <?php
                                            $tgl_lahir = new DateTime($value->tgl_lahir);

                                            // tanggal hari ini
                                            $today = new DateTime('today');

                                            // tahun
                                            $usia = $today->diff($tgl_lahir)->y;

                                            // // bulan
                                            // $m = $today->diff($tanggal)->m;

                                            // // hari
                                            // $d = $today->diff($tanggal)->d;
                                            // echo "Umur: " . $y . " tahun " . $m . " bulan " . $d . " hari";
                                            ?>
                                            <td><?= $usia ?> Tahun</td>
                                            <td><?= $value->alamat  ?></td>
                                            <td><?= $value->pendidikan  ?></td>
                                            <td><?= $value->gol_darah  ?></td>
                                            <td>
                                                <a href="<?= base_url('employee/delete_employee/') . $value->id ?>" onclick="return validation()" class="btn btn-danger btn-xs"><i class="fas fa-fw fa-trash"></i></a>
                                                <a href="#" data-id="<?= $value->id ?>" data-toggle="modal" data-target="#modal-material" class="btn btn-success btn-edit btn-xs"><i class="fas fa-fw fa-pencil-alt"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-material">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Employee Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('employee/add') ?>" id="form-employee" method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">No KTP</label>
                            <input type="number" name="no_ktp" id="no_ktp" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">No Telp.</label>
                            <input type="number" name="no_telp" id="no_telp" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control form-control-sm" placeholder="Nama">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Agama</label>
                            <select name="agama" id="agama" class="form-control form-control-sm select2">
                                <option value=""></option>
                                <?php foreach ($agama as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                                <?php  } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Jenis Kelamin</label>
                            <br>
                            <input type="radio" name="jenis_kel[]" id="laki" value="Laki - laki"> Laki - Laki &nbsp;&nbsp;&nbsp;
                            <input type="radio" name="jenis_kel[]" id="perempuan" value="Perempuan"> Perempuan
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Pendidikan</label>
                            <select type="text" name="pendidikan" id="pendidikan" class="form-control form-control-sm select2">
                                <option value=""></option>
                                <?php foreach ($pendidikan as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                                <?php  } ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Gol Darah</label>
                            <select name="gol_darah" id="gol_darah" class="form-control form-control-sm select2">
                                <option value=""></option>
                                <?php foreach ($gol_darah as $key => $value) { ?>
                                    <option value="<?= $value->id ?>"><?= $value->nama ?></option>
                                <?php  } ?>
                            </select>
                        </div>
                        <div class="form- col-md-6">
                            <label for="exampleInputPassword1">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control form-control-sm" cols="3" placeholder="alamat"></textarea>
                        </div>
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
        $('.select2').select2();
        $('#form-employee').validate({
            rules: {
                nama: {
                    required: true
                },
                Agama: {
                    required: true
                },
                jenis_kel: {
                    required: true
                },
                no_ktp: {
                    required: true
                },
                no_telp: {
                    required: true
                },
                pendidikan: {
                    required: true
                },
            },
            messages: {
                nama: {
                    required: "Please enter a nama.."
                },
                Agama: {
                    required: "Please enter a Agama.."
                },
                jenis_kel: {
                    required: "Please enter a Jenis Kelamin"
                },
                tgl_lahir: {
                    required: "Please enter a Tanggal Lahir"
                },
                no_telp: {
                    required: "Please enter a no telp"
                },
                no_ktp: {
                    required: "Please enter a no ktp"
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
    $(document).ready(function() {
        $("#example1").DataTable({});
        $(":input").inputmask();
    });

    function validation() {
        return confirm('Apakah anda yakin akan mengahapus data employee ??');
    }

    function reset_form() {
        $('#form-employee')[0].reset();
        $('.select2').select2('val', '');
        $('#laki').removeAttr("checked");
        $('#perempuan').removeAttr("checked");
        // $('#form-employee')[0].reset();
    }

    $('.btn-edit').click(function() {
        const id = $(this).data('id');
        // alert(id);
        $.ajax({
            url: "<?= base_url() . 'employee/get_employee/'; ?>" + id,
            async: false,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#nama').val(data.nama);
                $('#tgl_lahir').val(data.tgl_lahir);
                $('#agama').select2('val', data.agama);
                $('#gol_darah').select2('val', data.gol_darah);
                $('#pendidikan').select2('val', data.pendidikan);
                $('#no_ktp').val(data.no_ktp);
                $('#alamat').val(data.alamat);
                $('#no_telp').val(data.no_telp);
                if (data.jenis_kel == 'Laki - laki') {
                    console.log('laki laki')
                    $('#laki').attr("checked", "checked");
                } else {
                    $('#perempuan').attr("checked", "checked");
                }
                // $('#jenis_kel').val(data.jenis_kel);
            }
        });
    });
</script>
<!-- /.content-wrapper -->