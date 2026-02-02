<?php

namespace App\Models\Traits;
trait HasJsonTranslation
{
    public function translate(string $field): string
    {
        $value = $this->{$field};

        if (!is_array($value)) {
            return '';
        }

        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale');

        return $value[$locale]
            ?? $value[$fallback]
            ?? '';
    }
}
