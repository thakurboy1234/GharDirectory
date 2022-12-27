<?php

namespace Botble\RealEstate\Tables;

use BaseHelper;
use Botble\RealEstate\Enums\ProjectStatusEnum;
use Botble\RealEstate\Exports\ProjectExport;
use Botble\RealEstate\Repositories\Interfaces\ProjectInterface;
use Botble\Table\Abstracts\TableAbstract;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ProjectTable extends TableAbstract
{
    protected $hasActions = true;

    protected $hasFilter = true;

    protected string $exportClass = ProjectExport::class;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, ProjectInterface $projectRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $projectRepository;
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                return Html::link(route('project.edit', $item->id), BaseHelper::clean($item->name));
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
            ->addColumn('operations', function ($item) {
                return $this->getOperations('project.edit', 'project.destroy', $item);
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
                'width' => '60px',
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
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('project.create'), 'project.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('project.deletes'), 'project.destroy', parent::bulkActions());
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
                'choices' => ProjectStatusEnum::labels(),
                'validate' => 'required|' . Rule::in(ProjectStatusEnum::values()),
            ],
        ];
    }

    public function getDefaultButtons(): array
    {
        return [
            'export',
            'reload',
        ];
    }
}
