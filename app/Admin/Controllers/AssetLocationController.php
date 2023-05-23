<?php

namespace App\Admin\Controllers;

use App\Models\AssetLocation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AssetLocationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Asset Location';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AssetLocation());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('asset_location', __('Asset Location'));
        $grid->column('cd', __('Cd'))->sortable();

        $grid->filter(function ($filter) {
            $filter->like('asset_location', __('Asset Location'));
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
        $show = new Show(AssetLocation::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('asset_location', __('Asset Location'));
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
        $form = new Form(new AssetLocation());

        $form->text('asset_location', __('Asset Location'));
        $form->hidden('cb', __('Cb'))->value(auth()->user()->name);
        $form->hidden('ub', __('Ub'))->value(auth()->user()->name);

        return $form;
    }
}
