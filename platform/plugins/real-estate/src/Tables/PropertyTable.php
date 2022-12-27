<?php

namespace Botble\RealEstate\Tables;

use BaseHelper;
use Botble\RealEstate\Enums\ModerationStatusEnum;
use Botble\RealEstate\Enums\PropertyStatusEnum;
use Botble\RealEstate\Exports\PropertyExport;
use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;
use Botble\Table\Abstracts\TableAbstract;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\Relation as EloquentRelation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use RealEstateHelper;
use Yajra\DataTables\DataTables;

class PropertyTable extends TableAbstract
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
                return Html::link(route('property.edit', $item->id), $item->name);
            })
            ->editColumn('image', function ($item) {
                return $this->displayThumbnail($item->image);
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) {
                return BaseHelper::clean($item->status->toHtml());
            })
            ->editColumn('moderation_status', function ($item) {
                return BaseHelper::clean($item->moderation_status->toHtml());
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('property.edit', 'property.destroy', $item);
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this->repository->getModel()->select([
            'id',
            'name',
            'images',
            'status',
            'moderation_status',
            'created_at',
        ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'image' => [
                'title' => trans('core/base::tables.image'),
                'width' => '50px',
                'class' => 'no-sort',
                'orderable' => false,
                'searchable' => false,
            ],
            'name' => [
                'title' => trans('core/base::tables.name'),
                'class' => 'text-start',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
                'class' => 'text-start',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
            'moderation_status' => [
                'title' => trans('plugins/real-estate::property.moderation_status'),
                'width' => '150px',
            ],
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('property.create'), 'property.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('property.deletes'), 'property.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'type' => 'select',
                'choices' => PropertyStatusEnum::labels(),
                'validate' => 'required|' . Rule::in(PropertyStatusEnum::values()),
            ],
            'moderation_status' => [
                'title' => trans('plugins/real-estate::property.moderation_status'),
                'type' => 'select',
                'choices' => ModerationStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', ModerationStatusEnum::values()),
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

    public function getDefaultButtons(): array
    {
        return [
            'export',
            'reload',
        ];
    }
}
