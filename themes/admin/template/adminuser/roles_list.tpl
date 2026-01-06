<?php echo $header; ?>
<div class="main-panel">

	<div class="sec-head">
		<div class="sec-head-title">
			<h3>Roles</h3>
		</div>

	</div>




	<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } ?>

	<?php if ($success) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } ?>
	<div class="main-employee-box">
		<div class="employee-table-out-box">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="card">
						<div class="card-bodys">
							<table id="ptc-table" class="table table-borderless mb-0" width="100%" cellspacing="0" cellpadding="0" border="0">
								<thead class="head-table-rang">
									<tr>
										<th class="text-left">Roles Name</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>

								<tbody>
									<?php if ($user_groups) { ?>
										<?php foreach ($user_groups as $user_group) { ?>
											<tr>
												<td class="text-left"><?php echo $user_group['name']; ?></td>
												<td class="text-right">
													<a style="display: inline-block;" href="<?php echo $user_group['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>


												</td>
											</tr>
										<?php } ?>
									<?php } else { ?>
										<tr>
											<td class="text-center" colspan="3"><?php echo $text_no_results; ?></td>
										</tr>
									<?php } ?>
								</tbody>


							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var table = $('#ptc-table').DataTable({
		// dom: 'Bfrtip',
		"pageLength": 10,
		"ordering": false,
		orderCellsTop: true,
		fixedHeader: true,
		buttons: false,
	});
</script>
<?php echo $footer; ?>