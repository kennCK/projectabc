<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductAttribute;
use App\Pricing;
use App\AccountImage;
class ProductController extends APIController
{
    function __construct(){
    	$this->model = new Product();
      $this->notRequired = array(
        'tags'
      );
    }

    public function create(Request $request){
    	$data = $request->all();
    	$data['code'] = $this->generateCode();
    	$this->model = new Product();
    	$this->insertDB($data);
    	return $this->response();
    }


    public function generateCode(){
      $code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 32);
      $codeExist = Product::where('id', '=', $code)->get();
      if(sizeof($codeExist) > 0){
        $this->generateCode();
      }else{
        return $code;
      }
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $this->model = new Product();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      // details
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $this->response['data'][$i]['account'] = $this->retrieveAccountDetails($result[$i]['account_id']);
          $this->response['data'][$i]['price'] = $this->getPrice($result[$i]['id']);
          $this->response['data'][$i]['color'] = $this->getColor($result[$i]['id']);
          $this->response['data'][$i]['size'] = $this->getSize($result[$i]['id']);
          $this->response['data'][$i]['featured'] = $this->getFeaturedImage($result[$i]['id']);
          $this->response['data'][$i]['images'] = $this->getImages($result[$i]['id']);
          $i++;
        }
      }
      return $this->response();
    }

    public function getPrice($id){
      $result = Pricing::where('product_id', '=', $id)->orderBy('minimum', 'asc')->get();
      return (sizeof($result) > 0) ? $result : null;
    }

    public function getColor($id){
      $result = ProductAttribute::where('product_id', '=', $id)->where('payload', '=', 'color')->get();
      return (sizeof($result) > 0) ? $result : null;
    }

    public function getSize($id){
      $result = ProductAttribute::where('product_id', '=', $id)->where('payload', '=', 'size')->get();
      return (sizeof($result) > 0) ? $result : null;
    }

    public function getImages($id){
      $result = AccountImage::where('payload', '=', 'product')->where('payload_value', '=', $id)->where('status', '=', 'others')->get();
      return (sizeof($result) > 0) ? $result : null;
    }

    public function getFeaturedImage($id){
      $result = AccountImage::where('payload', '=', 'product')->where('payload_value', '=', $id)->where('status', '=', 'featured')->get();
      return (sizeof($result) > 0) ? $result : null;
    }

}
