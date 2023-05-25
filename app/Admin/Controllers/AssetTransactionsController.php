<?php

namespace App\Admin\Controllers;

use App\Models\Assettransactions;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AssetTransactionsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Asset Transactions';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Assettransactions());

        $grid->column('id', __('Id'))->sortable();
        $Type = [];
        $Model = [];
        $Assets = \App\Models\Asset::all();
        foreach ($Assets as $asset)
        {
            $Type[$asset->id] = $asset->asset_id . $asset->assetType->asset_type_name;
            $Model[$asset->id] = $asset->asset_id . $asset->assetModel->model_name;
        }
        $grid->column('type', __('Asset Type'))->display(function () use ($Type)
        {
            return $Type[$this->asset_id];
        });
        $grid->column('model', __('Asset Model'))->display(function () use ($Model)
        {
            return $Model[$this->asset_id];
        });

        $grid->asset()->asset_sn_number('SN Number');
        $grid->vendor()->company_name('Vendor');
        $grid->column('asset_price', __('Asset Price'));
        $grid->column('asset_purchase_date', __('Asset Purchase Date'))->sortable();
        $grid->column('asset_purchase_request', __('Asset Purchase Request'));
        $grid->column('asset_purchase_order', __('Asset Purchase Order'));
        $grid->column('asset_warranty_date', __('Asset Warranty Date'))->sortable();
        $grid->column('cd', __('Cd'))->sortable();

        $grid->filter(function ($filter) {
            $filter->like('asset_purchase_request', __('Asset Purchase Request'));
        });

        $grid->filter(function ($filter) {
            $filter->like('asset_purchase_order', __('Asset Purchase Order'));
        });

        $grid->quickSearch(function ($model, $query) {
            $model->orWhereHas('asasset', function (Builder $queryr) use ($query) {
                $queryr->where('asset_sn_number', 'like', "%{$query}%");
            });
        })->placeholder('Search Here Serial Number...');

        $grid->model()->orderBy('id', 'desc');


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Assettransactions::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('asset_id', __('Asset id'));
        $show->field('vendor_id', __('Vendor id'));
        $show->field('asset_price', __('Asset price'));
        $show->field('asset_purchase_date', __('Asset purchase date'));
        $show->field('asset_purchase_request', __('Asset purchase request'));
        $show->field('asset_purchase_order', __('Asset purchase order'));
        $show->field('asset_warranty_date', __('Asset warranty date'));
        $show->field('cb', __('Cb'));
        $show->field('cd', __('Cd'));
        $show->field('ub', __('Ub'));
        $show->field('ud', __('Ud'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Assettransactions());

        $Model = [];
        $Assets = \App\Models\Asset::all();
        foreach ($Assets as $asset)
        {
            $Model[$asset->id] = $asset->asset_id . $asset->asset_sn_number . ' - ' . $asset->assetType->asset_type_name . ' - ' . $asset->assetModel->model_name;
        }
        $form->select('asset_id', __('Asset'))->options($Model);

        $vendor = \App\Models\Vendor::pluck('company_name', 'id')->toArray();
        $form->select('vendor_id', __('Vendor'))->options($vendor);

        $form->number('asset_price', __('Asset Price'));
        $form->date('asset_purchase_date', __('Asset Purchase Date'))->default(date('Y-m-d'));
        $form->text('asset_purchase_request', __('Asset purchase request'));
        $form->text('asset_purchase_order', __('Asset Purchase Order'));
        $form->date('asset_warranty_date', __('Asset Warranty Date'))->default(date('Y-m-d'));
        $form->hidden('cb', __('Cb'))->value(auth()->user()->name);
        $form->hidden('ub', __('Ub'))->value(auth()->user()->name);

        return $form;
    }
}
