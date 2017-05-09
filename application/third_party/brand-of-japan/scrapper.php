<?php

class lako_scrapper extends lako_lib_base{
  protected $version = '0.01';
  protected $client = null;
  protected $ci     = null;
  function __construct($config=array()){
    parent::__construct($config=array());
    
    require_once lako::path().'/../scrapper-files/vendor/autoload.php';
    require_once lako::path().'/../scrapper-files/polyfill.php';
    require_once lako::path().'/../scrapper-files/Goutte/Client.php';
    $this->client = new Goutte\Client();
    $this->ci = get_instance();
    $this->ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
  }
  
  function get_category($in_category_url, $per_page=10, $page=1, $cache_time=86400){
    $parsed = parse_url($in_category_url);
    $category_url = $parsed['scheme'].'://'.$parsed['host'].$parsed['path'];
    parse_str($parsed['query'], $query);
    $new_query = http_build_query(array(
      'category_id' => $query['category_id'],
      'p'           => $page,
      'num'         => $per_page
    ));
    $category_url .= '?'.$new_query;
    
    
    $cache_key = 'category_'.md5($category_url);
    if($cached = $this->ci->cache->get($cache_key))
      return $cached;
    
    //$crawler = $client->request('GET', 'http://shop.brandoff.co.jp/category/index.php?category_id=181');
    $crawler = $this->client->request('GET', $category_url);

    $products = $crawler->filter('.category_box_01a,.category_box_01b')->each(function ($node) {
      $product = array();
      $product['image'] = trim($node->filter('img')->first()->attr('src'));
      $product['brand'] = trim($node->filter('.category_box_03')->first()->text());
      $a = $node->filter('.category_box_03')->last()->filter('a');
      $product['name'] = trim($a->text());
      $product['link'] = trim($a->attr('href'));
      $product['prices'] = $node->filter('.category_box_04 p')->each(function($price){
        return trim($price->text());
      });
      
      return $product;
    });
    
    $src = $crawler->filter('.mar_u5')->first()->filter('font')->last()->filter('a')->attr('href');
    $parsed_src = parse_url($src);
    
    parse_str($parsed_src['query'],$parsed_query);
    $pagination = array(
      'next' => false,
      'prev' => false
    );
    
    if(intval($parsed_query['p']) !=  $page)
      $pagination['next'] = true;
    if($page > 1)
      $pagination['prev'] = true;
    
    $pagination['page'] = $page;
      
    $response = array(
      'products'    => $products,
      'pagination'  => $pagination
    );
    $this->ci->cache->save($cache_key, $response, $cache_time);
    return $response;
  }
  
  function get_product($product_url, $cache_time=86400){
    $cache_key = 'product_'.md5($product_url);
    if($cached = $this->ci->cache->get($cache_key))
      return $cached;
    
    $crawler = $this->client->request('GET', $product_url);
    $main = $crawler->filter('#main');
    $product = array();
    $product['title'] = trim($main->filter('.main_box_09 h2')->text());

    $product['image'] = trim($main->filter('.poji_box_01')
                                   ->first()
                                   ->filter('img')
                                   ->attr('src'));
                                
    $product['attributes'] = $main->filter('.main_box_01')
                                   ->first()
                                   ->filter('.item_list_01 table tr')
                                   ->each(function($attribute){
                                      return array(
                                        'label' => trim($attribute->filter('th')->text()),
                                        'value' => trim($attribute->filter('td')->text())
                                      );
                                   });
                                   
    $product['gallery'] = $main->filter('.main_box_01')
                                   ->eq(1)
                                   ->filter('img')
                                   ->each(function($img){
                                      return array(
                                        'small' => trim($img->attr('src')),
                                        'large' => trim(str_replace('document.main_img.src=',
                                                                '',
                                                                $img->attr('onmouseover')),
                                                      '" ')
                                      );
                                   });
                                   
    $product['gallery_description'] = trim($main->filter('.main_box_01')
                                           ->eq(2)
                                           ->text());
                                   
    $product['extra_attributes'] = $main->filter('.main_box_01')
                                   ->eq(3)
                                   ->filter('.main_box_03 .item_list_02 .main_box_04')
                                   ->each(function($attribute){
                                      return array(
                                        'label' => trim($attribute->filter('p.red')->text()),
                                        'value' => trim($attribute->filter('p')->last()->text())
                                      );
                                   });
                                   
    $product['description'] = trim($main  ->filter('.main_box_01')
                                          ->eq(3)
                                          ->filter('.main_box_05')
                                          ->filter('p')
                                          ->eq(1)
                                          ->text());
    $product['description_html'] = trim($main  ->filter('.main_box_01')
                                              ->eq(3)
                                              ->filter('.main_box_05')
                                              ->filter('p')
                                              ->eq(1)
                                              ->html());
                                   
    $this->ci->cache->save($cache_key, $product, $cache_time);
    return $product;
  }
  
}