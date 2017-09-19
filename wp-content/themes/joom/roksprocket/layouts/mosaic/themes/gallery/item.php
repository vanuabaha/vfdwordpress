<?php
/**
 * @version   $Id: item.php 18937 2014-02-21 22:54:29Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2015 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * @var $item RokSprocket_Item
 */
?>
<li<?php echo strlen($item->custom_tags) ? ' class="'.$item->custom_tags.'"' : ''; ?> data-mosaic-item>
	<div class="sprocket-mosaic-g-item<?php if (!$item->getPrimaryImage()) :?> panel-color<?php endif; ?>" data-mosaic-content>
		<?php echo $item->custom_ordering_items; ?>
		<?php if ($item->getPrimaryImage()) :?>
		<div class="sprocket-mosaic-g-image-container ">
			<img src="<?php echo $item->getPrimaryImage()->getSource(); ?>" alt="<?php echo $item->getPrimaryImage()->getAlttext(); ?>" class="sprocket-mosaic-g-image " />
			<?php if ($item->getTitle() or $item->getPrimaryLink() or $item->getText()): ?>
			<div class="sprocket-mosaic-g-effect uk-overlay-spin"></div>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<div class="sprocket-mosaic-g-content<?php if ($item->getPrimaryImage()) :?> overlay-mode<?php endif; ?>">
				<?php if ($item->getTitle()): ?>
				<h2 class="sprocket-mosaic-g-title uk-text-center uk-hidden-small">
					<?php if ($item->getPrimaryLink()): ?><a href="<?php echo $item->getPrimaryLink()->getUrl(); ?>"><?php endif; ?>
						<?php echo $item->getTitle();?>
					<?php if ($item->getPrimaryLink()): ?></a><?php endif; ?>
				</h2>
				<?php endif; ?>

	            <div class="uk-flex uk-flex-center uk-margin-top">
		            <?php if ($item->getPrimaryLink()) : ?>
					<a href="<?php echo $item->getPrimaryLink()->getUrl(); ?>" class="uk-icon-hover uk-icon-mail-forward     uk-icon-small uk-margin-right"></a>
					<?php endif; ?>

		            <?php if ($item->getPrimaryLink()) : ?>
					<a href="<?php echo $item->getPrimaryImage()->getSource(); ?>" class="uk-icon-hover uk-icon-search-plus uk-icon-small" data-uk-lightbox="{group:'All'}"></a>
					<?php endif; ?>
				</div>

		</div>
	</div>
</li>
