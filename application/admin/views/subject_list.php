<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container">
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title">Genre/Subject List</h4>
					<ol class="breadcrumb">
						<li>
							<a href="<?=base_url('dashboard')?>">Dashboard</a>
						</li>
						<li class="active">	
						Genre/Subject List	
						</li>
						
						
					</ol>
				</div>
			</div>   
			<div class="row">
		<div class="col-sm-12">
		<a style=" text-decoration: none; color:white" href="<?= base_url('subject/add') ?>"><button  type="button" class="btn btn-primary"> Add Genre/Subject </a></button>
				<br></br>
		 <div id="add_sub_msg"></div>   
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

				<h4 class="m-t-0 header-title"><b>Genre/Subject</b></h4>
				
				<p class="text-muted font-13 m-b-30">
				   
				</p>

					<table class="table table-striped table-bordered dt-responsive nowrap" id="all-sub-tbl">
						<thead>
							<tr>
								<th data-class="expand">#</th>
								<th>Subject Name</th>												
																				
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
           