<?php

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Supports\SortItemsWithChildrenHelper;
use Botble\RealEstate\Repositories\Interfaces\CategoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

if (! function_exists('get_property_categories')) {
    /**
     * @param array $args
     * @return array
     */
    function get_property_categories(array $args = []): array
    {
        $indent = Arr::get($args, 'indent', '——');

        $repo = app(CategoryInterface::class);

        $categories = $repo->getCategories(Arr::get($args, 'select', ['*']), [
            'created_at' => 'DESC',
            'is_default' => 'DESC',
            'order' => 'ASC',
        ], Arr::get($args, 'conditions', []));

        $categories = sort_item_with_children($categories);

        foreach ($categories as $category) {
            $depth = (int)$category->depth;
            $indentText = str_repeat($indent, $depth);
            $category->indent_text = $indentText;
        }

        return $categories;
    }
}

if (! function_exists('get_property_categories_with_children')) {
    /**
     * @return mixed
     */
    function get_property_categories_with_children()
    {
        $categories = app(CategoryInterface::class)
            ->allBy(['status' => BaseStatusEnum::PUBLISHED], [], ['id', 'name', 'parent_id']);

        return app(SortItemsWithChildrenHelper::class)
            ->setChildrenProperty('child_cats')
            ->setItems($categories)
            ->sort();
    }
}

if (! function_exists('get_property_categories_related_ids')) {
    /**
     * @param $categoryId
     * @param array $results
     * @param null $categories
     * @return array
     */
    function get_property_categories_related_ids($categoryId, array &$results = [], $categories = null): array
    {
        if ($categories instanceof Collection) {
            $list = $categories->where('parent_id', $categoryId);
            foreach ($list as $item) {
                $results[] = $item->id;

                $children = $categories->where('parent_id', $item->id);
                if ($children && $children->count()) {
                    $results = get_property_categories_related_ids($item->id, $results, $children);
                }
            }

            return $results;
        }

        $categories = app(CategoryInterface::class)->allBy([
            'status' => BaseStatusEnum::PUBLISHED,
        ], [], ['id', 'parent_id']);

        $category = $categories->firstWhere('id', $categoryId);

        if ($category) {
            $results[] = $categoryId;
            $results = get_property_categories_related_ids($categoryId, $results, $categories);
        }

        return array_filter($results);
    }
}
