<main>
    <div class="container-fluid">
        <h1 class="mb-4 mt-3">Form Evaluasi Competency</h1>
        <?= $this->session->flashdata('message'); ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-form mr-1"></i>
                Form Evaluasi Competency
            </div>
            <form action="<?= base_url('competency/save_evaluasi') ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="asesor">Asesor</label>
                                <select name="asesor" id="asesor" class="form-control select2" required>
                                    <option value=""></option>
                                    <option value="" disabled>:: Select One ::</option>
                                    <?php foreach ($userAccess as $key => $ases) { ?>
                                        <option value="<?= $ases->employee_id ?>"><?= $ases->full_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="employee">Employee</label>
                                <select name="employee" id="employee" class="form-control select2" required>
                                    <option value=""></option>
                                    <option value="" disabled>:: Select One ::</option>
                                    <?php foreach ($employee as $key => $emp) { ?>
                                        <option value="<?= $emp->id ?>"><?= $emp->full_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date_com">Tanggal</label>
                                <input type="date" name="date_com" id="date_com" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <img id="profile" src="<?= base_url('assets/img/default.jpg') ?>" style="width: 192px; height: 138px;" class="card-img" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title" id="name_">Name</h5>
                                            <p class="card-text"><small class="text-muted" id="nip_">NIP</small></p>
                                            <p class="card-text" id="depart_">Department</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="employee">Uni Competency</label>
                                <select name="unit_competency" id="unit_competency" class="form-control select2" required>
                                    <option value=""></option>
                                    <option value="" disabled>:: Select One ::</option>
                                    <?php foreach ($UniComp as $key => $comp) { ?>
                                        <option value="<?= $comp->id ?>"><?= $comp->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-md-6">
                            <div class="table-responsive">
                                <table id="criteria" class="table table-striped table-bordered nowrape">
                                    <thead>
                                        <tr>
                                            <th width="30px" class="text-center">No</th>
                                            <th width="60%">Criteria</th>
                                            <th width="100px">Quality</th>
                                            <th>Value</th>
                                            <th width="10%">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" class="text-center">Total</th>
                                            <th id="total-bobot"></th>
                                            <th></th>
                                            <th id="total-all" class="text-center"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('competency/license') ?>" class="btn btn-danger">Submit</a>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {

    })
    $('#employee').change(function() {
        var employeeId = $(this).val();

        $.ajax({
            url: "<?= base_url() . 'competency/getEmployee'; ?>",
            async: false,
            type: 'POST',
            data: {
                employeeId: employeeId
            },
            dataType: 'json',
            success: function(data) {
                $('#profile').attr('src', "<?= base_url('assets/img/') ?>" + data.profile)
                $('#name_').html(data.full_name);
                $('#nip_').html(data.nip);
                $('#depart_').html(data.depart_name);
            }
        });

    })

    $('#unit_competency').change(function() {
        var compId = $(this).val();
        var unitData = '';
        var totalBobot = 0;
        $.ajax({
            url: "<?= base_url() . 'competency/getCriteriaComp'; ?>",
            async: false,
            type: 'POST',
            data: {
                compId: compId
            },
            dataType: 'json',
            success: function(data) {
                $('tbody tr').remove()
                $.each(data, function(index, unit) {
                    unitData += `
                        <tr>
                            <td>${parseInt(index+1)}</td>
                            <td>${unit.name}</td>
                            <td>
                                <input type="text" style="background-color:white;" id="bobot-${index}" name="bobot[]" class="form-control" value="${unit.value_weight}" readonly>
                            </td>
                            <td>
                                <select name="value[]" id="value-${index}" onchange="getSub(${index})" class="form-control" required>
                                    <option value="0">:: Select One ::</option>
                                    <option value="20">20</option>
                                    <option value="40">40</option>
                                    <option value="60">60</option>
                                    <option value="80">80</option>
                                    <option value="100">100</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" id="sub-${index}" name="sub_total[]" style="background-color:white;" class="form-control" value="0" readonly>
                            </td>
                        </tr>
                    `;
                    totalBobot += parseInt(unit.value_weight);
                });
                $('#total-bobot').html(totalBobot + ' %');
                $('#criteria tbody').append(unitData);
            }
        });
    });

    function getSub(index) {
        var sub_value = parseInt($('#value-' + index).val());
        var sub_bobot = parseInt($('#bobot-' + index).val());

        var sub_total = (sub_bobot / 100) * sub_value;
        // console.log(sub_total);


        var item_select = 0;
        $('#sub-' + index).val(sub_total);

        // setTimeout(function() {
        $('[name="sub_total[]"]').each(function(i, value) {
            item_select = parseInt(item_select) + parseInt($(value).val());

        });
        // }, 500);

        console.log(item_select);
        // setTimeout(function() {
        $('#total-all').html(item_select);
        // }, 500)


    }
</script>