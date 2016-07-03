<?php
class ControllerModuleCategory extends Controller {
	public function index() {
		$this->load->language('module/category');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

//		if (isset($parts[0])) {
//			$data['category_id'] = $parts[0];
//		} else {
//			$data['category_id'] = 0;
//		}
//
//		if (isset($parts[1])) {
//			$data['child_id'] = $parts[1];
//		} else {
//			$data['child_id'] = 0;
//		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

//		$data['categories'] = array();

//		$categories = $this->model_catalog_category->getCategories(0);

		$categs = $this->getCategRecursive(0, $parts);


//		var_export($categs); die;
		$data['categories'] = $categs; //$this->getChildCategoriesRecursive($categories);


//		var_export($data); die;

		return $this->load->view('module/category', $data);
	}

//	protected function getChildCategoriesRecursive($categories)
//	{
//		foreach ($categories as $category) {
//
//			$filter_data = array(
//				'filter_category_id' => $category['category_id'],
//				'filter_sub_category' => true
//			);
//
//			$data[$category['category_id']] = array(
//				'category_id' => $category['category_id'],
//				'name' => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
////				'children' => $children_data,
//				'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
//			);
//
//			$children = $this->model_catalog_category->getCategories($category['category_id']);
//
//			if (!empty($children)) {
////				foreach ($children as $child) {
//					$data[$category['category_id']]['children'] = $this->getChildCategoriesRecursive($children);
////					$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);
////					$children_data[] = array(
////						'category_id' => $child['category_id'],
////						'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
////						'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
////					);
////				}
//			} else {
//				$data[$category['category_id']]['children'] = array();
//			}
//		}
//
//		return $data;
//	}

	public function getCategRecursive($parentId, $selected, $parentParentId = 0, $rootPath = array())
	{
		$data = '';
		$categories = $this->model_catalog_category->getCategories($parentId);
		$opened = false;
		$class = '';
		if (in_array($parentId, $selected)) {
			$opened = true;
		}
		$id = 'accordion' . $parentId;
		if (!empty($categories) && $parentId > 0 ) {
			$accContent = '<div class="accordion-heading pull-left">
							<span class="bg" data-target="#accordion' . $parentId . '"
							data-parent="#accordion' . $parentParentId . '" data-toggle="collapse" aria-expanded="true">
							<i class="fa fa-angle-'. ($opened ? 'down': 'right') .'"></i></span></div>';
			$data .= $accContent;
			$parentParentId = $parentId;
		}
		if ($opened) {
			$class .= 'collapse in';
		} elseif ($parentId == 0) {
			$class .= 'list-group';
		} else {
			$class .= 'collapse';
		}

		$data .= '<ul id="' . $id . '" class="'.$class.'">';
		if ($parentId != 0) {
			$rootPath[] = $parentId;
		}
		foreach ($categories as $category) {
			$path = implode('_', $rootPath) . (empty($rootPath) ? '' : '_') . $category['category_id'];
			$aClass = '';
			if (in_array($category['category_id'], $selected)) {
				$aClass = 'active';
			}
			$url = $this->url->link('product/category', 'path=' . $path);
			$data .= '<li id="collapsable'. $category['category_id'] .'" class="panel no-border-bottom '. ( $parentId == 0 ? 'list-group-item accordion-group ' : 'small-arrow') . '">';

			$data .= '<a href="' . $url . '" class="'. $aClass .'">' . $category['name'] . '</a>';
			$data .= $this->getCategRecursive($category['category_id'], $selected, $parentParentId, $rootPath);
			$data .= '</li>';
		}
		$data .= '</ul>';

		return $data;
	}


}