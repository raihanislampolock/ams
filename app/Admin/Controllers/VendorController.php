<?php

namespace App\Admin\Controllers;

use App\Models\Vendor;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VendorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Vendor';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Vendor());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('company_name', __('Company Name'));
        $grid->column('company_address', __('Company Address'));
        $grid->column('poc_name', __('Poc Name'));
        $grid->column('poc_number', __('Poc Contact Number'));
        $grid->column('poc_email', __('Poc Email'));
        $grid->column('cd', __('Cd'))->sortable();

        $grid->filter(function ($filter) {
            $filter->like('company_name', __('Company Name'));
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
        $show = new Show(Vendor::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('company_name', __('Company Name'));
        $show->field('company_address', __('Company Address'));
        $show->field('poc_name', __('Poc Name'));
        $show->field('poc_number', __('Poc Contact Number'));
        $show->field('poc_email', __('Poc Email'));
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
        $form = new Form(new Vendor());

        $form->text('company_name', __('Company Name'));
        $form->text('company_address', __('Company Address'));
        $form->text('poc_name', __('Poc Name'));
        $form->mobile('poc_number', __('Poc Contact Number'));
        $form->text('poc_email', __('Poc Email'));
        $form->hidden('cb', __('Cb'))->value(auth()->user()->name);
        $form->hidden('ub', __('Ub'))->value(auth()->user()->name);
        
        return $form;
    }
}
