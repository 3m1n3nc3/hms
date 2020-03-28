<!-- Main content -->
<div class="content">
  <div class="container-fluid"> 

    <div class="row">
        <!-- /.col-md-4 Important Shortcuts -->
        <div class="col-md-12"> 

        <div class="card">
            <div class="card-header">
                <h5 class="m-0">
                    <i class="fa fa-user mx-2 text-gray"></i>
                    Add a new customer
                </h5>
            </div>
            <div class="card-body"> 
                <?= $this->session->flashdata('message') ?? '' ?>
                <script type="text/javascript">
                setTimeout(function(){window.location.href="/<?=$type?>";}, 3000);
                </script>
            </div>
        </div>
      <!-- /.col-md-12 --> 
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
