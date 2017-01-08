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

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$categs = $this->getCategRecursive(0, $parts);

		$data['categories'] = $categs;

		return $this->load->view('module/category', $data);
	}

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


			$childs = $this->getCategRecursive($category['category_id'], $selected, $parentParentId, $rootPath);
			$cCateg = $this->model_catalog_category->getCategories($category['category_id']);
			if (!empty($cCateg) && 1 == 2) {
				$data .= '<span data-target="#accordion' . $category['category_id'] . '"
							data-parent="#accordion' . $parentParentId . '" data-toggle="collapse" aria-expanded="true2">' . $category['name'] . '</span>';
			} else {
				$data .= '<a href="' . $url . '" class="'. $aClass .'">' . $category['name'] . '</a>';
			}
			$data .= $childs;
			$data .= '</li>';
		}
		$data .= '</ul>';

		return $data;
	}


}