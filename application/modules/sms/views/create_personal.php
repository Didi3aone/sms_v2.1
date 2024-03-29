<?php
	$id = isset($datas['template_id']) ? $datas['template_id'] : "";
	$name = isset($datas['template_name']) ? $datas['template_name'] : "";
	$content = isset($datas['template_content']) ? $datas['template_content'] : "";
?>
<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
			<h1 class="page-title txt-color-blueDark"><?= $title_page ?></h1>
		</div>
		<div class="col-xs-12 col-sm-5 col-md-5 col-lg-4 col-lg-offset-1 text-right">
			<h1>
				<button class="btn btn-primary submit-form" data-form-target="sms-form" title="Send SMS" rel="tooltip" data-placement="top" >
					<i class="fa fa-envelope-o fa-lg"></i>
				</button>
			</h1>
		</div>
	</div>

	<!-- widget grid -->
	<section id="widget-grid" class="">

		<div class="row">
			<!-- NEW WIDGET ROW START -->
			<article class="col-sm-12 col-md-12 col-lg-12">

				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-0"
				data-widget-editbutton="false"
				data-widget-deletebutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-pencil-square-o"></i> </span>
						<h2><?= $title_msg ?> SMS PERSONAL</h2>

					</header>

					<!-- widget div-->
					<div>

						<form class="smart-form" id="sms-form" action="<?= site_url('sms/process_form'); ?>" method="post">
							<?php if($id != 0): ?>
								<input type="hidden" name="id" value="<?= $id ?>" />
							<?php endif; ?>
							<fieldset>
								<div class="row">
									<section class="col col-6">
										<label class="label">Select Methode</label>
										<label class="select" id="methode">
											<select name="type" id="numb" class="input-sm">
												<option value="0"> -- Choose --</option>
												<option value="1">From Database</option>
												<option value="2">Input Number</option>
											</select> <i></i> </label>
									</section>

									<section class="col col-6" style="display: none;" id="input_numb">
										<label class="label">SMS TO <sup class="color-red">*</sup></label>
										<label class="input">
											<input type="text" name="nomor" id="nomor" value="" placeholder="SMS TO">
										</label>
									</section>

									<section class="col col-6" id="from_db" style="display: none;">
										<label class="label">Select Number</label>
										<label class="select">
											<select name="nomors" id="from_dbs" style="width: 100%;">
												<option selected value=""></option>
											</select>
										</label>
									</section>

								</div>
								<div class="row">
									<section class="col col-6">
										<label class="label">Select Template</label>
										<label class="select">
											<select name="template_id" id="template" class="input-sm template">
												<option value="0"> -- Choose --</option>
												<?php foreach ($template as $key => $value): ?>
													<option value="<?= $value['template_id'] ?>"> <?= $value['template_name']?> </option>
												<?php endforeach ?>
											</select> <i></i>
										</label>
										<div class="note">OPSIONAL</div>
									</section>
								</div>

								<section>
									<label class="label"> Message <i style="color: red">*</i></label>
									<label class="textarea">
										<i class="icon-append fa fa-comment"></i>
										<textarea rows="5" name="isi" id="message" onkeyup="countChar(this)"></textarea>
										<div class="note">Tersisa :</div><div id="charNum"> 160</div>
										<div class="note">Karakter</div>
										<div class="note">Jika lebih dari 160 karakter maka ,karakter ke 161 dan seterusnya akan menjadi sms ke 2</div>
									</label>
								</section>
							</fieldset>
						</form>
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
			</article>
		</div>
	</section> <!-- end widget grid -->
</div> <!-- END MAIN CONTENT -->
