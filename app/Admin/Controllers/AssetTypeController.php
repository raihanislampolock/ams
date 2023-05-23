<?php

namespace App\Admin\Controllers;

use App\Models\AssetType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AssetTypeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Asset Type';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AssetType());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('asset_type_name', __('Asset Type'));
        $grid->column('cd', __('Cd'))->sortable();
        
        $grid->filter(function ($filter) {
            $filter->like('asset_type_name', __('Asset Type'));
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
        $show = new Show(AssetType::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('asset_type_name', __('Asset Type'));
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
        $form = new Form(new AssetType());

        $form->text('asset_type_name', __('Asset Type'));
        $form->hidden('cb', __('Cb'))->value(auth()->user()->name);
        $form->hidden('ub', __('Ub'))->value(auth()->user()->name);

        return $form;
    }
}
