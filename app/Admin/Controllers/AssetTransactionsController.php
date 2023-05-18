<?php

namespace App\Admin\Controllers;

use App\Models\AssetTransactions;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AssetTransactionsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AssetTransactions';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AssetTransactions());

        $grid->column('id', __('Id'));
        $grid->assetModel()->model_name('Asset Model');
        $grid->column('asset_price', __('Asset Price'));
        $grid->column('asset_purchase_date', __('Asset Purchase Date'));
        $grid->column('asset_purchase_request', __('Asset Purchase Request'));
        $grid->column('asset_purchase_order', __('Asset Purchase Order'));
        $grid->column('asset_warranty_date', __('Asset Warranty Date'));
        $grid->column('cd', __('Cd'));

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
        $show = new Show(AssetTransactions::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('asset_model_id', __('Asset model id'));
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
        $form = new Form(new AssetTransactions());

        $Model = \App\Models\AssetModel::pluck('model_name', 'id')->toArray();
        $form->select('asset_model_id', __('Asset Model'))->options($Model);
        $form->text('asset_price', __('Asset Price'));
        $form->date('asset_purchase_date', __('Asset Purchase Date'))->default(date('Y-m-d'));
        $form->text('asset_purchase_request', __('Asset purchase request'));
        $form->text('asset_purchase_order', __('Asset Purchase Order'));
        $form->date('asset_warranty_date', __('Asset Warranty Date'))->default(date('Y-m-d'));
        $form->hidden('cb', __('Cb'))->value(auth()->user()->name);
        $form->hidden('ub', __('Ub'))->value(auth()->user()->name);

        return $form;
    }
}
