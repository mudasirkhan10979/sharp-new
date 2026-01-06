<?php echo $header; ?>
<div class="main-panel">
  <div class="sec-head">
    <div class="sec-head-title">
      <h3>Career Enquiry Details</h3>
    </div>
  </div>
  <div class="main-employee-box">
    <table class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody>
        <?php
        if ($enquiry_detail) { ?>
          <tr>
            <th>
              Name
            </th>
            <td>
              <?= $enquiry_detail['name'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Career
            </th>
            <td>
              <?= $enquiry_detail['title'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Phone Number
            </th>
            <td>
              <?= $enquiry_detail['phone'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Email
            </th>
            <td>
              <?= $enquiry_detail['email'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Subject
            </th>
            <td>
              <?= $enquiry_detail['subject'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Message
            </th>
            <td>
              <?= $enquiry_detail['message'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Enquiry Date
            </th>
            <td>
              <?= $enquiry_detail['date_added'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Enquiry From URL
            </th>
            <td>
             <a href='<?= $enquiry_detail['enquiry_from'] ?>'target="_blank"> <?= $enquiry_detail['enquiry_from'] ?> </a>
            </td>
          </tr>
          <tr>
            <th>
              Resume
            </th>
            <td>
             <a href='../uploads/image/careers/cvs/<?= $enquiry_detail['cv_file'] ?>'target="_blank"> <?= $enquiry_detail['cv_file'] ?> </a>
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