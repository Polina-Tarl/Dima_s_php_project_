<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 6);
        $sortField = $request->input('sort', 'price');
        $sortOrder = $request->input('order', 'asc');

        $rootGroups = Group::where('id_parent', 0)->get();

        $query = Product::with(['price', 'group']);

        if ($sortField === 'price') {
            $query->join('prices', 'products.id', '=', 'prices.id_product')
                ->orderBy('prices.price', $sortOrder)
                ->select('products.*');
        } else {
            $query->orderBy("products.$sortField", $sortOrder);
        }

        $products = $query->paginate($perPage)->appends($request->query());

        if ($request->ajax()) {
            return view('catalog._products', compact('products'))->render();
        }

        return view('catalog.index', compact('rootGroups', 'products', 'sortField', 'sortOrder'));
    }

    public function group(Request $request, $id)
    {
        $perPage = $request->input('per_page', 6);
        $sortField = $request->input('sort', 'name');
        $sortOrder = $request->input('order', 'asc');

        $rootGroups = Group::where('id_parent', 0)->get();
        $activeGroup = Group::findOrFail($id);
        $childGroups = Group::where('id_parent', $id)->get();

        $groupIds = $this->getAllGroupIds($id);

        $query = Product::with(['price', 'group'])->whereIn('id_group', $groupIds);

        if ($sortField === 'price') {
            $query->join('prices', 'products.id', '=', 'prices.id_product')
                ->orderBy('prices.price', $sortOrder)
                ->select('products.*');
        } else {
            $query->orderBy("products.$sortField", $sortOrder);
        }

        $products = $query->paginate($perPage)->appends($request->query());

        if ($request->ajax()) {
            return view('catalog._products', compact('products'))->render();
        }

        return view('catalog.index', compact(
            'rootGroups', 'products', 'sortField', 'sortOrder', 'activeGroup', 'childGroups'
        ));
    }

    private function getAllGroupIds($groupId)
    {
        $ids = [$groupId];
        $children = Group::where('id_parent', $groupId)->pluck('id');

        foreach ($children as $childId) {
            $ids = array_merge($ids, $this->getAllGroupIds($childId));
        }

        return $ids;
    }

    public function show($id)
    {
        $product = Product::with(['price', 'group'])->findOrFail($id);

        $group = $product->group;
        $breadcrumbs = $group ? $group->breadcrumbs() : [];

        return view('catalog.product', compact('product', 'breadcrumbs'));
    }
}
