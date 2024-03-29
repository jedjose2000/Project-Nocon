<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <a href="#" class="brand-link">
    <span class="brand-text font-weight-light">Administrator</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


        <?php if ($userLevel == '1') { ?>
          <li class="nav-item">
            <a href="<?php echo base_url('dashboard'); ?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('category'); ?>" class="nav-link ">
              <i class="fa-regular fa-rectangle-list order-icon"></i>
              <p>Category</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('supplier'); ?>" class="nav-link ">
              <i class="nav-icon fa-solid fa-truck-field"></i>
              <p>Supplier</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('product'); ?>" class="nav-link ">
              <i class="nav-icon fa-solid fa-bag-shopping"></i>
              <p>Products</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('inventory'); ?>" class="nav-link ">
              <i class="nav-icon fa-solid fa-warehouse"></i>
              <p>Inventory</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('pos'); ?>" class="nav-link ">
              <i class="nav-icon fa-solid fa-calculator"></i>
              <p>POS Teller</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('transaction'); ?>" class="nav-link ">
              <i class="nav-icon fa-solid fa-file-lines"></i>
              <p>Reports</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('archive'); ?>" class="nav-link ">
              <i class="nav-icon fas fa-archive"></i>
              <p>Archive</p>
            </a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a href="<?php echo base_url('dashboard'); ?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('pos'); ?>" class="nav-link ">
              <i class="nav-icon fa-solid fa-calculator"></i>
              <p>POS Teller</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url('transaction'); ?>" class="nav-link ">
              <i class="nav-icon fa-solid fa-file-lines"></i>
              <p>Reports</p>
            </a>
          </li>
        <?php } ?>






      </ul>
    </nav>

  </div>

</aside>