# Laravel Nova Form Field Template

A custom field template to include in form views.

## Installation

Install the tool through composer

```sh
composer require prima-ca/custom-nova-field
```

## Usage

```php
use Cyrus\CustomNovaField\CustomField;

class MyResource extends Resource
{
    ...
    public function fields(Request $request)
    {
        return [
            ...
            CustomField::make('Field')->value('My field value'),
        ];
    }
```

