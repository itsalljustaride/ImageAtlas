<?php
/**
 * Image Atlas Controller
 */
class ImageAtlas_AtlasController extends Omeka_Controller_AbstractActionController
{
    /**
     * Initialization.
     */
    public function init()
    {
    }

    public function indexAction()
    {
      $this->view->params = $this->_request->getParams();
		$this->view->collections = $this->_helper->db->getTable('Collection')->findAll();
    }

    public function kmlAction()
    {      
      $this->_setParam('only_map_items', true);
      $this->_setParam('use_map_per_page', true);
      
      $this->view->addHelperPath(GEOLOCATION_PLUGIN_DIR . '/helpers', 'Geolocation_View_Helper_');
      $table = $this->_helper->db->getTable('Location');
      
      $params = $this->getAllParams();
      $currentPage = $this->getParam('page', 1);
      $limit = (int)25;
      $params['only_map_items'] = true;
      $items = $table->findItemsBy($params, $limit, $currentPage);
      
      $this->view->items = $items;
      $this->view->locations = $table->findLocationByItem($items);
      $this->view->totalItems = $table->countItemsBy($params);
      
      $params = array('page'  => $currentPage,
              'per_page'      => $limit,
              'total_results' => $this->view->totalItems);
      
      Zend_Registry::set('map_params', $params);
      
      // Make the pagination values accessible from pagination_links().
      Zend_Registry::set('pagination', $params);
    }
	 
    public function staticAction()
    {
      $lines = explode("\n", "title,longitude,latitude,altitude\n".get_option('image_atlas_settings_default_points'));
      $head = str_getcsv(array_shift($lines));

      $array = array();
      foreach ($lines as $line) {
         $array[] = array_combine($head, str_getcsv($line));
      }

      $this->view->default_locations = $array;
    }
	 
	 public function networkLinksAction(){
		$this->view->search_params = "";
	 }
}
