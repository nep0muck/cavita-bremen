<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @author Matthias Thom | http://upplex.de
 * @package upBootWP 1.1
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php

	// check if the flexible content field has rows of data
	if( have_rows('content') ):

	     // loop through the rows of data
	    while ( have_rows('content') ) : the_row();

			if( get_row_layout() == 'leistungen' ):
				$row = get_row_layout(); // Name of layout field 'name' to use as custom post type
				// check if the flexible content field has rows of data
				if( have_rows('repeater') ):

				     // loop through the rows of data
				    while ( have_rows('repeater') ) : the_row(); ?>
						<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?>">
							<div class="container">
								<div class="row">
					  				<div class="col-md-12">
										<?php $cat = get_sub_field('taxonomie'); ?>
										<?php $cat_desc = get_sub_field('taxonomie_beschreibung'); ?>
										<h2 id="<?php echo strtolower($cat->name); ?>" class="xtarget"><?php echo $cat->name; ?></h2>
										<p class="lead"><?php echo $cat_desc; ?></p>
										<?php $args = array(
											'post_type' => $row,
											'posts_per_page' => '-1',
											'taxonomy' => $cat->slug,
											'category_name' => $cat->slug,
											'orderby' => 'title',
											'order' => 'ASC'
										); ?>
											<?php $catquery = new WP_Query($args);
											while($catquery->have_posts()) : $catquery->the_post();	?>
												<div class="row margin-bottom">
													<div class="col-md-12">
														<h3><?php the_title(); ?></h3>
														<?php the_content(); ?>
														<?php
													// check if the repeater field has rows of data
													if( have_rows('behandlungsbloecke') ): ?>

													 	<?php // loop through the rows of data
													    while ( have_rows('behandlungsbloecke') ) : the_row(); ?>
														    <div class="price">
<span class="text-large"><i class="fa fa-eur"></i> <?php the_sub_field('behandlungsdauer'); ?></span> / <?php the_sub_field('behandlungsdauer'); ?> <?php the_sub_field('zeiteinheit'); ?>
</div>
													   <?php endwhile; ?>

													<?php else : ?>

													    <div class="price">
														Preis auf Anfrage
													    </div>

<?php													endif;

													?>
													</div>
												</div>
											<?php endwhile; ?>
											<?php wp_reset_query(); ?>
									</div>
								</div><!-- .row -->
				   			</div><!-- .container -->
				    	</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->
				    <?php endwhile;

				endif;
			elseif( get_row_layout() == 'preisliste' ):
				$row = get_row_layout(); // Name of layout field 'name' to use as custom post type
				// check if the flexible content field has rows of data
				if( have_rows('repeater') ):

				     // loop through the rows of data
				    while ( have_rows('repeater') ) : the_row(); ?>
						<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?>">
							<div class="container">
								<div class="row">
					  				<table class="table table-striped table-hover col-md-12">
										<?php $cat = get_sub_field('taxonomie'); ?>
										<?php $args = array(
											'post_type' => 'leistungen',
											'posts_per_page' => '-1',
											'taxonomy' => $cat->slug,
											'category_name' => $cat->slug,
											'orderby' => 'title',
											'order' => 'ASC'
										); ?>
										<h2><?php echo $cat->name; ?></h2>
										<p class="lead"></p>
										<tr class="row">
											<th class="col-md-8">Behandlung</th>
											<td>
												<table>
													<th class="col-md-2">Dauer</th>
													<th class="col-md-2">Preis</th>
												</table>
											</td>
										</tr>
										<?php // echo '<pre>'; print_r($args); echo '</pre>'; ?>
											<?php $catquery = new WP_Query($args);
											while($catquery->have_posts()) : $catquery->the_post();	?>
												<tr class="row">
													<td class="col-md-8">
														<?php the_title(); ?>
													</td>
													<td class="col-md-4">
													<?php
													// check if the repeater field has rows of data
													if( have_rows('behandlungsbloecke') ): ?>
														<table>
													 	<?php // loop through the rows of data
													    while ( have_rows('behandlungsbloecke') ) : the_row(); ?>
															<tr>
																<td class="col-md-2">
														        	<?php the_sub_field('behandlungsdauer'); ?>
														        	&nbsp;
														        	<?php the_sub_field('zeiteinheit'); ?>
														        </td>
														        <td class="col-md-2">
															        <?php the_sub_field('behandlungsdauer'); ?>
															        &nbsp;
															        Euro
														        </td>
													        </tr>
													   <?php endwhile; ?>
													    </table>
													<?php else :

													    // no rows found

													endif;

													?>
													</td>
												</tr>
											<?php endwhile; ?>
											<?php wp_reset_query(); ?>
									</table>
								</div><!-- .row -->
				   			</div><!-- .container -->
				    	</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->
				    <?php endwhile;

				endif;
	        elseif( get_row_layout() == 'jumbotron' ):
			?>
			  <div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?>" style="background-image: url('<?php the_sub_field('background_image'); ?>'); background-size:cover;">
				<div class="container">
					<div class="row">
				  		<div class="col-md-12">
					  		<div class="jumbotron <?php if ( is_front_page() ) { echo 'text-right'; } else { echo 'text-center'; } ?> trans-bg">
							    <h1 <?php if ( is_front_page() ) { echo 'class="jumbotron-front-page"'; } ?>><?php the_sub_field('jumbotron_heading'); ?></h1>
							    <span <?php if ( is_front_page() ) { echo 'class="jumbotron-front-page"'; } ?>><h2><?php the_sub_field('jumbotron_subheading'); ?></h2></span>
							    <?php if (the_sub_field('jumbotron_text')): ?>
								    <?php the_sub_field('jumbotron_text'); ?>
								<?php endif; ?>
						    </div>
						</div>
			        </div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->
 			<?php elseif( get_row_layout() == 'jumbotron-ohne-hintergrund' ): ?>
			  <div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> padding-half no-bg">
				<div class="container">
					<div class="row">
				  		<div class="col-md-12">
					  		<div class="jumbotron text-center no-bg">
							    <h1><?php the_sub_field('jumbotron_heading'); ?></h1>
							    <h2><?php the_sub_field('jumbotron_subheading'); ?></h2>
							    <?php if (the_sub_field('jumbotron_text')): ?>
								    <?php the_sub_field('jumbotron_text'); ?>
								<?php endif; ?>
						    </div>
						</div>
			        </div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->
			<?php elseif( get_row_layout() == 'gallerie_3x1' ): ?>
			<?php

				$images = get_sub_field('gallerie_3x1_reihe');

				if( $images ): ?>
					<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?>">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
							    <ul class="list-unstyled">
							        <?php foreach( $images as $image ): ?>
							            <li class="col-md-4">
							                <?php /* ?><a href="<?php echo $image['url']; ?>"><?php */ ?>
							                     <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
							                <?php /* ?></a><?php */ ?>
							            </li>
							        <?php endforeach; ?>
							    </ul>
							</div>
							    </div>
					    	</div><!-- .row -->
						</div><!-- .container -->
					</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->
				<?php endif; ?>

			<?php elseif( get_row_layout() == 'gallerie' ): ?>
			<?php

				$images = get_sub_field('gallerie_reihe');

				if( $images ): ?>
					<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?>">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<div class="row">
								    <ul class="list-unstyled list-gallery">
							        <?php foreach( $images as $image ): ?>
						            <li class="col-md-4">
					                <a href="<?php echo $image['url']; ?>">
					                  <img src="<?php echo $image['sizes']['gallery-images']; ?>" alt="<?php echo $image['alt']; ?>" />
					                </a>
						            </li>
							        <?php endforeach; ?>
								    </ul>
									</div>
							  </div>
					    </div><!-- .row -->
						</div><!-- .container -->
					</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->
				<?php endif; ?>

			<?php elseif( get_row_layout() == 'text_block' ): ?>
			<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?>">
				<div class="container">
					<div class="row">
						<div class="col-md-12 <?php the_sub_field('text_center'); ?>">
				        	<h2 id="<?php strtolower(the_sub_field('text_heading')); ?>"><?php the_sub_field('text_heading'); ?></h2>
				        	<?php if( get_sub_field('text_subheading') ) { ?><p class="lead"><?php the_sub_field('text_subheading'); ?></p> <?php } ?>
				        	<?php the_sub_field('text_area'); ?>
				        </div>
		        	</div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->

			<?php elseif( get_row_layout() == 'text_block_half' ): ?>
			<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?>">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
				        	<h2 id="<?php strtolower(the_sub_field('text_heading_left')); ?>"><?php the_sub_field('text_heading_left'); ?></h2>
				        	<?php if( get_sub_field('text_subheading_left') ) { ?><p class="lead"><?php the_sub_field('text_subheading_left'); ?></p> <?php } ?>
				        	<?php the_sub_field('text_area_left'); ?>
				        </div>
				        <div class="col-md-6">
				        	<h2 id="<?php strtolower(the_sub_field('text_heading_right')); ?>"><?php the_sub_field('text_heading_right'); ?></h2>
				        	<?php if( get_sub_field('text_subheading_right') ) { ?><p class="lead"><?php the_sub_field('text_subheading_right'); ?></p> <?php } ?>
				        	<?php the_sub_field('text_area_right'); ?>
				        </div>
		        	</div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->

			<?php elseif( get_row_layout() == 'text_block_bild_rechts' ): ?>
			<?php $image = get_sub_field('bild_rechts');  ?>
			<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?>">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
				        		<div class="row <?php the_sub_field('vertical_align'); ?> <?php the_sub_field('horizontal_align'); ?>">
					        		<div class="col-md-8">
					        			<?php if( get_sub_field('text_heading') ) { ?><h2 id="<?php strtolower(the_sub_field('text_heading')); ?>"><?php the_sub_field('text_heading'); ?></h2> <?php } ?>
				        				<?php if( get_sub_field('text_subheading') ) { ?><p class="lead"><?php the_sub_field('text_subheading'); ?></p> <?php } ?>
					        			<?php the_sub_field('text_area'); ?>
								</div><!-- .col-md-8 -->
					   		     	<div class="col-md-4">
					        			<?php /* ?><a href="<?php echo $image['url']; ?>"><?php */ ?>
					        			<div class="text-center">
					                   			 <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" class="img-thumbnail" />
					                		</div>
					                	<?php /* ?></a><?php */ ?>
								</div><!-- .col-md-4 -->
					        	</div><!-- .row .vertical-align -->
						</div><!-- .col-md-12 -->
			        	</div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->
			<?php elseif( get_row_layout() == 'text_block_bild_links' ): ?>
			<?php $image = get_sub_field('bild_links');  ?>
			<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?>">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
				        	<div class="row <?php the_sub_field('vertical_align'); ?> <?php the_sub_field('horizontal_align'); ?>">
					        	<div class="col-md-8 col-md-push-4">
					        		<?php if( get_sub_field('text_heading') ) { ?><h2 id="<?php strtolower(the_sub_field('text_heading')); ?>"><?php the_sub_field('text_heading'); ?></h2> <?php } ?>
				        			<?php if( get_sub_field('text_subheading') ) { ?><p class="lead"><?php the_sub_field('text_subheading'); ?></p> <?php } ?>
					     	   		<?php the_sub_field('text_area'); ?>
					        	</div>
										<div class="col-md-4 col-md-pull-8">
			                <?php /* ?><a href="<?php echo $image['url']; ?>"><?php */ ?>
			                <div class="text-center">
			                  <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" class="img-thumbnail" />
			                </div>
			                <?php /* ?></a><?php */ ?>
			              </div>
					        </div>
				        </div>
		        	</div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->


			<?php elseif( get_row_layout() == 'embed_block' ): ?>

			<?php

        function ytLink($subfield) {
        	$iframe = get_sub_field($subfield);

					// use preg_match to find iframe src
					preg_match('/src="(.+?)"/', $iframe, $matches);
					$src = $matches[1];


					// add extra params to iframe src
					$params = array(
					    'modestbranding' => 1,
					    'controls'    => 0,
					    'hd'        => 1,
					    'autohide'    => 1,
					    'rel' => 0,
					    'showinfo' => 0,
					    'iv_load_policy' => 3,
					);

					$new_src = add_query_arg($params, $src);

					$iframe = str_replace($src, $new_src, $iframe);


					// add extra attributes to iframe html
					$attributes = 'frameborder="0"';

					$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

					return $iframe;
				}

			?>

			<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> embed-block">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
		        	<div class="row <?php the_sub_field('vertical_align'); ?> <?php the_sub_field('horizontal_align'); ?>">
			        	<div class="col-md-12">
			        		<?php if( get_sub_field('text_heading') ) { ?><h2 id="<?php strtolower(the_sub_field('text_heading')); ?>"><?php the_sub_field('text_heading'); ?></h2> <?php } ?>
		        			<?php if( get_sub_field('text_subheading') ) { ?><p class="lead"><?php the_sub_field('text_subheading'); ?></p> <?php } ?>
			     	   		<?php the_sub_field('text_area'); ?>
			        	</div>
			       	</div>
			       	<div class="row">
									<?php
										// check if the repeater field has rows of data
										if( have_rows('oembed_repeater') ):

											$iframe = get_sub_field('oembed');
										 ?>
											<ul class="list-unstyled">
										 	<?php // loop through the rows of data
										    while ( have_rows('oembed_repeater') ) : the_row(); ?>
													<li class="col-md-4">
						                <div class="embed-container">
															<?php echo ytLink('oembed'); ?>
						                </div>
											    </li>
										  <?php endwhile; ?>
										  </ul>
										<?php else :

										    // no rows found

										endif;
									?>
			        </div>
		        </div>
        	</div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->


			<?php elseif( get_row_layout() == 'teaser_block' ): ?>
			<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> full-width-bg">
				<div class="container">
					<div class="row">
						<div class="teaser col-md-12 text-center">
				        	<h2 class="inline-block"><strong><?php the_sub_field('heading'); ?>&nbsp;-&nbsp;</strong></h2><p class="lead inline-block"><?php the_sub_field('subheading'); ?></p>
				        	<span class="block"><a href="<?php the_sub_field('button'); ?>" class="btn-primary btn btn-lg">Jetzt anschauen</a></span>
				        </div>
				    </div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->
			<?php elseif( get_row_layout() == 'themenbereiche' ): ?>
			<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> full-width-bg">
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center">
							<h2 id="<?php strtolower(the_sub_field('leistungen_heading')); ?>"><?php the_sub_field('leistungen_heading'); ?></h2>
							<p class="lead"><?php the_sub_field('leistungen_subheading'); ?></p>
							<div class="row">
				        	<?php // check if the nested repeater field has rows of data
				        	if( have_rows('leistungen') ):

							 	echo '<ul class="list-unstyled">';

							 	// loop through the rows of data
							    while ( have_rows('leistungen') ) : the_row(); ?>
									<?php $image = get_sub_field('image');  ?>
									<li class="col-md-4 img-li text-center">
										<a href="<?php the_sub_field('links'); ?>">
											<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
											<span class="block img-capture"><?php the_sub_field('heading'); ?></span>
										</a>
									</li>

								<?php endwhile;

								echo '</ul>';
							endif; ?>
							</div>
						</div>
					</div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->


			<?php elseif( get_row_layout() == 'team' ): ?>
			<?php $image = get_sub_field('bild');  ?>
			<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?>">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
				        	<div class="row vertical-align team">
					        	<div class="col-md-4">
					        		<?php /* ?><a href="<?php echo $image['url']; ?>"><?php */ ?>
					        		<div class="text-center">
					                    <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" class="img-thumbnail team" />
					                </div>
					                <?php /* ?></a><?php */ ?>
					            </div>
					        	<div class="col-md-8">
					        		<h2><?php the_sub_field('name'); ?></h2>
				        			<?php if( get_sub_field('aufgabenbereiche') ) { ?><p class="lead"><?php the_sub_field('aufgabenbereiche'); ?></p> <?php } ?>
					     	   		<?php if( get_sub_field('biographie') ) { ?><?php the_sub_field('biographie'); ?> <?php } ?>
					     	   		<?php /* ?><p><a href="tel:<?php the_sub_field('telefonnummer'); ?>"><i class="glyphicon glyphicon-phone"></i> <?php the_sub_field('telefonnummer'); ?></a></p><?php */ ?>
					     	   		<p><a href="mailto:<?php the_sub_field('email_adresse'); ?>"><i class="fa fa-envelope-o"></i> <?php the_sub_field('email_adresse'); ?></a></p>
					        	</div>
					        </div>
				        </div>
		        	</div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->


			<?php elseif( get_row_layout() == 'kurse' ): ?>



							<?php $row = get_row_layout(); // Name of layout field 'name' to use as custom post type ?>
							<?php $cat = get_sub_field('kurskategorie'); ?>
							<?php $args = array(
								'post_type' => $row,
								'posts_per_page' => '-1',
								'taxonomy' => $cat->slug,
								'category_name' => $cat->slug,
								'orderby' => 'title',
								'order' => 'ASC'
							); ?>
								<?php $catquery = new WP_Query($args);
								while($catquery->have_posts()) : $catquery->the_post();	?>
								<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?>">
									<div class="container">
										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-12">
														<h2><?php the_field('kursname'); ?></h2>
														<h3>Kursbeschreibung</h3>
														<?php the_field('kursbeschreibung'); ?>
														<h3>Kursdetails</h3>
														<table class="table table-striped">
															<tbody>
																<tr>
																	<td class="col-md-4">Maximale Teilnehmeranzahl</td>
																	<td class="col-md-8"><?php the_field('kursteilnehmer'); ?></td>
																</tr>
																<tr>
																	<td class="col-md-4">Veranstaltungsort</td>
																	<td class="col-md-8"><?php the_field('kursort'); ?></td>
																</tr>
																<tr>
																	<td class="col-md-4">Kosten</td>
																	<td class="col-md-8"><?php the_field('kurskosten'); ?></td>
																</tr>
																<tr>
																	<td class="col-md-4">Kursdaten</td>
																	<td class="col-md-8"><?php the_field('kursdaten'); ?></td>
																</tr>
																<tr>
																	<td class="col-md-4">Anmeldung unter</td>
																	<td class="col-md-8"><?php the_field('kursanmeldung'); ?></td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
							        	</div><!-- .row -->
									</div><!-- .container -->
								</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->
								<?php endwhile; ?>
								<?php wp_reset_query(); ?>






			<?php elseif( get_row_layout() == 'map' ): ?>
			<div class="container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?>">
				<div class="container">
					<div class="row vertical-align text-center align-center">
						<?php

						$location = get_sub_field('google_map');

						if( !empty($location) ):
						?>
						<div class="col-md-8">
							<div class="acf-map">
								<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
							</div>
						</div>
						<?php endif; ?>

						<div class="col-md-4">
							<div class="contact">
								<span class="block"><i class="fa <?php the_sub_field('icon_location'); ?>"></i></span>
								<span class="block"><?php the_sub_field('firma'); ?></span>
								<span class="block"><?php the_sub_field('strasse'); ?> <?php the_sub_field('hausnummer'); ?></span>
								<span class="block"><?php the_sub_field('postleitzahl'); ?> <?php the_sub_field('ort'); ?></span>
							</div>
							<div class="contact">
								<span class="block"><i class="fa <?php the_sub_field('icon_offnungszeiten'); ?>"></i></span>
								<?php

								if( have_rows('offnungszeiten') ):




											 	// loop through the rows of data
											    while ( have_rows('offnungszeiten') ) : the_row();

													$field_name = "field_54359f4c7c6ba";
													$field = get_field_object($field_name);
													echo '<span class="block"><strong>' . $field['label'] . '</strong></span>';
													echo '<span class="block">' . the_sub_field('montag_bis_donnerstag') . '</span>';

													$field_name2 = "field_54359f5d7c6bb";
													$field2 = get_field_object($field_name2);
													echo '<span class="block"><strong>' . $field2['label'] . '</strong></span>';
													echo '<span class="block">' . the_sub_field('freitag') . '</span>';

												endwhile;

											endif;

								?>
							</div>
							<div class="contact">
								<span class="block"><i class="fa <?php the_sub_field('icon_kontakt'); ?>"></i></span>
								<span class="block"><a href="tel:<?php the_sub_field('telefonnummer'); ?>"><?php the_sub_field('telefonnummer'); ?></a></span>
								<span class="block"><?php the_sub_field('faxnummer'); ?></span>
								<span class="block"><a href="mailto:<?php the_sub_field('e_mail_adresse'); ?>"><?php the_sub_field('e_mail_adresse'); ?></a></span>
							</div>
						</div>
					</div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .container-full <?php if ( is_front_page() ) { echo "full-padding"; } ?> -->

	    <?php endif; ?>

	    	<?php the_field('behandlungsbloecke'); ?>


	    <?php endwhile;

	else :

	    // no layouts found
	    get_template_part( 'content', 'page' );

		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() )
			comments_template();

	endif; ?>

<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>
