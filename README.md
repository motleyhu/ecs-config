# Rule Set for EasyCodingStandard

An opinionated rule set for [EasyCodingStandard](https://github.com/symplify/easy-coding-standard)

## Installation

```shell
composer require motley/ecs-config
```

## Usage

In `ecs.php`:

```php
// …
use Motley\EasyCodingStandard\SetList as MotleySetList

return static function (ECSConfig $ecsConfig): void {
    // Define paths, cache directory etc
    
    $ecsConfig->sets([MotleySetList::MOTLEY]);

    // Override anything you wish, add exclusions etc
}
```
