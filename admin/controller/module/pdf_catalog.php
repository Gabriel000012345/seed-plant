<?php

/*
Id: pdf_catalog.php

Copyright (c) 2013 Jason Clark(mithereal@gmail.com)

Released under the GNU General Public License

For more information, please see the github repo: http://github.com/mithereal

Coded to: Dethklok, Make them Suffer
*/

class ControllerModulePdfcatalog extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('module/pdf_catalog');

        $this->document->setTitle = $this->language->get('heading_title');

//$this->load->helper('tcpdf/tcpdf');

        $this->load->model('setting/setting');
        $this->load->model('design/layout');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            $this->model_setting_setting->editSetting('pdf_catalog', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

//$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }
        $mdata['heading_title'] = $this->language->get('heading_title');

        $mdata['text_enabled'] = $this->language->get('text_enabled');
        $mdata['text_disabled'] = $this->language->get('text_disabled');
        $mdata['text_content_top'] = $this->language->get('text_content_top');
        $mdata['text_content_bottom'] = $this->language->get('text_content_bottom');
        $mdata['text_column_left'] = $this->language->get('text_column_left');
        $mdata['text_column_right'] = $this->language->get('text_column_right');
        $mdata['text_hide'] = $this->language->get('text_hide');
        $mdata['text_yes'] = $this->language->get('text_yes');
        $mdata['text_no'] = $this->language->get('text_no');
        $mdata['text_native'] = $this->language->get('text_native');
        $mdata['text_product_name'] = $this->language->get('text_product_name');
        $mdata['text_product_popular'] = $this->language->get('text_product_popular');

        $mdata['entry_display_categories'] = $this->language->get('entry_display_categories');
        $mdata['entry_pdf_creator'] = $this->language->get('entry_pdf_creator');
        $mdata['entry_display_toc'] = $this->language->get('entry_display_toc');
        $mdata['entry_pdf_author'] = $this->language->get('entry_pdf_author');
        $mdata['entry_pdf_max_products'] = $this->language->get('entry_pdf_max_products');
        $mdata['entry_pdf_title'] = $this->language->get('entry_pdf_title');
        $mdata['entry_pdf_subject'] = $this->language->get('entry_pdf_subject');
        $mdata['entry_pdf_keywords'] = $this->language->get('entry_pdf_keywords');
        $mdata['entry_pdf_catalog_display_description'] = $this->language->get('entry_pdf_catalog_display_description');
        $mdata['entry_pdf_catalog_item_per_page'] = $this->language->get('entry_pdf_catalog_item_per_page');
        $mdata['entry_pdf_catalog_image_width'] = $this->language->get('entry_pdf_catalog_image_width');
        $mdata['entry_pdf_catalog_image_height'] = $this->language->get('entry_pdf_catalog_image_height');
        $mdata['entry_pdf_catalog_description_chars'] = $this->language->get('entry_pdf_catalog_description_chars');
        $mdata['entry_pdf_catalog_template_type'] = $this->language->get('entry_pdf_catalog_template_type');
        $mdata['entry_pdf_catalog_max_options'] = $this->language->get('entry_pdf_catalog_max_options');
        $mdata['entry_pdf_catalog_max_per_options'] = $this->language->get('entry_pdf_catalog_max_per_options');
        $mdata['entry_pdf_max_options'] = $this->language->get('entry_pdf_max_options');
        $mdata['entry_pdf_max_per_options'] = $this->language->get('entry_pdf_max_per_options');


        $mdata['entry_layout'] = $this->language->get('entry_layout');
        $mdata['entry_position'] = $this->language->get('entry_position');
        $mdata['entry_status'] = $this->language->get('entry_status');
        $mdata['entry_sort_order'] = $this->language->get('entry_sort_order');
        $mdata['entry_description'] = $this->language->get('entry_description');
        $mdata['entry_display_out_of_stock'] = $this->language->get('entry_display_out_of_stock');
        $mdata['entry_display_disabled'] = $this->language->get('entry_display_disabled');
        $mdata['entry_display_subcategories'] = $this->language->get('entry_display_subcategories');
        $mdata['entry_sort_products'] = $this->language->get('entry_sort_products');

        $mdata['button_install_tcpdf'] = $this->language->get('button_install_tcpdf');
        $mdata['button_save'] = $this->language->get('button_save');
        $mdata['button_cancel'] = $this->language->get('button_cancel');
        $mdata['button_add_module'] = $this->language->get('button_add_module');
        $mdata['button_remove'] = $this->language->get('button_remove');

        if (isset($this->error['warning'])) {
            $mdata['error_warning'] = $this->error['warning'];
        } else {
            $mdata['error_warning'] = '';
        }

        $mdata['breadcrumbs'] = array();

        $mdata['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $mdata['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $mdata['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/pdf_catalog', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $mdata['action'] = $this->url->link('module/pdf_catalog', 'token=' . $this->session->data['token'], 'SSL');
        $mdata['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $mdata['modules'] = array();

        if (isset($this->request->post['pdf_catalog_display_description'])) {
            $mdata['pdf_catalog_display_description'] = $this->request->post['pdf_catalog_display_description'];
        } else {
            $mdata['pdf_catalog_display_description'] = $this->config->get('pdf_catalog_display_description');
        }

        if (isset($this->request->post['pdf_catalog_module'])) {
            $mdata['modules'] = $this->request->post['pdf_catalog_module'];
        } elseif ($this->config->get('pdf_catalog_module')) {
            $mdata['modules'] = $this->config->get('pdf_catalog_module');
        }

        if (isset($this->request->post['pdf_catalog_position'])) {
            $mdata['pdf_catalog_position'] = $this->request->post['pdf_catalog_position'];
        } else {
            $mdata['pdf_catalog_position'] = $this->config->get('pdf_catalog_position');
        }

        if (isset($this->request->post['pdf_catalog_item_per_page'])) {
            $mdata['pdf_catalog_item_per_page'] = $this->request->post['pdf_catalog_item_per_page'];
        } else {
            $mdata['pdf_catalog_item_per_page'] = $this->config->get('pdf_catalog_item_per_page');
        }

        if (isset($this->request->post['pdf_catalog_image_width'])) {
            $mdata['pdf_catalog_image_width'] = $this->request->post['pdf_catalog_image_width'];
        } else {
            $mdata['pdf_catalog_image_width'] = $this->config->get('pdf_catalog_image_width');
        }

        if (isset($this->request->post['pdf_catalog_display_toc'])) {
            $mdata['pdf_catalog_display_toc'] = $this->request->post['pdf_catalog_display_toc'];
        } else {
            $mdata['pdf_catalog_display_toc'] = $this->config->get('pdf_catalog_display_toc');
        }

        if (isset($this->request->post['pdf_catalog_max_products'])) {
            $mdata['pdf_catalog_max_products'] = $this->request->post['pdf_catalog_max_products'];
        } else {
            $mdata['pdf_catalog_max_products'] = $this->config->get('pdf_catalog_max_products');
        }

        if (isset($this->request->post['pdf_catalog_image_height'])) {
            $mdata['pdf_catalog_image_height'] = $this->request->post['pdf_catalog_image_height'];
        } else {
            $mdata['pdf_catalog_image_height'] = $this->config->get('pdf_catalog_image_height');
        }

        if (isset($this->request->post['pdf_catalog_status'])) {
            $mdata['pdf_catalog_status'] = $this->request->post['pdf_catalog_status'];
        } else {
            $mdata['pdf_catalog_status'] = $this->config->get('pdf_catalog_status');
        }

        if (isset($this->request->post['pdf_catalog_sort_order'])) {
            $mdata['pdf_catalog_sort_order'] = $this->request->post['pdf_catalog_sort_order'];
        } else {
            $mdata['pdf_catalog_sort_order'] = $this->config->get('pdf_catalog_sort_order');
        }

        if (isset($this->request->post['pdf_catalog_description'])) {
            $mdata['pdf_catalog_description'] = $this->request->post['pdf_catalog_description'];
        } else {
            $mdata['pdf_catalog_description'] = $this->config->get('pdf_catalog_description');
        }

        if (isset($this->request->post['pdf_catalog_display_categories'])) {
            $mdata['pdf_catalog_display_categories'] = $this->request->post['pdf_catalog_display_categories'];
        } else {
            $mdata['pdf_catalog_display_categories'] = $this->config->get('pdf_catalog_display_categories');
        }

        if (isset($this->request->post['pdf_catalog_author'])) {
            $mdata['pdf_catalog_author'] = $this->request->post['pdf_catalog_author'];
        } else {
            $mdata['pdf_catalog_author'] = $this->config->get('pdf_catalog_author');
        }

        if (isset($this->request->post['pdf_catalog_title'])) {
            $mdata['pdf_catalog_title'] = $this->request->post['pdf_catalog_title'];
        } else {
            $mdata['pdf_catalog_title'] = $this->config->get('pdf_catalog_title');
        }

        if (isset($this->request->post['pdf_catalog_subject'])) {
            $mdata['pdf_catalog_subject'] = $this->request->post['pdf_catalog_subject'];
        } else {
            $mdata['pdf_catalog_subject'] = $this->config->get('pdf_catalog_subject');
        }

        if (isset($this->request->post['pdf_catalog_keywords'])) {
            $mdata['pdf_catalog_keywords'] = $this->request->post['pdf_catalog_keywords'];
        } else {
            $mdata['pdf_catalog_keywords'] = $this->config->get('pdf_catalog_keywords');
        }

        if (isset($this->request->post['pdf_catalog_description_chars'])) {
            $mdata['pdf_catalog_description_chars'] = $this->request->post['pdf_catalog_description_chars'];
        } else {
            $mdata['pdf_catalog_description_chars'] = $this->config->get('pdf_catalog_description_chars');
        }

        if (isset($this->request->post['pdf_catalog_template_type'])) {
            $mdata['pdf_catalog_template_type'] = $this->request->post['pdf_catalog_template_type'];
        } else {
            $mdata['pdf_catalog_template_type'] = $this->config->get('pdf_catalog_template_type');
        }

        if (isset($this->request->post['pdf_catalog_display_out_of_stock'])) {
            $mdata['pdf_catalog_display_out_of_stock'] = $this->request->post['pdf_catalog_display_out_of_stock'];
        } else {
            $mdata['pdf_catalog_display_out_of_stock'] = $this->config->get('pdf_catalog_display_out_of_stock');
        }

        if (isset($this->request->post['pdf_catalog_display_disabled'])) {
            $mdata['pdf_catalog_display_disabled'] = $this->request->post['pdf_catalog_display_disabled'];
        } else {
            $mdata['pdf_catalog_display_disabled'] = $this->config->get('pdf_catalog_display_disabled');
        }

        if (isset($this->request->post['pdf_catalog_display_subcategories'])) {
            $mdata['pdf_catalog_display_subcategories'] = $this->request->post['pdf_catalog_display_subcategories'];
        } else {
            $mdata['pdf_catalog_display_subcategories'] = $this->config->get('pdf_catalog_display_subcategories');
        }
        if (isset($this->request->post['pdf_catalog_sort_products'])) {
            $mdata['pdf_catalog_sort_products'] = $this->request->post['pdf_catalog_sort_products'];
        } else {
            $mdata['pdf_catalog_sort_products'] = $this->config->get('pdf_catalog_sort_products');
        }

        if (isset($this->request->post['pdf_catalog_max_options'])) {
            $mdata['pdf_catalog_max_options'] = $this->request->post['pdf_catalog_max_options'];
        } else {
            $mdata['pdf_catalog_max_options'] = $this->config->get('pdf_catalog_max_options');
        }

        if (isset($this->request->post['pdf_catalog_max_per_options'])) {
            $mdata['pdf_catalog_max_per_options'] = $this->request->post['pdf_catalog_max_per_options'];
        } else {
            $mdata['pdf_catalog_max_per_options'] = $this->config->get('pdf_catalog_max_per_options');
        }

        $mdata['modules'] = array();
        if (isset($this->request->post['pdf_catalog_module'])) {
            $mdata['modules'] = $this->request->post['pdf_catalog_module'];
        } elseif ($this->config->get('pdf_catalog_module')) {
            $mdata['modules'] = $this->config->get('pdf_catalog_module');
        }
        $mdata['token'] = $this->session->data['token'];
        $mdata['layouts'] = $this->model_design_layout->getLayouts();
        $mdata['tcpdf'] = file_exists(DIR_SYSTEM . 'helper/tcpdf/tcpdf.php');

        $this->template = 'module/pdf_catalog.tpl';
//        $this->children = array(
//            'common/header',
//            'common/footer'
//        );

        $mdata['header'] = $this->load->controller('common/header');
        $mdata['column_left'] = $this->load->controller('common/column_left');
        $mdata['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view($this->template, $mdata)); // $this->config->get('config_compression'));
    }


    public function install()
    {
        $this->load->model('setting/setting');
        $this->db->query("
INSERT INTO " . DB_PREFIX . "setting (
`setting_id` ,
`store_id` ,
`key` ,
`value` ,
`serialized`
)
VALUES (
NULL , '0',  'pdf_catalog_image_height', '100', '0'
),(
NULL , '0', 'pdf_catalog_image_width', '100', '0'
),(
NULL , '0', 'pdf_catalog_display_toc', '1', '0'
),(
NULL , '0', 'pdf_catalog_display_subcategories', '1', '0'
),(
NULL , '0', 'pdf_catalog_item_per_page', '6', '0'
),(
NULL , '0', 'pdf_catalog_max_products', '200', '0'
),(
NULL , '0', 'pdf_catalog_description_chars', '75', '0'
),(
NULL , '0', 'pdf_catalog_template_type', 'html', '0'
),(
NULL , '0', 'pdf_catalog_display_disabled', '0', '0'
),(
NULL , '0', 'pdf_catalog_display_out_of_stock', '0', '0'
),(
NULL , '0', 'pdf_catalog_display_subcategories', '1', '0'
),(
NULL , '0', 'pdf_catalog_sort_products', 'pd.name', '0'
),(
NULL , '0', 'pdf_catalog_max_options', '1', '0'
),(
NULL , '0', 'pdf_catalog_max_per_options', '1', '0'
),(
NULL , '0', 'pdf_catalog_display_description', '0', '0'
);
");
    }

    public function fetch_api()
    {
        $this->load->model('setting/setting');

        $config_error_display = $this->config->get('config_error_display');
        $config_error_log = $this->config->get('config_error_log');

        if ($config_error_display > 0 || $config_error_log > 0) {
            $this->model_setting_setting->editSettingValue('config', 'config_error_display', 0);
            $this->model_setting_setting->editSettingValue('config', 'config_error_log', 0);

        }

        $this->load->language('module/pdf_catalog');

        $url = $this->language->get('tcpdf_url');
        $cache = DIR_SYSTEM . 'cache/tcpdf.zip';
        $unzip_path = DIR_SYSTEM . 'helper/';

        if (!$fp = fopen($cache, 'w')) {
            echo "Error: <br>";
            echo "You may need to change permissions for the directory $cache";
            echo '<br>';
            return;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        echo 'Download Complete....' . '<br>';

        $this->model_setting_setting->editSettingValue('config', 'config_error_display', $config_error_display);
        $this->model_setting_setting->editSettingValue('config', 'config_error_log', $config_error_log);

        if (!$fp = fopen($unzip_path . 'test', 'w')) {
            echo "Error: <br>";
            echo "You may need to change permissions for the directory $unzip_path";
            echo '<br>';
        } else {
            $this->unzip($cache, $unzip_path);
            fclose($fp);
        }
        unlink($unzip_path . 'test');
//$this->rrmdir($unzip_path.'tcpdf');
        $renamed = rename(DIR_SYSTEM . 'helper/tcpdf-6.0.086', DIR_SYSTEM . 'helper/tcpdf');
        if (!$renamed == false) {
            copy(DIR_SYSTEM . 'cache/pdf_catalog_default_logo.png', DIR_SYSTEM . 'helper/tcpdf/examples/pdf_catalog_default_logo.png');
//unlink($cache);
            echo 'Api Installed...';
            echo '<br>';
        } else {
            echo '<br>';
            echo '<br>';
            echo "Error: Check if Tcpdf directory exists, if it does remove it (unless you need for specific purpose).";
            echo '<br>';
        }
    }

    public function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") $this->rrmdir($dir . "/" . $object); else unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function unzip($path, $unzip_path)
    {

        $zip = new ZipArchive;
        $res = $zip->open($path);
        if ($res === TRUE) {
            $zip->extractTo($unzip_path);
            $zip->close();
            echo "$path successfully unzipped at location:.$unzip_path";
            echo '<br>';
        } else {
            echo "Error: $path failed to unzip at location:$unzip_path";
            echo '<br>';
        }

    }

    public function uninstall()
    {
        $this->db->query("
DELETE FROM " . DB_PREFIX . "setting 
WHERE `key` like 'pdf_catalog%'
");
    }

    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'module/pdf_catalog')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

