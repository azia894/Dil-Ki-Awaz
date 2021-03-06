<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container">
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title">Genre/Subject Books</h4>
					<ol class="breadcrumb">
						<li>
							<a
								href="<?=base_url('author')?>">Genre/Subject
								Books List</a>
						</li>
						<li class="active">
							Add
						</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="progress">
					<div class="progress-bar progress-bar-striped progress-bar-animate" role="progressbar"
						id="upload_progress" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0">
						<p id="progress"></p>
					</div>
				</div>
			</div>
			<!-- <div id="alert"></div> -->
			<div class="row">
				<div class="col-sm-9">
					<div id="add_book_msg"></div>
					<form id="add_book_form" name="add_book_form" role="form"
						action="<?=base_url('books/create')?>"
						method="post" enctype="multipart/form-data">
						<div class="card-box">
							<h4 class="m-t-0 header-title"><b>Add Books</b></h4></br></br>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Title</label>
										<input class="form-control" id="bk_name" name="bk_name" required>
									</div>
									<div class="form-group">
										<label>Authors</label>
										<select name="author_id" id="author_id" class="form-control" required>
											<option value="">Select Author</option>
											<?php
                                        if ($get_data['num']>0) {
                                            foreach ($get_data['data'] as $c) {
                                                ?>
											<option
												value="<?=$c->id?>">
												<?=$c->aut_name?>
											</option>
											<?php
                                            }
                                        }
                                               ?>
										</select>
									</div>
									<div class="form-group">
										<label>Year Of Publication</label>
										<input class="form-control" id="bk_year" name="bk_year" required>
									</div>
									<div class="form-group">
										<label>Genre</label>
										<select name="sub_id" id="sub_id" class="form-control" multiple>
											<option value="">Select Genre</option>
											<?php
                                        if ($get_sub['num']>0) {
                                            foreach ($get_sub['data'] as $s) {
                                                ?>
											<option
												value="<?=$s->id?>">
												<?=$s->sub_name?>
											</option>
											<?php
                                            }
                                        }
                                               ?>
										</select>
									</div>
									<div class="form-group">
										<label>Age</label>
										<select name="bk_age" id="bk_age" class="form-control required">
											<option value="">Select Age</option>
											<option value="Old">Old people</option>
											<option value="Adults">Adult</option>
											<option value="children">Children</option>
										</select>
									</div>
									<div class="form-group">
										<label>Blurb</label>
										<input class="form-control" id="bk_blurb" name="bk_blurb">
									</div>
									<div class="form-group">
										<label>Tags</label>
										<input class="form-control" id="bk_tags" name="bk_tags">
									</div>
									<div class="form-group">
										<label>Description </label>
										<textarea class="form-control" placeholder="Enter Description" name="bk_desc"
											id="bk_desc"></textarea>
										<!--label class="error" generated="true" for="job_desc"></label-->
									</div>
									<div class="form-group">
										<label>Image</label>
										<input type="hidden" name="bk_img" id="bk_img" accept="Image/png,image/jpeg,image/gif">
										<input type="file" name="upload_book_img" id="upload_book_img"
											accept="Image/png,image/jpeg,image/gif">
									</div>
									<button type="button" class="btn btn-primary" onClick="new_book()">Submit</button>
									<!-- <button type="submit" class="btn btn-primary" >Submit</button> -->
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div> <!-- container -->
	</div> <!-- content -->

<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-storage.js"></script>

<script>
	// firebase config
	// start
	var firebaseConfig = {
		apiKey: "AIzaSyBIJvdVBLPx7eSBLs3Y_tAu7wvsTTO39Ds",
		authDomain: "dilkiawaz-6854d.firebaseapp.com",
		databaseURL: "https://dilkiawaz-6854d-default-rtdb.firebaseio.com",
		projectId: "dilkiawaz-6854d",
		storageBucket: "dilkiawaz-6854d.appspot.com",
		messagingSenderId: "800531980880",
		appId: "1:800531980880:web:ec42f97c62f95d91baa755",
		measurementId: "G-MRQJ04PQZM"
	};


	// Initialize Firebase
	firebase.initializeApp(firebaseConfig);
	console.log('success');
	firebase.analytics();
	//   firebase.storage();
	var storage = firebase.storage();

	var storageRef = storage.ref();

	function new_book() {
		var name = document.getElementById('bk_name').value;
		var file = document.getElementById('upload_book_img').files[0];
		var filename = document.getElementById('upload_book_img').value;

		const extension = filename.split('.').pop();
		var bookName = document.getElementById('bk_name').value + '.' + extension;
		if(name == ""){
			console.log('more');
			// document.getElementById('alert').innerHTML = '<div class="alert alert-warning">' +
			// 	'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
			// 	'<strong>book title must not be empty</strong>' +
			// 	'</div>'
		}
		else if (!file) {
			console.log('more');
			// document.getElementById('alert').innerHTML = '<div class="alert alert-warning">' +
			// 	'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
			// 	'<strong>Audio should be less than 60 mins</strong>' +
			// 	'</div>'
		} else {
			// Create the file metadata
			var metadata = {
				contentType: 'image/jpeg'
			};
			// Upload file and metadata to the object 'images/mountains.jpg'
			var uploadTask = storageRef.child('/bookImages/'+ bookName).put(file, metadata);
			
			// document.getElementById("cancel_btn").addEventListener('click', function() {
			// 	console.log('cancel pressed');
			// 	uploadTask.cancel();
			// })

			// // Listen for state changes, errors, and completion of the upload.
			uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED, // or 'state_changed'
				(snapshot) => {
					// // Get task progress, including the number of bytes uploaded and the total number of bytes to be uploaded
					var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
					console.log('Upload is ' + Math.round(progress) + '% done');
					document.getElementById('progress').innerHTML = Math.round(progress) + '%';
					document.getElementById("upload_progress").style.width = Math.round(progress) + '%';
					switch (snapshot.state) {
						case firebase.storage.TaskState.PAUSED: // or 'paused'
							console.log('Upload is paused');
							break;
						case firebase.storage.TaskState.RUNNING: // or 'running'
							console.log('Upload is running');
							break;
					}
				},
				(error) => {
					
					// // A full list of error codes is available at
					// // https://firebase.google.com/docs/storage/web/handle-errors
					switch (error.code) {
						case 'storage/unauthorized':
							// User doesn't have permission to access the object
							break;
						case 'storage/canceled':
							// User canceled the upload
							break;
							// ...
						case 'storage/unknown':
							// Unknown error occurred, inspect error.serverResponse
							break;
					}
				},
				() => {
					// Upload completed successfully, now we can get the download URL
					uploadTask.snapshot.ref.getDownloadURL().then((downloadURL) => {
						console.log('File available at', downloadURL);
						document.getElementById("bk_img").value = downloadURL;

						document.getElementById("add_book_form").submit();
					});
				}
			);
			console.log('less');
		}
	}
</script>