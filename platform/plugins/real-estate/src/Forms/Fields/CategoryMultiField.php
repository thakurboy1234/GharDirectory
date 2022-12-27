<?php

namespace Botble\RealEstate\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class CategoryMultiField extends FormField
{
    protected function getTemplate(): string
    {
        return 'plugins/real-estate::categories.categories-multi';
    }
}
