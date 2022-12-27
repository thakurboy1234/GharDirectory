<?php

namespace Botble\RealEstate\Services\Abstracts;

use Botble\RealEstate\Models\Property;
use Botble\RealEstate\Repositories\Interfaces\CategoryInterface;
use Illuminate\Http\Request;

abstract class StorePropertyCategoryServiceAbstract
{
    protected CategoryInterface $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    abstract public function execute(Request $request, Property $property);
}
