<?php echo $header; ?>
<div class="main-panel">
  <div class="sec-head">
    <div class="sec-head-title">
      <h3>Enquiry Details</h3>
    </div>
  </div>
  <div class="main-employee-box">
    <table class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody>
        <?php
        if ($productenquiry) { ?>
          <tr>
            <th>
            Name
            </th>
            <td>
              <?= $productenquiry['name'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Email Address
            </th>
            <td>
              <?= $productenquiry['email'] ?>
            </td>
          </tr>
          <tr>
            <th>
            Phone
            </th>
            <td>
              <?= $productenquiry['phone'] ?> 
            </td>
          </tr> 
           <tr>
            <th>
            Country
            </th>
            <td>
              <?= $productenquiry['country'] ?>
            </td>
          </tr>
          <tr>
            <th>
            City
            </th>
            <td>
              <?= $productenquiry['city'] ?>
            </td>
          </tr>
           <tr>
            <th>
            Subject
            </th>
            <td>
              <?= $productenquiry['subject'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Enquiry Date
            </th>
            <td>
              <?= $productenquiry['enquiry_date'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Message
            </th>
            <td>
              <?= $productenquiry['message'] ?>
            </td>
          </tr>
          <tr>
            <th>
              Enquiry From URL
            </th>
            <td>
             <a href='<?= $productenquiry['enquiry_from'] ?>'target="_blank"> URL<?= $enquiry['enquiry_from'] ?> </a>
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