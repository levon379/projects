<?php

namespace App\Http\Controllers;

use App\Libraries\Repositories\ProductOptionsRepository;
use App\Libraries\Repositories\ProductsRepository;
use App\Libraries\Helpers;
use App\Product;
use App\ProductOption;
use App\Source;
use App\SourceName;
use App\SourceGroup;
use App\SourceOption;
use App\User;
use Illuminate\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Yangqi\Htmldom\Htmldom;

class SourceController extends Controller {

    public function __construct(Guard $auth, ProductsRepository $productsRepository, ProductOptionsRepository $productOptionsRepository) {
        $this->productsRepository = $productsRepository;
        $this->productOptionsRepository = $productOptionsRepository;
        $this->auth = $auth;
    }

    public function index() {
        $sources = Source::paginate(10);
        return view('source.index', compact('sources'));
    }

    public function add() {
        $mode = 'add';
        $productId = Input::old('product_id', 0);
        $sourceGroupId = Input::old('source_group_id', 0);

        $productOptions = $this->productOptionsRepository->getProductOptionsByProductLanguageDates();

        $products = $this->productsRepository->getProductsByProductOptionLanguageDates();

        $sourceNames = SourceName::where('source_group_id', '=', $sourceGroupId)->get();

        $sourceGroups = SourceGroup::all();
        return view('source.add_edit', compact('products', 'productOptions', 'sourceNames', 'sourceGroups', 'mode'));
    }

    public function postAdd() {
        $input = Input::all();

        $source_product_option = $input['product_options'];

        $source = new Source;
        $source->source_name_id = $input['source_name_id'];
        $source->trav_season_start = Helpers::formatDate($input['travel_season_date_start']);
        $source->trav_season_end = Helpers::formatDate($input['travel_season_date_end']);
        $source->book_season_start = Helpers::formatDate($input['booking_season_start']);
        $source->book_season_end = Helpers::formatDate($input['booking_season_end']);
        $source->adult_net_rate = empty($input['adult_price']) ? 0 : Helpers::cleanPrice($input['adult_price']);
        $source->child_net_rate = empty($input['child_price']) ? 0 : Helpers::cleanPrice($input['child_price']);
        if(isset($input['default_flag'])){
            $source->default_flag = 1;
        }

        $rules = array(
            'source_name_id' => 'required',
            'adult_price' => 'required',
            'child_price' => 'at_least:1',
            'product_options' => 'required',
        );

        $messages = array(
            'product_options.required' => 'Please choose a product option',
            'source_name_id.required' => 'Please choose a source name',
            'child_net_rate.required' => 'This child net rate field is required',
            'adult_net_rate.required' => 'This adult net rate field is required',
        );

        $validation = Validator::make($input, $rules, $messages);

        if ($validation->passes()) {
            $source->save();

            if ($source->id) {
                foreach ($source_product_option as $value) {

                    $source_option = new SourceOption;
                    $source_option->product_opt_id = $value;
                    $source_option->source_id = $source->id;
                    $source_option->save();
                }
                return redirect("/admin/source/list")
                                ->with('success', 'Net Rate successfully added');
            }
        }
        return redirect("/admin/source/add")->withInput()->withErrors($validation);
    }

    public function edit($id) {
        $mode = 'edit';

        $source = Source::find($id);

        if ($source == null) {
            return redirect("/admin/source/list");
        }

        $productId = SourceOption::where('source_id', $source->id)->get();
        $productOptionsEdit = array();
        foreach ($productId as $key => $value) {
            $productOptionsEdit['source_option']['prod_option'][] = ProductOption::find($value->product_opt_id);
            if (!empty($productOptionsEdit['source_option']['prod_option'][$key])) {
                $productOptionsEdit['source_option']['product'][] = Product::find($productOptionsEdit['source_option']['prod_option'][$key]->product_id);
            }
        }
        if (!empty($productOptionsEdit)) {
            $count = count($productOptionsEdit['source_option']['product']);
        }
        $sourceGroupId = Input::old('source_group_id', $source->source_name->source_group->id);
        $productOptions = $this->productOptionsRepository->getProductOptionsByProductLanguageDates();

        $products = $this->productsRepository->getProductsByProductOptionLanguageDates();

        $sourceNames = SourceName::where('source_group_id', '=', $sourceGroupId)->get();
        // Always Show
        $sourceGroups = SourceGroup::all();

        return view('source.add_edit', compact('source', 'count', 'products', 'productOptionsEdit', 'productOptions', 'sourceNames', 'sourceGroups', 'mode'));
    }

    public function postEdit($id) {
        $input = Input::all();

        $source_product_option = array();
        if (isset($input['product_options'])) {
            $source_product_option = $input['product_options'];
        }

        $source = Source::find($id);
        $source->source_name_id = $input['source_name_id'];
        $source->trav_season_start = Helpers::formatDate($input['travel_season_date_start']);
        $source->trav_season_end = Helpers::formatDate($input['travel_season_date_end']);
        $source->book_season_start = Helpers::formatDate($input['booking_season_start']);
        $source->book_season_end = Helpers::formatDate($input['booking_season_end']);
        $source->adult_net_rate = empty($input['adult_price']) ? 0 : Helpers::cleanPrice($input['adult_price']);
        $source->child_net_rate = empty($input['child_price']) ? 0 : Helpers::cleanPrice($input['child_price']);
        
        if(isset($input['default_flag']) && !$source->default_flag){
                $source->default_flag = 1;
        }elseif($source->default_flag && !isset($input['default_flag'])){
            $source->default_flag = 0;
        }

        $rules = array(
            'source_name_id' => 'required',
            'adult_price' => 'required',
            'child_price' => 'at_least:1',
            'product_options' => 'required',
        );

        $messages = array(
            'product_options.required' => 'Please choose a product option',
            'source_name_id.required' => 'Please choose a source name',
            'child_net_rate.required' => 'This child net rate field is required',
            'adult_net_rate.required' => 'This adult net rate field is required',
        );

        $validation = Validator::make($input, $rules, $messages);

        if ($validation->passes()) {
            $source->save();

            if ($source->id && !empty($source_product_option)) {
                foreach ($source_product_option as $value) {

                    $source_option = SourceOption::where('source_id', '=', $source->id)->where('product_opt_id', '=', $value)->get();
                    if ($source_option->count() > 0) {
                        $sourc_option_update = SourceOption::find($source_option[0]->id);
                        $sourc_option_update->product_opt_id = $value;
                        $sourc_option_update->source_id = $source->id;
                        $sourc_option_update->save();
                    } else {
                        $source_option = new SourceOption;
                        $source_option->product_opt_id = $value;
                        $source_option->source_id = $source->id;
                        $source_option->save();
                    }
                }
                return redirect("/admin/source/list")
                                ->with('success', 'Net Rate successfully added');
            } else {
                return redirect("/admin/source/list")
                                ->with('success', 'Net Rate successfully added');
            }
        }
        return redirect("/admin/source/add")->withInput()->withErrors($validation);
    }

    public function delete($id) {
        $source = Source::find($id);
        try {
            SourceOption::where('source_id', '=', $source->id)->delete();
            $source->delete();
        } catch (QueryException $e) {
            Session::flash('error', "Net Rate cannot be deleted it is being used");
            return;
        }

        Session::flash('success', "Net Rate has been deleted successfully");
    }

    public function deleteOption() {
        $input = Input::all();
        SourceOption::where('source_id', '=', $input['source_id'])->where('product_opt_id', '=', $input['product_option_id'])->delete();
    }

}

?>