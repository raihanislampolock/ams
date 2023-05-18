<?php

namespace App\Admin\Controllers;

use App\Models\Asset;
use App\Models\AssetTransactions;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AssetController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Asset';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Asset());

        $grid->column('id', __('Id'));
        $grid->assetType()->asset_type_name('Asset Name');
        $grid->assetModel()->model_name('Model');
        $grid->column('asset_configuration', __('Asset Configuration'));
        $grid->column('asset_sn_number', __('Asset SN'));
        $grid->column('tagging_code', __('Tagging Code'));

        $assets = \App\Models\AssetModel::all();
        $Vendor = [];
        $Manufacturer = [];
        foreach ($assets as $asset) {
            $Vendor[$asset->vendor_id] = $asset->vendor->company_name;
            $Manufacturer[$asset->manufacturer_id] = $asset->manufacturer->name;
        }
        
        $grid->column('asset_model_id', __('Vendor And Manufacturer'))->display(function ($value) use ($Vendor, $Manufacturer)
        {
            return $Vendor[$value] . ' - ' . $Manufacturer[$value] ;
        });

        $transactions = \App\Models\AssetTransactions::all();
        $Transaction = [];
        
        foreach ($transactions as $transaction)
        {
            $Transaction[$transaction->asset_model_id] = $transaction->asset_price;
        }
        $grid->column('asset_price', __('Asset Price'))->display(function () use ($Transaction)
        {
            return $Transaction[$this->asset_model_id];
        });

        $grid->column('mac_address', __('Mac Address'));
        $grid->column('servicing_date', __('Servicing Date'))->editable('date');
        $grid->column('remarks', __('Remarks'))->editable('text');
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
        $show = new Show(Asset::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('asset_type_id', __('Asset type id'));
        $show->field('asset_model_id', __('Asset model id'));
        $show->field('asset_configuration', __('Asset configuration'));
        $show->field('asset_sn_number', __('Asset sn number'));
        $show->field('tagging_code', __('Tagging code'));
        $show->field('mac_address', __('Mac address'));
        $show->field('servicing_date', __('Servicing date'));
        $show->field('remarks', __('Remarks'));
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
        $form = new Form(new Asset());

        $AssetType = \App\Models\AssetType::pluck('asset_type_name', 'id')->toArray();
        $form->select('asset_type_id', __('Asset Type'))->options($AssetType);

        $Model = [];
        $Assets = \App\Models\AssetModel::all();
        foreach ($Assets as $asset)
        {
            $Model[$asset->id] = $asset->asset_model_id . $asset->model_name . ' - ' . $asset->vendor->company_name . ' - ' . $asset->manufacturer->name;
        }
        $form->select('asset_model_id', __('Asset Model'))->options($Model);
        
        $form->text('asset_configuration', __('Asset configuration'));
        $form->text('asset_sn_number', __('Asset SN'));
        $form->text('tagging_code', __('Tagging Code'))->default(time())->readonly();
        $form->text('mac_address', __('Mac Address'));
        $form->date('servicing_date', __('Servicing date'));
        $form->text('remarks', __('Remarks'));
        $form->hidden('cb', __('Cb'))->value(auth()->user()->name);
        $form->hidden('ub', __('Ub'))->value(auth()->user()->name);

        return $form;
    }
}
