<?php
/**
 * @package ImageAtlas
 * @copyright Copyright 2013, Johnathon Beals
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GPLv3 or any later version
 */

class ImageAtlasPlugin extends Omeka_Plugin_AbstractPlugin
{
	protected $_hooks = array(
				'initialize',
				'admin_head', 
				'public_head',
	   		'config', 
				'config_form', 
				'install', 
				'uninstall',
				'upgrade',
				'define_routes',
				'public_items_show'
			);

	protected $_filters = array(
		      'response_contexts',
		      'action_contexts',
  				'public_navigation_main'	
			);

	public function hookInstall()
	{
		set_option('image_atlas_settings_gmaps_api_key', '');
		set_option('image_atlas_settings_default_points', '');
		set_option('image_atlas_settings_slug', 'image-atlas');
		set_option('image_atlas_settings_display_nav_item', true);
	}

	public function hookUninstall()
	{
		delete_option('image_atlas_settings_gmaps_api_key');
		delete_option('image_atlas_settings_default_points');
		delete_option('image_atlas_settings_slug');
		delete_option('image_atlas_settings_display_nav_item');
	}

	public function hookUpgrade($args)
	{
	}

	public function hookInitialize()
	{
		add_filter('define_action_contexts', 'media_kml_action_context');
 
		function media_kml_action_context($context, $controller)
		{
		    if ($controller instanceof ImageAtlas_AtlasController) {
		        $context['kml'][] = 'kml';
		    }
 
		    return $context;
		}
		
		add_filter('define_response_contexts', 'media_kml_response_context');
 
		function media_kml_response_context($context)
		{
		    $context['kml'] = array('suffix'  => 'kml', 
		                            'headers' => array('Content-Type' => 'text/kml'));
 
		    return $context;
		}
	}

	public function hookConfigForm()
	{
	  include 'config-form.php';	  
	}

	public function hookConfig()
	{		
		set_option('image_atlas_settings_gmaps_api_key', $_POST['image_atlas_settings_gmaps_api_key']);
		set_option('image_atlas_settings_default_points', $_POST['image_atlas_settings_default_points']);
		set_option('image_atlas_settings_slug', $_POST['image_atlas_settings_slug']);
		set_option('image_atlas_settings_display_nav_item', $_POST['image_atlas_settings_display_nav_item']);
	}

	public function hookAdminHead()
	{
	  $this->_head();
	}

	public function hookPublicHead()
	{
	  $this->_head();
	}
	
	public function filterPublicNavigationMain($nav)
  {
      $nav[] = array(
                      'label' => __('Image Atlas'),
                      'uri' => url(get_option('image_atlas_settings_slug'))
                    );
      return $nav;
  }
	
   public function hookDefineRoutes($args)
   {
       $router = $args['router'];
       
       $atlasRoute = new Zend_Controller_Router_Route(get_option('image_atlas_settings_slug'),
                       array('controller' => 'atlas',
                               'action' => 'index',
                               'module' => 'image-atlas'));
       $router->addRoute('image_atlas_atlas', $atlasRoute);        
       
       $atlasKMLRoute = new Zend_Controller_Router_Route(get_option('image_atlas_settings_slug').'/kml',
                       array('controller' => 'atlas',
                               'action' => 'kml',
                               'module' => 'image-atlas',
                               'output' => 'kml'));
       $router->addRoute('image_atlas_kml', $atlasKMLRoute);
		 
       $staticKMLRoute = new Zend_Controller_Router_Route(get_option('image_atlas_settings_slug').'/static',
                       array('controller' => 'atlas',
                               'action' => 'static',
                               'module' => 'image-atlas',
                               'output' => 'kml'));
       $router->addRoute('image_atlas_static', $staticKMLRoute);  
		 
       $netlinksKMLRoute = new Zend_Controller_Router_Route(get_option('image_atlas_settings_slug').'/network-links',
                       array('controller' => 'atlas',
                               'action' => 'network-links',
                               'module' => 'image-atlas',
                               'output' => 'kml'));
       $router->addRoute('image_atlas_netlinks', $netlinksKMLRoute);              
   }

	private function _head()
	{
		queue_css_file('atlasstyle');
		queue_css_file('dropdown');
		
		queue_js_url('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
		queue_js_url('//www.google.com/jsapi?key='.get_option('image_atlas_settings_gmaps_api_key'));
		queue_js_file('functions');
	}
	
   public function filterResponseContexts($contexts)
   {
       $contexts['kml'] = array('suffix'  => 'kml',
               'headers' => array('Content-Type' => 'text/xml'));
       return $contexts;        
   }
   
   public function filterActionContexts($contexts, $args)
   {
       $controller = $args['controller'];
       if ($controller instanceof ImageAtlas_AtlasController) {
           $contexts['kml'] = array('kml');
           $contexts['static'] = array('kml');
           $contexts['network-links'] = array('kml');
       }
       return $contexts;        
   }
	
	public function hookPublicItemsShow($args) {
      $view = $args['view'];
      $item = $args['item'];
      $location = $this->_db->getTable('Location')->findLocationByItem($item, true);

      if ($location) {
	      $html = "<div id='view_item_in_image_atlas'>";
	      $html .= '<h2>Image Atlas</h2>';
	      $html .= link_to('image-atlas','index','View this item in the Image Atlas',array(),array('collection'=>get_collection_for_item($item)->id, 'item'=>$item->id, 'atlasSearchType'=>'single', 'singleRecord'=>1));
	      $html .= "</div>";
	      echo $html;
		}
	}
	    
}
