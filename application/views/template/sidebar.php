<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">

                    <?php
                    $this->db->order_by('sort_by', 'asc');
                    $main =  $this->db->get('heading_menu')->result();
                    $active_parent = $this->db->get_where('menus', ['link' => $active])->row();
                    // log_r($this->db->last_query());
                    ?>
                    <?php foreach ($main as $key => $value) { ?>
                        <?php
                        $this->db->select('A.*');
                        $this->db->join('user_access_role B', 'A.id = B.menu_id');
                        $this->db->where('B.group_id', $this->session->userdata('group_id'));
                        $menu_load = $this->db->get_where('menus A', ['A.head_id' => $value->id])->result();
                        // log_r($menu_load);
                        ?>
                        <?php if ($menu_load) { ?>
                            <div class="sb-sidenav-menu-heading"><?= $value->name ?></div>
                        <?php } ?>
                        <?php foreach ($menu_load as $k => $m) { ?>
                            <!-- log -->
                            <?php if (check_persmission_views($this->session->userdata('group_id'), $m->id)) { ?>
                                <?php if ($m->link == '#' || $m->link == '') {  ?>

                                    <a class="nav-link <?= ($active_parent->id != $m->id) ? 'collapsed' : '' ?>" href="#" data-toggle="collapse" data-target="#<?= $value->name . '-' . $k ?>" aria-expanded="false" aria-controls="<?= $value->name . '-' . $k ?>">
                                        <div class="sb-nav-link-icon"><i class="fas <?= $m->icon ?>"></i></div>
                                        <?= $m->title ?>
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse <?= ($active_parent->id == $m->id) ? 'show' : ' ' ?>" id="<?= $value->name . '-' . $k ?>" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <?php
                                            $sub_menu = $this->db->get_where('menus', ['parent_id' => $m->id])->result();
                                            ?>

                                            <?php foreach ($sub_menu as $key => $sb) { ?>
                                                <?php if (check_persmission_views($this->session->userdata('group_id'), $sb->id)) { ?>
                                                    <a class="nav-link <?= ($m->link == $active) ? 'active' : ' ' ?>" href="<?= base_url($sb->link) ?>"><?= $sb->title ?></a>
                                                <?php } ?>
                                            <?php } ?>
                                        </nav>
                                    </div>
                                <?php } else { ?>
                                    <a class="nav-link <?= ($m->link == $active) ? 'active' : ' ' ?>" href="<?= base_url($m->link) ?>">
                                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                        Dashboard
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">