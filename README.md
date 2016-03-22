[![Latest Stable Version](https://poser.pugx.org/giordanolima/decimal-mutators/v/stable)](https://packagist.org/packages/giordanolima/decimal-mutators) [![Total Downloads](https://poser.pugx.org/giordanolima/decimal-mutators/downloads)](https://packagist.org/packages/giordanolima/decimal-mutators) [![License](https://poser.pugx.org/giordanolima/decimal-mutators/license)](https://packagist.org/packages/giordanolima/decimal-mutators) [![StyleCI](https://styleci.io/repos/47624493/shield)](https://styleci.io/repos/47624493)
## Decimal Mutators for Laravel 5

**Decimal Mutators** provides a short way to create accessors and mutators for decimal fields.

## Install

Install package through Composer

```bash
composer require giordanolima/decimal-mutators
```

### Usage
You should use it as a trait of your model, and declare which fields you want to apply the mutators:

```php
use Illuminate\Database\Eloquent\Model,
    GiordanoLima\DecimalMutators\DecimalMutators;
class MyModel extends Model
{
	use DecimalMutators;

	protected $decimalsFields = [
            'decimal_field_1',
            'decimal_field_2',
            'decimal_field_3',
            'decimal_field_4'
        ];

}
```

By default, the trait will get the data from database and will replace "," (comma) as thousand separator to ""(blank) and will replace "." (dot) as decimal separator to "," (comma).
The behavior will be like this:
```php
$myModel = MyModel::find(1);
$myModel->decimal_field_1 = '200,00';
$myModel->save(); // It will store as 200.00

$myModel = MyModel::find(1);
echo $myModel->decimal_field_1; // Will print 200,00
```
If you want to replace defaults separators, you can replace with:

```php
protected $decimalsOptions = [
    "setDecimalsFrom" => ",",
    "setDecimalsTo" => ".",
    "setThounsandFrom" => ".",
    "setThounsandTo" => "",
    "getDecimalsFrom" => ".",
    "getDecimalsTo" => ",",
    "getThounsandFrom" => ",",
    "getThounsandTo" => "",
];
```

