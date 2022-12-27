<?php

namespace Botble\RealEstate\Tables;

use BaseHelper;
use Botble\RealEstate\Models\Account;
use Html;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use RvMedia;

class AccountPropertyTable extends PropertyTable
{
    public $hasActions = false;

    public $hasCheckbox = false;

    public $hasFilter = false;

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                return Html::link(route('public.account.properties.edit', $item->id), BaseHelper::clean($item->name));
            })
            ->editColumn('image', function ($item) {
                return Html::image(
                    RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage()),
                    BaseHelper::clean($item->name),
                    ['width' => 50]
                );
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('expire_date', function ($item) {
                if ($item->never_expired) {
                    return trans('plugins/real-estate::property.never_expired_label');
                }

                if (! $item->expire_date) {
                    return '&mdash;';
                }

                if ($item->expire_date->isPast()) {
                    return Html::tag('span', $item->expire_date->toDateString(), ['class' => 'text-danger'])->toHtml();
                }

                if (now()->diffInDays($item->expire_date) < 3) {
                    return Html::tag('span', $item->expire_date->toDateString(), ['class' => 'text-warning'])->toHtml();
                }

                return $item->expire_date->toDateString();
            })
            ->editColumn('status', function ($item) {
                return BaseHelper::clean($item->status->toHtml());
            })
            ->editColumn('moderation_status', function ($item) {
                return BaseHelper::clean($item->moderation_status->toHtml());
            })
            ->addColumn('operations', function ($item) {
                $edit = 'public.account.properties.edit';
                $delete = 'public.account.properties.destroy';

                return view('plugins/real-estate::account.table.actions', compact('edit', 'delete', 'item'))->render();
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this->repository->getModel()
            ->select([
                'id',
                'name',
                'images',
                'created_at',
                'status',
                'moderation_status',
                'expire_date',
            ])
            ->where([
                'author_id' => auth('account')->id(),
                'author_type' => Account::class,
            ]);

        return $this->applyScopes($query);
    }

    public function buttons(): array
    {
        $buttons = [];
        if (auth('account')->user()->canPost()) {
            $buttons = $this->addCreateButton(route('public.account.properties.create'));
        }

        return $buttons;
    }

    public function columns(): array
    {
        $columns = parent::columns();
        Arr::forget($columns, 'author_id');

        $columns['expire_date'] = [
            'name' => 'expire_date',
            'title' => trans('plugins/real-estate::property.expire_date'),
            'width' => '150px',
        ];

        return $columns;
    }

    public function getDefaultButtons(): array
    {
        return ['reload'];
    }
}
