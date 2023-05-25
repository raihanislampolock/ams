<?php

namespace App\Admin\Controllers;

use App\Models\Asset;
use App\Models\AssetTransactions;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

        $grid->column('id', __('Id'))->sortable();
        $grid->assetType()->asset_type_name('Asset Name');
        $grid->assetModel()->model_name('Model');
        $grid->column('asset_configuration', __('Asset Configuration'));
        $grid->column('asset_sn_number', __('Asset SN'));
        $grid->column('tagging_code', __('Tagging Code'));

        $Model = [];
        $Assets = \App\Models\AssetModel::all();
        foreach ($Assets as $asset)
        {
            $Model[$asset->id] = $asset->asset_model_id . $asset->manufacturer->name;
        }
        $grid->column('manufacturer', __('Manufacturer'))->display(function () use ($Model)
        {
            return $Model[$this->asset_model_id];
        });


        $transactions = \App\Models\AssetTransactions::all();
        $Transaction = [];
        $PR = [];
        $PO = [];
        
        foreach ($transactions as $transaction)
        {
            $Transaction[$transaction->id] = $transaction->asset_price;
            $PR[$transaction->id] = $transaction->asset_purchase_request;
            $PO[$transaction->id] = $transaction->asset_purchase_order;
        }
        
        $grid->column('asset_price', __('Asset Price'))->display(function () use ($Transaction)
        {
            $asset_model_id = $this->asset_model_id;
            return isset($Transaction[$asset_model_id]) ? $Transaction[$asset_model_id] : 'N/A';
        });
        
        $grid->column('pr', __('Asset Purchase Request'))->display(function () use ($PR)
        {
            $asset_model_id = $this->asset_model_id;
            return isset($PR[$asset_model_id]) ? $PR[$asset_model_id] : 'N/A';
        });
        
        $grid->column('po', __('Asset Purchase Order'))->display(function () use ($PO)
        {
            $asset_model_id = $this->asset_model_id;
            return isset($PO[$asset_model_id]) ? $PO[$asset_model_id] : 'N/A';
        });
        

        $grid->column('mac_address', __('Mac Address'));
        $grid->column('servicing_date', __('Servicing Date'))->editable('date');
        $grid->column('remarks', __('Remarks'))->editable('text');
        $grid->column('cd', __('Cd'))->sortable();
        
        $grid->quickSearch(function ($model, $query) {
            $model->orWhereHas('asmodel', function (Builder $queryr) use ($query) {
                $queryr->where('model_name', 'like', "%{$query}%");
            });
            $model->orWhereHas('astype', function (Builder $queryr) use ($query) {
                $queryr->where('asset_type_name', 'like', "%{$query}%");
            });
        })->placeholder('Search Here Model or Asset Name...');

        $grid->filter(function ($filter) {
            $filter->like('asset_configuration', __('Asset Configuration'));
        });

        $grid->filter(function ($filter) {
            $filter->like('asset_sn_number', __('Asset SN'));
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

        $AssetTypes = \App\Models\AssetType::all();
        
        $Type = [];
        foreach ($AssetTypes as $assetType) {
            $Type[$assetType->id] = $assetType->asset_type_name;
        }
        $form->select('asset_type_id', __('Asset Type'))->options($Type)->load('asset_model_id', '/admin/get-ast');

        $ModelN = [];
        $Assets = \App\Models\AssetModel::all();

        foreach ($Assets as $asset) {
            $ModelN[$asset->id] =  $asset->asset_model_id . $asset->model_name . ' - ' . $asset->manufacturer->name;
        }
        $form->select('asset_model_id', __('Asset Model'))->options($ModelN);
        
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
    // dd()


    public function getAst(Request $request)
    {
        $assetTypeId = $request->get('q');
    
        $models = \App\Models\AssetModel::where('asset_type_id', $assetTypeId)->get();
    
        $assetModels = [];
        foreach ($models as $model) {
            $assetModels[$model->id] = $model->asset_model_id . $model->model_name . ' - ' . $model->manufacturer->name;
        }
        $filteredAssetModels = $this->formatCascading($assetModels);
        return $filteredAssetModels;
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
}
