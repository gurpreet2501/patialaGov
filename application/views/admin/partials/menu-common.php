<ul class="nav navbar-nav side-nav">
    <li class="active">
      <a href='<?php echo site_url('/admin/reports')?>'>Reports</a> 
    </li>
    
<?php if($role=='plant_manager'): ?>
    <li class="active">
      <a href='<?php echo site_url('/admin/district_target')?>'>District Targets</a> 
    </li>
    <li class="active">
      <a href='<?php echo site_url('/admin/customer_target')?>'>Customer Targets</a> 
    </li>
    <li class="active">
      <a href='<?php echo site_url('/admin/orders')?>'>Manage Orders</a> 
    </li>
<?php endif; ?>
    
<?php if($role=='admin'): ?>
    <li class="active">
      <a href='<?php echo site_url('/reports/summary')?>'>Summary Report</a> 
    </li>
    <li class="active">
      <a href='<?php echo site_url('/reports/pending_orders')?>'>Manage Orders</a> 
    </li>
    <!--<li class="active">
      <a href='<?php echo site_url('/admin/users')?>'>Site Users</a> 
    </li>-->
    <li class="active">
      <a href='<?php echo site_url('/admin/customers')?>'>Manage Customers</a> 
    </li>
    <li class="active">
      <a href='<?php echo site_url('/admin/bookings')?>'>Manage Bookings</a> 
    </li>
   <li class="active">
      <a href='<?php echo site_url('/admin/districts')?>'>Manage Districts</a> 
    </li>
<?php elseif($role=='plant_manager'): ?>
    <li class="active">
      <a href='<?php echo site_url('/admin/bookings')?>'>Manage Bookings</a> 
    </li>
    <li class="active">
      <a href='<?php echo site_url('/admin/categories')?>'>Manage Categories</a> 
    </li>
    <li class="active">
      <a href='<?php echo site_url('/admin/products')?>'>Manage Products</a> 
    </li>
    <li class="active">
      <a href='<?php echo site_url('/admin/bulk_product_edit')?>'>Bulk Product Edit</a> 
    </li>
    <li class="active">
      <a href='<?php echo site_url('/admin/customers')?>'>Manage Customers</a> 
    </li> 
    <li class="active">
      <a href='<?php echo site_url('/admin/customer_categories')?>'>Customer Categories</a> 
    </li>                   
    <li class="active">
      <a href='<?php echo site_url('/manage/discount/types')?>'>Manage Discount Types</a> 
    </li>
    <li class="active">
      <a href='<?php echo site_url('/manage/tax/types')?>'>Manage Tax Types</a> 
    </li>
    <li class="active">
      <a href='<?php echo site_url('/admin/store_settings')?>'>Settings</a> 
    </li>
<?php endif; ?>    
    
    <li class="active">
      <a href='<?php echo site_url('/admin/update_password')?>'>Update Password</a> 
    </li>
</ul>