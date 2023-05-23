<?php

namespace App\Admin\Controllers;

use App\Models\Employee;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EmployeeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Employee';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Employee());

        $grid->column('id', __('Id'));
        $grid->column('emp_id', __('Emp Id'));
        $grid->column('emp_name', __('Emp Name'));
        $grid->column('emp_dept', __('Emp Dept'));
        $grid->column('designation', __('Designation'));
        $grid->column('status', __('Status'));
        $grid->column('dob', __('Dob'));
        $grid->column('doj', __('Doj'));
        $grid->column('email_office', __('Email Office'));
        $grid->column('email_personal', __('Email Personal'));
        $grid->column('phone_office', __('Phone Office'));
        $grid->column('phone_personal', __('Phone Personal'));
        $grid->column('blood_group', __('Blood Group'));
        $grid->column('qualification', __('Qualification'));
        $grid->column('license_no', __('License No'));
        $grid->column('cd', __('Cd'));
        $grid->column('eventcard', __('Eventcard'));
        $grid->column('emp_upi', __('Emp Upi'));
        $grid->column('emp_conf_date', __('Emp Confirm Date'));
        $grid->column('emp_resign_date', __('Emp Resign Date'));
        $grid->column('gender', __('Gender'));
        $grid->column('internship_start_date', __('Internship Start Date'));
        $grid->column('internship_end_date', __('Internship End Date'));

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
        $show = new Show(Employee::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('emp_id', __('Emp id'));
        $show->field('emp_name', __('Emp name'));
        $show->field('emp_dept', __('Emp dept'));
        $show->field('designation', __('Designation'));
        $show->field('status', __('Status'));
        $show->field('dob', __('Dob'));
        $show->field('doj', __('Doj'));
        $show->field('email_office', __('Email office'));
        $show->field('email_personal', __('Email personal'));
        $show->field('phone_office', __('Phone office'));
        $show->field('phone_personal', __('Phone personal'));
        $show->field('blood_group', __('Blood group'));
        $show->field('qualification', __('Qualification'));
        $show->field('license_no', __('License no'));
        $show->field('cb', __('Cb'));
        $show->field('cd', __('Cd'));
        $show->field('ub', __('Ub'));
        $show->field('ud', __('Ud'));
        $show->field('eventcard', __('Eventcard'));
        $show->field('emp_upi', __('Emp upi'));
        $show->field('emp_conf_date', __('Emp conf date'));
        $show->field('emp_resign_date', __('Emp resign date'));
        $show->field('gender', __('Gender'));
        $show->field('internship_start_date', __('Internship start date'));
        $show->field('internship_end_date', __('Internship end date'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Employee());

        $form->number('emp_id', __('Emp id'));
        $form->text('emp_name', __('Emp name'));
        $form->number('emp_dept', __('Emp dept'));
        $form->text('designation', __('Designation'));
        $form->number('status', __('Status'));
        $form->date('dob', __('Dob'))->default(date('Y-m-d'));
        $form->date('doj', __('Doj'))->default(date('Y-m-d'));
        $form->text('email_office', __('Email office'));
        $form->text('email_personal', __('Email personal'));
        $form->text('phone_office', __('Phone office'));
        $form->text('phone_personal', __('Phone personal'));
        $form->text('blood_group', __('Blood group'));
        $form->text('qualification', __('Qualification'));
        $form->text('license_no', __('License no'));
        $form->hidden('cb', __('Cb'))->value(auth()->user()->name);
        $form->hidden('ub', __('Ub'))->value(auth()->user()->name);
        $form->text('eventcard', __('Eventcard'));
        $form->text('emp_upi', __('Emp upi'));
        $form->date('emp_conf_date', __('Emp conf date'))->default(date('Y-m-d'));
        $form->date('emp_resign_date', __('Emp resign date'))->default(date('Y-m-d'));
        $form->text('gender', __('Gender'));
        $form->date('internship_start_date', __('Internship start date'))->default(date('Y-m-d'));
        $form->date('internship_end_date', __('Internship end date'))->default(date('Y-m-d'));

        return $form;
    }
}
