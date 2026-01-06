<?php echo $header; ?>
<div class="main-panel">
  <div class="sec-head">
    <div class="sec-head-title">
      <h3>Newsletter Details</h3>
    </div>
  </div>
  <div class="main-employee-box">
    <table class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody>
        <?php
        if ($enquiry) { ?>
          <tr>
            <th>
              Name
            </th>
            <td>
              <?= $enquiry['name'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Phone Number
            </th>
            <td>
              <?= $enquiry['phone'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Email
            </th>
            <td>
              <?= $enquiry['email'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Subject
            </th>
            <td>
              <?= $enquiry['subject'] ?> 
            </td>
          </tr> 
          <tr>
            <th>
              Enquiry Date
            </th>
            <td>
              <?= $enquiry['enquiry_date'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Message
            </th>
            <td>
              <?= $enquiry['message'] ?>
            </td>
          </tr>
          
        <?php }
        ?>
      </tbody>
    </table>
    <div class="row">
						<div class="col-md-12 bottom-inline-btns">
							<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Back" class="btn btn-danger"><i
									class="fa fa-reply"></i> Back</a>
						</div>
					</div>
  </div>
</div>
<?php echo $footer; ?>