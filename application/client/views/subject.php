<div class="row">
	<div class="tab-content">

		<h3>Browsing Genre</h3></br>
		<div id="postList">
			<ul class="browse-list" id="browseList">
				<?php
				if ($getdata == null) {
				?>
					<li align="center">
						<td colspan="7">No Data to display</td>
					<li>
						<?php
					} else {
						foreach ($getdata as $post2) {
						?>
							<a href="<?= base_url('subject/category/' . $post2->id) ?>" class="js-sublink" data-sub_category="genre" data-primary_key="1">
					<li class="catalog-result all" id="<?= base_url('subject/category/' . $post2->id) ?>">
						<div class="result-data">
							<h3>
								<?php echo $post2->sub_name; ?>
							</h3>
							<p class="book-meta">Total: <span><?php echo $post2->total; ?> books</span>
							</p>
						</div>
						<a href="#" data-sub_category="genre" data-primary_key="1" class="js-sublink more-result">more
							results</a>
					</li>
					</a>
			<?php
						}
					} ?>
			</ul>
		</div>

	</div>

</div>

</div>
</div>



</div>
</div>
</div>
</section>

</div>
</div>
<script>
	document.getElementById("browseList").addEventListener("click", function(e) {
		// e.target is our targetted element.
		console.log(e.target.nodeName)
		if (e.target && e.target.nodeName == "LI") {
			location.replace(e.target.id);
			// alert(e.target.id);
		}
	});
</script>
<style>
	.catalog-result {
		cursor: pointer;
	}
</style>