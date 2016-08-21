<?php namespace App\Libraries\Repositories;

use App\Libraries\Helpers;
use App\Product;
use App\ProductOption;
use App\Promo;
use App\Language;
use App\Libraries\Repositories\BookingsRepository;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Session;

class CartRepository {

    public function getCart() {
        
        // init cart object in session if not already set
        if( !Session::has('cart') )
        {
            Session::set('cart.promo_id', null);
            Session::set('cart.products', []);
        }

        //print_r(Session::get('cart'));exit;
        // fetch order history products from session.
        $cart = Session::get('cart');
        $cartProducts = $cart['products'];
        $totalCartValue = 0;
        $productIds = [];

        // check if promo-code is provided in cart
        $promoId = Session::get('cart.promo_id', null);
        $promo = Promo::find($promoId);

        //seperate productIds to fetch produt objs
        foreach($cartProducts as $cartProduct) {
            $productIds[] = $cartProduct->productId;
        }

        $products = Product::whereIn('id', $productIds)->get();

        // assign product objs to related cart items
        foreach($cartProducts as &$cartProduct)
        {
            // first check if promo-code is applicable
            $productOptionId = $cartProduct->product_option_id;
            $productOption = ProductOption::find($productOptionId);
            $productId = $productOption->product_id;
            
            // check if promo is applicable to current product
            $applicableToProduct = false;

            if($promo)
            {
                $promoProductIds = $promo->promos_products->lists('product_id');

                if( count($promoProductIds) == 0 or in_array($productId, $promoProductIds) )
                {
                    $applicableToProduct = true;
                }
            }

            if( $applicableToProduct )
            {
                $cartProduct->promo_id = $promo->id;
            }
            else
            {
                $cartProduct->promo_id = null;
            }

            $bookingsRepository = new BookingsRepository();

            // totalPrice need to be reconfirmed
            $cartProduct->totalPrice = $cartProduct->price = $bookingsRepository->computeTourPrice( 
                $productOptionId,
                $cartProduct->adult_no, 
                $cartProduct->child_no, 
                $cartProduct->promo_id
            );

            // now set the language
            $cartProduct->language = Language::find( $cartProduct->language_id );
            
            foreach($products as $product)
            {
                if($product->id == $cartProduct->productId)
                {
                    $cartProduct->details = $product;
                    $totalCartValue += $cartProduct->price;
                }
            }
        }
        
        Session::set('cart.products', $cartProducts);
        Session::set('cart.totalCartValue', $totalCartValue);

        $cart['totalCartValue'] = $totalCartValue;
        
        return $cart;
    }

} 