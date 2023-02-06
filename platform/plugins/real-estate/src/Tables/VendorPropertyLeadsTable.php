<?php

namespace Botble\RealEstate\Tables;

use BaseHelper;
use Botble\RealEstate\Enums\ModerationStatusEnum;
use Botble\RealEstate\Enums\PropertyStatusEnum;
use Botble\RealEstate\Exports\PropertyExport;
use Botble\RealEstate\Repositories\Interfaces\AccountInterface;
use Botble\RealEstate\Repositories\Interfaces\ConsultInterface;
use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;
use Botble\Support\Http\Requests\Request;
use Botble\Table\Abstracts\TableAbstract;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\Relation as EloquentRelation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use RealEstateHelper;
use Yajra\DataTables\DataTables;

class VendorPropertyLeadsTable extends TableAbstract
{
    protected $hasActions = true;

    protected $hasFilter = true;

    protected string $exportClass = PropertyExport::class;

    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        PropertyInterface $propertyRepository
    ) {

        parent::__construct($table, $urlGenerator);

        $this->repository = $propertyRepository;


    }

    public function ajax(): JsonResponse
    {

        $data = $this->table
            ->eloquent($this->query())
           ->editColumn('name', function ($item) {
                return "<a target='_blank' title=".$item->name." href=".url('properties/'.$item->slug).">".$item->name."</a>";

            })
            ->editColumn('leads.name', function ($item) {
             return count($item->leads);

            })
            ->editColumn('checkbox', function ($item) {
                return '';

            })
            ->editColumn('operations', function ($item) {


            })
            // ->editColumn('email', function ($item) {
            //     return $item->email;
            // })
            // ->editColumn('created_at', function ($item) {
            //     return BaseHelper::formatDate($item->created_at);
            // })
            // ->addColumn('operations', function ($item) {
            //     return "<a href=".url('consult/'.$item->slug)." class='btn btn-icon btn-sm btn-primary'>View</a>   <a href='#' class='btn btn-icon btn-sm btn-danger deleteDialog' data-bs-toggle='tooltip' data-section='".url('consult_delete/'.$item->slug)."' role='button' data-bs-original-title='".trans('core/base::tables.delete_entry')."' >
            //     <i class='fa fa-trash'></i>
            // </a>";
            // })
            ->addIndexColumn();

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $vendorId = 0000;
        // Log::info(Session::get('vendorId'));
        if(Session::has('vendorId') && Session::get('vendorId') != null ){
            $vendorId = Session::get('vendorId');
        }

        // dd($this->repository->getModel());
        $query = $this->repository->getModel()->select([
            'id',
            'name',
            // 'username',
            // 'created_at',
        ])
        ->where('is_featured',1)
        ->where('author_id', $vendorId)

        ->with(['leads'])->orderBy('id','desc');
        //    Log::info($query);
        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'DT_RowIndex' => [
                'title' => 'S.No',
                'width' => '20px',
                'orderable' => false,
                'searchable' => false,
            ],
            'name' => [
                'title' => trans('core/base::tables.name'),
                'class' => 'text-start',
            ],
            'leads.name' => [
                'title' => 'TotalLeads',
                'class' => 'text-start',
            ],
            // 'phone' => [
            //     'title' => trans('phone'),
            //     'class' => 'text-start',
            // ],
            // 'property.name' => [
            //     'title' => trans('property'),
            //     'class' => 'text-start',
            //     'orderable' => false,
            // ],
            // 'propertiesdata.created_at' => [
            //     'title' => trans('core/base::tables.created_at'),
            //     'width' => '100px',
            //     'class' => 'text-start',
            // ],
        ];
    }

    // public function buttons(): array
    // {
    //     return $this->addCreateButton(route('property.create'), 'property.create');
    // }

    // public function bulkActions(): array
    // {
    //     return $this->addDeleteAction(route('property.deletes'), 'property.destroy', parent::bulkActions());
    // }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],


            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'date',
            ],
        ];
    }

    public function applyFilterCondition(EloquentBuilder|QueryBuilder|EloquentRelation $query, string $key, string $operator, ?string $value): EloquentRelation|EloquentBuilder|QueryBuilder
    {
        if ($key == 'status') {
            switch ($value) {
                case 'expired':
                    return $query->expired();
                case 'active':
                    return $query
                        ->notExpired()
                        ->where(RealEstateHelper::getPropertyDisplayQueryConditions());
            }
        }

        return parent::applyFilterCondition($query, $key, $operator, $value);
    }

    // public function getDefaultButtons(): array
    // {
    //     return [
    //         'export',
    //         'reload',
    //     ];
    // }
}
