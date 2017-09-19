<?php
/**
* @package   yoo_master2
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get theme configuration
include($this['path']->path('layouts:theme.config.php'));

?>
<!DOCTYPE HTML>
<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>"  data-config='<?php echo $this['config']->get('body_config','{}'); ?>'>

<head>
<?php echo $this['template']->render('head'); ?>
</head>

<body class="<?php echo $this['config']->get('body_classes'); ?>">



	

	
	

	<div id="tm-toolbar" class="tm-block tm-toolbar-bg">
		<div class="uk-container uk-container-center">
		<?php if ($this['widgets']->count('toolbar-l + toolbar-r')) : ?>
		<div class="tm-toolbar uk-clearfix uk-hidden-small">

		
		
			<?php if ($this['widgets']->count('toolbar-l')) : ?>
			<div class="uk-float-left"><?php echo $this['widgets']->render('toolbar-l'); ?></div>
			<?php endif; ?>

			<?php if ($this['widgets']->count('toolbar-r')) : ?>
			<div class="uk-float-right"><?php echo $this['widgets']->render('toolbar-r'); ?></div>
			<?php endif; ?>

		</div>
		<?php endif; ?>
		</div>
	</div>
	




	
	
	<div id="tm-headerbar" class="tm-block tm-headerbar-bg" >
		<div class="uk-container uk-container-center">	
		<?php if ($this['widgets']->count('logo + headerbar')) : ?>
		<div class="tm-headerbar uk-clearfix uk-hidden-small">

			<?php if ($this['widgets']->count('logo')) : ?>
			<a class="tm-logo" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['widgets']->render('logo'); ?></a>
			<?php endif; ?>

		

		</div>
		<?php endif; ?>

		<?php if ($this['widgets']->count('menu + search')) : ?>
		<nav class="tm-navbar uk-navbar">
		
		

			<?php if ($this['widgets']->count('menu')) : ?>
			<?php echo $this['widgets']->render('menu'); ?>
			<?php endif; ?>

			<?php if ($this['widgets']->count('offcanvas')) : ?>
			<a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
			<?php endif; ?>
			

			

			<?php if ($this['widgets']->count('search')) : ?>
			<div class="uk-navbar-flip">
				<div class="uk-navbar-content uk-hidden-small"><?php echo $this['widgets']->render('search'); ?></div>
			</div>
			<?php endif; ?>

			<?php if ($this['widgets']->count('logo-small')) : ?>
			<div class="uk-navbar-content uk-navbar-center uk-visible-small"><a class="tm-logo-small" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['widgets']->render('logo-small'); ?></a></div>
			<?php endif; ?>

		</nav>
		<?php endif; ?>
		</div>
	</div>
	
	<?php if ($this['widgets']->count('slideshow')) : ?>
	<div id="slideshow" class="tm-block tm-block-slideshow" >
		<section class="<?php echo $grid_classes['slideshow']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('slideshow', array('layout'=>$this['config']->get('grid.slideshow.layout'))); ?></section>
	</div>
	<?php endif; ?>
	
	
	<?php if ($this['widgets']->count('top-a')) : ?>	
	<div id="tm-top-a" class="tm-block tm-block-top-a">
		<div class="uk-container uk-container-center">	
		<section class="<?php echo $grid_classes['top-a']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('top-a', array('layout'=>$this['config']->get('grid.top-a.layout'))); ?></section>
		</div>
	</div>
	<?php endif; ?>


	<?php if ($this['widgets']->count('top-b')) : ?>
	<div id="tm-top-b" class="tm-block tm-block-top-b">
		<div class="uk-container uk-container-center">
		<section class="<?php echo $grid_classes['top-b']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('top-b', array('layout'=>$this['config']->get('grid.top-b.layout'))); ?></section>
		</div>
	</div>
	<?php endif; ?>
     
	<?php if ($this['widgets']->count('main-top + main-bottom + sidebar-a + sidebar-b') || $this['config']->get('system_output', true)) : ?>
	<div id="tm-middle" class="tm-block tm-block-middle wow fadeIn">
		<div class="uk-container uk-container-center">
			<div class="tm-middle uk-grid" data-uk-grid-match data-uk-grid-margin>

				<?php if ($this['widgets']->count('main-top + main-bottom') || $this['config']->get('system_output', true)) : ?>
				
				<div class="<?php echo $columns['main']['class'] ?>">

					<?php if ($this['widgets']->count('main-top')) : ?>
					<section class="<?php echo $grid_classes['main-top']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('main-top', array('layout'=>$this['config']->get('grid.main-top.layout'))); ?></section>
					
					<?php endif; ?>

					<?php if ($this['config']->get('system_output', true)) : ?>
					<main class="tm-content">

						<?php if ($this['widgets']->count('breadcrumbs')) : ?>
						<?php echo $this['widgets']->render('breadcrumbs'); ?>
						<?php endif; ?>

						<?php echo $this['template']->render('content'); ?>

					</main>
					<?php endif; ?>

					<?php if ($this['widgets']->count('main-bottom')) : ?>
					<section class="<?php echo $grid_classes['main-bottom']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('main-bottom', array('layout'=>$this['config']->get('grid.main-bottom.layout'))); ?></section>
					<?php endif; ?>

				</div>
				<?php endif; ?>

				<?php foreach($columns as $name => &$column) : ?>
				<?php if ($name != 'main' && $this['widgets']->count($name)) : ?>
				<aside class="<?php echo $column['class'] ?>"><?php echo $this['widgets']->render($name) ?></aside>
				<?php endif ?>
				<?php endforeach ?>

			</div>
		</div>
	</div>
	<?php endif; ?>	
	
	
			<?php if ($this['widgets']->count('bottom-a1')) : ?>	
	<div id="tm-bottom-a1" class="tm-block tm-block-bottom-a1">	
	
			<section class="<?php echo $grid_classes['bottom-a1']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-a1', array('layout'=>$this['config']->get('grid.bottom-a1.layout'))); ?></section>
		
	</div>
	<?php endif; ?>

	<?php if ($this['widgets']->count('bottom-a')) : ?>	
	<div id="tm-bottom-a" class="tm-block tm-block-bottom-a">
		<div class="uk-container uk-container-center">
			<section class="<?php echo $grid_classes['bottom-a']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-a', array('layout'=>$this['config']->get('grid.bottom-a.layout'))); ?></section>
		</div>
	</div>
	<?php endif; ?>

	<?php if ($this['widgets']->count('bottom-b')) : ?>	
    <div id="tm-bottom-b" class="tm-block tm-block-bottom-b">
		<div class="uk-container uk-container-center">
			<section class="<?php echo $grid_classes['bottom-b']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-b', array('layout'=>$this['config']->get('grid.bottom-b.layout'))); ?></section>
		</div>
	</div>
	<?php endif; ?>
	
		<?php if ($this['widgets']->count('bottom-c')) : ?>	
	<div id="tm-bottom-c" class="tm-block tm-block-bottom-c">
		<div class="uk-container uk-container-center">
			<section class="<?php echo $grid_classes['bottom-c']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-c', array('layout'=>$this['config']->get('grid.bottom-c.layout'))); ?></section>
		</div>
	</div>
	<?php endif; ?>

	<?php if ($this['widgets']->count('bottom-d')) : ?>	
    <div id="tm-bottom-d" class="tm-block tm-block-bottom-d">
		<div class="uk-container uk-container-center">
			<section class="<?php echo $grid_classes['bottom-d']; ?>" data-uk-grid-match="{target:'> div > .uk-panel'}" data-uk-grid-margin><?php echo $this['widgets']->render('bottom-d', array('layout'=>$this['config']->get('grid.bottom-d.layout'))); ?></section>
		</div>
	</div>
	<?php endif; ?>

	<?php if ($this['widgets']->count('footer + debug') || $this['config']->get('warp_branding', true) || $this['config']->get('totop_scroller', true)) : ?>	
    <div class="tm-block tm-block-footer fadeIn">
		<div class="uk-container uk-container-center">
		
			<footer class="tm-footer">

				<?php if ($this['config']->get('totop_scroller', true)) : ?>
				<a class="tm-totop-scroller" data-uk-smooth-scroll href="#"></a>
				<?php endif; ?>

				<?php
					echo $this['widgets']->render('footer');
					$this->output('warp_branding');
					echo $this['widgets']->render('debug');
				?>

			<?php if ($this['config']->get('wk_branding', true)) : ?>
              <a class="wklogo" title="Template by Web Komp" target="_blank" href="http://web-komp.eu/"></a>
			<?php endif; ?>
			
			</footer>

		</div>
	</div>
	<?php endif; ?>
		
	<?php echo $this->render('footer'); ?>

	<?php if ($this['widgets']->count('offcanvas')) : ?>
	<div id="offcanvas" class="uk-offcanvas">
		<div class="uk-offcanvas-bar"><?php echo $this['widgets']->render('offcanvas'); ?></div>
	</div>
	<?php endif; ?>


		

<script>
		wow = new WOW(
		  {
			animateClass: 'animated',
			offset:       100
		  }
		);
		wow.init();		
		
		$(window).scroll(function() {
			if ($(this).scrollTop() > 3){  
				$('').addClass("");
			}
			
		});			
    </script>	
</body>
</html>