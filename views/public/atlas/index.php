<?php
/**
 * The public view for the Image Atlas.
 */
 
$head = array('bodyclass' => 'image-atlas items show',
              'title' => html_escape(__('View Image Atlas')));
echo head($head);
?>

<h1><?php echo __('Image Atlas'); ?></h1>

<div id="primary">
	<span id="map3d"></span>
</div>

<aside id="sidebar">
	<nav class="items-nav navigation secondary-nav" id="browsenav">
		<ul class="navigation">
			<li><a>Browse Images By:</a>
		        <ul>
		        <li class="submenu"><a>Theme</a>
		                <ul>
								<?php 
									foreach (loop('collections') as $collections):
								?>
	                      <li class="submenu"><a href="javascript:void(0)" onclick="setKML('theme',<?php echo metadata('collection', 'id'); ?>, '<?php echo metadata('collection', array('Dublin Core', 'Title')); ?>');"><?php echo metadata('collection', array('Dublin Core', 'Title')); ?></a></li>
								<?php endforeach; ?>
	                  </ul>
	          </li>
	          <li class="submenu"><a>Time period</a>
	                  <ul>
								<?php
								$db = get_db();
								$timeperiods = $db->getTable('ElementText')->findBy(array('element_id'=>58));
								preg_match_all("/{([^}]*)}/" , implode(",", $timeperiods), $result);
								$periods = array_unique($result[0]);
								sort($periods);
								foreach($periods as $period): ?>
								<li><a href="javascript:void(0)" onclick="setKML('time','<?php echo $period ?>','<?php echo str_replace(array('{', '}'),"",$period) ?>');"><?php echo str_replace(array('{', '}'),"",$period) ?></a></li>
								<?php endforeach; ?>
	                  </ul>
	          </li>
	          </ul>
	  	</li>
	 	</ul>
	</nav>
	
	<div id="atlas-item-info" class="element">
		<p>This box will contain the contents of the placemark.</p>
	</div>
	<div id="atlas-filter-info" class="element">
		<h3>Current Search Set</h3>
		<p>This box will contain the current search info.</p>
	</div>
</aside>

<?php echo foot(); ?>
