# WordPress Block Parser

Parse WordPress edit-context content to PHP objects easily.

## Installation
```bash
composer require recoded-dev/wordpress-block-parser
```

## Examples

### Parsing and replacing
```php
<?php

use Recoded\WordPressBlockParser\BlockParser;
use Recoded\WordPressBlockParser\Blocks\Block;
use Recoded\WordPressBlockParser\BlockReplacer;

$content = <<<HTML
<!-- wp:paragraph -->
Test
<!-- /wp:paragraph -->
HTML;

$parser = BlockParser::create($content);
$replacer = BlockReplacer::create($content);

foreach ($parser as $block) {
    // $block->namespace
    // $block->name
    // $block->attributes

    if ($block instanceof Block) {
        // $block->content
    }

    $replacer->replace($block, 'Your replaced content');
}

echo (string) $replacer; // Your replaced content
```

## Contributing
Everyone is welcome to contribute. Feel free to PR your work once you think it's ready.
Or open a draft-PR if you want to get some opinions or further help.

I would like to keep this package relatively small and want to avoid bloat. The package
should remain extensible and unopinionated.
