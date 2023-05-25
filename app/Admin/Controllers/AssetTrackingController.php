<?php

namespace App\Admin\Controllers;

use App\Models\AssetTracking;
use App\Models\AssetModel;
use App\Models\AssetType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
Use Encore\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class AssetTrackingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Asset Tracking';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AssetTracking());
        $grid->column('id', __('Id'))->sortable();
        $grid->department()->name('Department');
        $grid->employee()->emp_id('Employee ID')->sortable();
        $grid->employee()->emp_name('Employee Name');
        $grid->asset()->asset_sn_number('Asset SN');
        $grid->column('asset.asset_model_id', 'Asset Model')->display(function ($asset_model_id) {
            $assetModel = AssetModel::find($asset_model_id);
             $model_name = $assetModel->model_name??'N/A';
             $assetType = AssetType::find($assetModel->asset_type_id);
            $asset_type_name = $assetType->asset_type_name ??'N/A';
            
            return $model_name.' ( '.$asset_type_name.')';
        });

        $grid->addColumn('Tagging Id', 'Department & Tagging Marge')->display(function ()
        {
            $department = $this->department->short_name;
            $taggingCode = $this->asset->tagging_code;
            return $department . '-' . $taggingCode;
        });
        
        $grid->assetLocation()->asset_location('Asset Location');
        $grid->column('assign_date', __('Assign Date'))->sortable();
        $grid->asset()->mac_address('Mac Address');
        $grid->column('remarks', __('Remarks'))->editable('text');
        $grid->column('cd', __('Cd'))->sortable();

        $grid->quickSearch(function ($model, $query) {
            $model->orWhereHas('emp', function (Builder $queryr) use ($query) {
                $queryr->where('emp_id', 'like', "%{$query}%");
            });
            $model->orWhereHas('emp', function (Builder $queryr) use ($query) {
                $queryr->where('emp_name', 'like', "%{$query}%");
            });
            $model->orWhereHas('depart', function (Builder $queryr) use ($query) {
                $queryr->where('name', 'like', "%{$query}%");
            });
            $model->orWhereHas('ast', function (Builder $queryr) use ($query) {
                $queryr->where('asset_sn_number', 'like', "%{$query}%");
            });
            $model->orWhereHas('ast', function (Builder $queryr) use ($query) {
                $queryr->where('mac_address', 'like', "%{$query}%");
            });
        })->placeholder('Emp id Name or Dept or sn Or Mac...');

        $grid->disableFilter();


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
        $show = new Show(AssetTracking::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('department_id', __('Department id'));
        $show->field('emp_id', __('Emp id'));
        $show->field('asset_id', __('Asset id'));
        $show->field('assign_date', __('Assign date'));
        $show->field('asset_location_id', __('Asset location id'));
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
        $form = new Form(new AssetTracking());

        $dpt = \App\Models\Department::pluck('name', 'id')->toArray();
        $form->select('department_id', __('Department Name'))->options($dpt);

        $Emp = \App\Models\Employee::all()->map(function ($emp) {
            return [
                'id' => $emp->id,
                'label' => "{$emp->emp_id} - {$emp->emp_name}",
            ];
        })->pluck('label', 'id')->toArray();
        $form->select('emp_id', __('Employee ID & Name'))->options($Emp);

        $AssetTypes = \App\Models\AssetType::all();
        
        $Type = [];
        foreach ($AssetTypes as $assetType) {
            $Type[$assetType->id] = $assetType->asset_type_name;
        }
        
        $form->select('asset_type_id', __('Asset Type'))->options($Type)->load('asset_id', '/admin/get-sn');

        $SNNumber = [];
        $submittedSNNumbers = AssetTracking::pluck('asset_id')->toArray();
        
        $Assets = \App\Models\Asset::all();

        foreach ($Assets as $asset) {
            $SNNumber[$asset->id] = $asset->asset_sn_number . ' (' . $asset->assetModel->model_name . ')';
        }
        $filteredSNNumber = array_diff_key($SNNumber, array_flip($submittedSNNumbers));

        $form->select('asset_id', __('SN Number'))->options($filteredSNNumber);

        $Location = \App\Models\AssetLocation::pluck('asset_location', 'id')->toArray();
        $form->select('asset_location_id', __('Asset Location'))->options($Location);

        $form->date('assign_date', __('Assign date'))->default(date('Y-m-d'));
        $form->text('remarks', __('Remarks'));
        $form->hidden('cb', __('Cb'))->value(auth()->user()->name);
        $form->hidden('ub', __('Ub'))->value(auth()->user()->name);
        $form->submitted(function (Form $form) {
            $form->ignore('asset_type_id');
        });

        return $form;
    }

    public function getSn(Request $request) {
        $assetTypeId = $request->get('q');
        $sns = \App\Models\Asset::where('asset_type_id', $assetTypeId)->get();

        $SNNumber = [];
        $submittedSNNumbers = AssetTracking::pluck('asset_id')->toArray();
        foreach ($sns as $sn) {
            $SNNumber[$sn->id] = $sn->asset_sn_number . ' (' . $sn->assetModel->model_name . ')';
        }
        $filteredSNNumber = array_diff_key($SNNumber, array_flip($submittedSNNumbers));
        $filteredSNNumber = $this->formatCascading($filteredSNNumber);
        return $filteredSNNumber;
    }

    public function formatCascading($data = [])
    {
        $response = [];
        foreach ($data as $key => $value) {
            $response[] = ['id' => $key,'text' => $value];
        }
        return $response;
    }
}
