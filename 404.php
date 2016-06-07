<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @author Matthias Thom | http://upplex.de
 * @package upBootWP 1.1
 */

get_header(); ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<section class="error-404 not-found">
					<header class="page-header">
						<h1 class="page-title">Huch, diese Seite existiert gar nicht.</h1>
					</header><!-- .page-header -->
					<div class="page-content">
						<p>Sieht aus, als hättest du dich verlaufen.</p>
						<p>Du solltest zur <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Startseite</a> zurückkehren.</p>
					</div><!-- .page-content -->
				</section><!-- .error-404 -->
			</div><!-- .col-md-12 -->
		</div><!-- .row -->
	</div><!-- .container -->
<?php get_footer(); ?>
