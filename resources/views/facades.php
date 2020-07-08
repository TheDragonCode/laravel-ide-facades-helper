<?= '<?php' ?>

// @formatter:off

/**
 * A helper file for Laravel, to provide autocomplete information to your IDE
 * Generated for Laravel <?= $version ?> on <?= date('Y-m-d H:i:s') ?>.
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 * @see https://github.com/andrey-helldar/laravel-ide-facades-helper
 */

<?php /** @var array $items */ ?>
<?php /** @var \Helldar\LaravelIdeFacadesHelper\Entities\Instance[] $classes */ ?>

<?php foreach ($items as $namespace => $classes): ?>
namespace <?= $namespace ?>
{
<?php foreach ($classes as $item): ?>

    /**
<?php foreach ($item->methods() as $method): ?>
     * @method static <?= $method->getType() ?> <?= $method->getName() ?>(<?= implode(', ', $method->getParameters()) ?>)
<?php endforeach; ?>
     */
    class <?= $item->getClassname() ?> extends \Illuminate\Support\Facades\Facade {
    }
<?php endforeach; ?>
}
<?php endforeach; ?>
