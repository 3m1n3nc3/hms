    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 Important Shortcuts -->
          <div class="col-lg-12">
            <a href="<?= site_url('employee/add')?>" class="btn btn-success text-white my-2">
              <i class="fas fa-plus"></i> Add Employee
            </a>
            <?= $this->session->flashdata('message') ?? '' ?>
            <div class="card">
              <div class="card-header">
                <strong class="m-0 p-0">
                  <i class="fa fa-users mx-2 text-gray"></i>
                  View Employees
                </strong>
                <div class="float-right d-none d-sm-inline text-sm my-0 p-0">
                  <?= $pagination ?>
                </div>
              </div>
              <div class="card-body p-1">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th> Name </th>
                      <th> Username </th>
                      <th> Phone Number </th>
                      <th> Department </th>
                      <th> Job </th>
                      <th> Email Address</th> 
                      <th class="td-actions"> Actions </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($employees): ?>
                    <?php foreach ($employees as $employee): ?>
                    <tr>
                      <td>
                        <a href="<?= site_url('employee/profile/'.$employee->employee_id) ?>">
                          <?=$employee->employee_firstname . ' ' . $employee->employee_lastname;?>
                        </a>
                      </td>
                      <td> <?=$employee->employee_username;?> </td>
                      <td> <?=$employee->employee_telephone;?> </td>
                      <td> <?=$employee->department_name;?> </td>
                      <td> <?=$employee->employee_type;?> </td>
                      <td> <?=$employee->employee_email;?> </td> 
                      <td class="td-actions">
                        <?php if ($employee->employee_id !== '0'): ?>
                        <a href="<?= site_url('employee/profile/'.$employee->employee_id) ?>" class="btn btn-sm btn-success" data-toggle="tooltip" title="Profile">
                          <i class="btn-icon-only fa fa-user text-white"></i>
                        </a>
                        <a href="<?= site_url('employee/add/'.$employee->employee_id) ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                          <i class="btn-icon-only fa fa-edit text-white"></i>
                        </a>
                        <a href="<?= site_url('employee/delete/'.$employee->employee_id) ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete">
                          <i class="btn-icon-only fa fa-trash text-white"></i>
                        </a>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                      <td colspan="7"><?php alert_notice('No employees available', 'info', TRUE, FALSE) ?></td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
