<?php

namespace App\Services;

use App\Models\Site;
use App\Models\SiteFormField;

class ContactFormValidatorService
{
    public function rulesForSite(Site $site): array
    {
        $rules = [
            'site_key' => ['required', 'string', 'exists:sites,site_key'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:5000'],
            'fields' => ['nullable', 'array'],
        ];

        foreach ($site->formFields as $field) {
            $rules["fields.{$field->field_key}"] = $this->rulesForField($field);
        }

        return $rules;
    }

    public function allowedFieldKeys(Site $site): array
    {
        return $site->formFields->pluck('field_key')->all();
    }

    private function rulesForField(SiteFormField $field): array
    {
        $requiredRule = $field->is_required ? 'required' : 'nullable';

        $rules = match ($field->type) {
            'email' => [$requiredRule, 'email'],
            'textarea' => [$requiredRule, 'string', 'max:5000'],
            'checkbox' => [$requiredRule, 'boolean'],
            default => [$requiredRule, 'string', 'max:255'],
        };

        if (! empty($field->validation_rules)) {
            $rules = array_merge($rules, explode('|', $field->validation_rules));
        }

        return $rules;
    }
}
