<?php

namespace Theme\FlexHome\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;
use Theme;

class ThemeIconField extends FormField
{
    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        Assets::addScriptsDirectly(Theme::asset()->url('js/icons-field.js'));

        return Theme::getThemeNamespace() . '::partials.forms.fields.theme-icon-field';
    }
}
