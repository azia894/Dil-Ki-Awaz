<div class="row"><div class="tab-content">
					
					<div class="page book-page">

                        <div class="content-wrap clearfix">
                            <div class="book-page-book-cover">
                            <?php 
									$img = ADMIN_URL.'/assets/bookimages/'.$record['bk_img']; 
								?>
                                <img src="<?=$img?>" width="175" height="175" />
            
                                
                                
                            </div>
                            
                            <h1 style="color:black"><?=ucwords($record['bk_name'])?></h1>
                            
                            <p class="book-page-author"><a href="#"><?=ucwords($record['aut_name'])?> <span class="dod-dob">(<?=$record['dob']?>)</span></a></p>
                            
                            <p class="description"><br /><?=$record['bk_desc']?><br /><br /></p>
            
                            <p class="book-page-genre"><span>Genre(s):</span> Action & Adventure</p>
            
                            <p class="book-page-genre"><span>Language:</span> English</p>
            
                            
                            
                        </div> 	<!-- end .content-wrap --> 
                    
                        <table class="chapter-download">
                                <thead>
                                    <tr>
                                    <th>ID </th>
                                        <th>Audio </th>
                                        
                                        <th>Chapter</th>
                                        
                                        <th>Time</th>
            
                                        
                                    </tr>
                                </thead>
                                    <tbody>
                                    <?php
							if ($getdata == NULL) {
							?>
								<li> <td colspan="7">No Data to display</td><li>
							<?php
							} else {
                                $i=1;
								foreach ($getdata as $row) {
								?>
								
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><audio controls>
            <source src="<?=base_url('admin/assets/chapterimages/'.$row->ch_audio)?>" type="audio/ogg">
            <source src="<?=base_url('admin/assets/chapterimages/'.$row->ch_audio)?>" type="audio/mpeg">
          Your browser does not support the audio element.
          </audio></td>
                                            <td><a href="#" class="chapter-name"><?php echo $row->ch_name ?></a></td>
                                            
                                            
                                            <td>00:04:23</td>
            
                                                                        </tr>
            
                                        
                                       
                                                                      <?php
                                                                       $i++; 
								}
							}
							?>
                                        
                                      
            
                                        
                                       
            
                                    
                                </tbody>
                            </table>
                
            
            </div><!-- end .page -->
            
                   
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