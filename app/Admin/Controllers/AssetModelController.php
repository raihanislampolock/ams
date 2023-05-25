<?php

namespace App\Admin\Controllers;

use App\Models\AssetModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AssetModelController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Asset Model';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AssetModel());

        $grid->column('id', __('Id'))->sortable();
        $grid->assetType()->asset_type_name('Asset Type');
        $grid->manufacturer()->name('Manufacturer');
        $grid->column('model_name', __('Model'));
        $grid->column('cd', __('Cd'))->sortable();

        $grid->filter(function ($filter) {
            $filter->like('model_name', __('Model'));
        });

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
        $show = new Show(AssetModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('asset_type_id', __('Asset type id'));
        $show->field('manufacturer_id', __('Manufacturer id'));
        $show->field('model_name', __('Model name'));
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
        $form = new Form(new AssetModel());

        $Type = \App\Models\AssetType::pluck('asset_type_name', 'id')->toArray();
        $form->select('asset_type_id', __('Asset Type'))->options($Type);
        $Manufacturer = \App\Models\Manufacturer::pluck('name', 'id')->toArray();
        $form->select('manufacturer_id', __('Manufacturer'))->options($Manufacturer);

        $form->text('model_name', __('Model'));
        $form->hidden('cb', __('Cb'))->value(auth()->user()->name);
        $form->hidden('ub', __('Ub'))->value(auth()->user()->name);

        return $form;

        return $form;
    }
}
