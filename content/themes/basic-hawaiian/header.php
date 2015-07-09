<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Basic Hawaiian
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.png?v=05212015" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

		<?php if ( ! is_user_logged_in() ) : ?>

			<nav id="site-navigation" class="main-navigation navbar navbar-default" role="navigation">
				<div class="container-fluid">

					<div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
						<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/images/logo-new-test.png'?>" alt="Basic Hawaiian Logo" /></a>
			    </div>
					<div class="collapse navbar-collapse">
						<!-- Sign In & Up -->
						<a type="button" id="sign-in" class="btn btn-primary navbar-btn" href="<?php echo get_home_url(); ?>/sign-up">Sign Up</a>
						<!-- Button trigger modal -->
						<button type="button" id="sign-up" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#myModal">Sign In</button>
						<!-- Public Navigation -->
						<?php
							wp_nav_menu(array(
								'theme_location' => 'public-menu',
								'container'			 => false,
								'items_wrap'		 => '<ul id="%1$s" class="%2$s nav navbar-nav navbar-right">%3$s</ul>'
							));
						?>
					</div>
				</div><!-- .container-fluid -->
			</nav>

		<?php else : ?>

			<nav id="site-navigation" class="site-header" role="banner">

				<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/images/logo-new.png'?>" alt="Basic Hawaiian Logo" /></a>
				<a class="user-link" href="<?php echo get_admin_url('','profile.php'); ?>">
					<?php $author_id = get_current_user_id(); ?>
					<div class="image-container"><?php echo get_avatar( $author_id ); ?></div>
					<p><?php the_author_meta('nickname', $author_id); ?></p>
				</a>
				<!--<div class="user-achievements">
		        <div class="currency-balance flower">0</div>-->
				<!-- Navigation -->
					<a data-toggle="drawer" class="drawer-closed" href="#"><i class="fa fa-bars"></i></a>
					<ul class="drawer nav-sidebar">
						<!--<li><a class="edit-profile" href="<?php echo get_edit_user_link(); ?>"><i class="fa fa-edit"></i>Edit your profile</a></li>-->
						<?php if ( current_user_can('edit_posts') ) // Reset only for those who can edit the site ?>
						<li><a href="mailto:info@basichawaiian.com" class="get-support">Get Support<i class="fa fa-question-circle"></i></a></li>
						<li><a href="#" class="reset-scores">Reset Score<i class="fa fa-times-circle-o"></i></a></li>
						<li><a href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout">Logout<i class="fa fa-sign-out"></i></a></li>
					</ul>
			</nav><!-- #masthead -->

		<?php endif; ?>
