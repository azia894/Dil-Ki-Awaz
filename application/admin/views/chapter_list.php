<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container">
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title">Chapters  List</h4>
					<ol class="breadcrumb">
						<li>
							<a href="<?=base_url('dashboard')?>">Dashboard</a>
						</li>
						<li class="active">	
						Chapters List	
						</li>
						
						
					</ol>
				</div>
			</div>   
			<div class="row">
		<div class="col-sm-12">
		<a style=" text-decoration: none; color:white" href="<?= base_url('chapters/add') ?>"><button  type="button" class="btn btn-primary"> Add Chapters </a></button>
				<br></br>
		
			<?php
				if($this->session->flashdata('success')){
			?>
				<div class="alert alert-success alert-dismissible fade in" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span></button>
				  <strong><?=$this->session->flashdata('success')?></strong>
				</div>
			<?php
				}
				if($this->session->flashdata('invalid')){
			?>
				<div class="alert alert-danger alert-dismissible fade in" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">�</span></button>
				  <strong><?=$this->session->flashdata('invalid')?></strong>
				</div>
			<?php
				}
			?>
			<div class="card-box table-responsive">

				<h4 class="m-t-0 header-title"><b>Chapters</b></h4>
				
				<p class="text-muted font-13 m-b-30">
				   
				</p>

					<table class="table table-striped table-bordered dt-responsive nowrap" id="all-Chapters-tbl">
						<thead>
							<tr>
								<th data-class="expand">#</th>
								<th>Chapters Name<?php echo $this->uri->segment('3'); ?></th>
                                																
								<th>Audio</th>															
								<th data-hide="phone">Created On</th>												
								<th data-hide="phone,tablet">Actions</th>														
								<th data-hide="phone,tablet">Status</th>									
							</tr>
						</thead>
						<tbody>
						</tbody>									
					</table>

			</div>
		</div>
	</div>
		</div> <!-- container -->
	</div> <!-- content -->
</div>
           