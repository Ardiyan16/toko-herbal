<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->model(array(
            'product_model' => 'product',
            'review_model' => 'review'
        ));
    }

    public function index() {
        $params['title'] = 'Dari Teman Sejati';

        $products['products'] = $this->product->get_all_products();
        $min = $this->product->min();
        foreach ($min as $row) {
            $min_stock = $row['MIN(stock)'];
        }
        $products['best_deal'] = $this->product->best_deal_product($min_stock);
        $products['reviews'] = $this->review->get_all_reviews();

        get_header($params);
        get_template_part('home', $products);
        get_footer();
    }
}