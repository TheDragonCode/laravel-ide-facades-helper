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

<?php /** @var \Helldar\LaravelIdeFacadesHelper\Entities\Instance[] $items */ ?>

<?php foreach ($items as $item): ?>
/**
<?php foreach ($item->properties() as $property): ?>
* @param {{ $property->getDeclaringClass() }} {{ $property->getName() }}
<?php endforeach; ?>
<?php foreach ($item->methods() as $method): ?>
* @method static {{ $method->getDeclaringClass() }} <?= $method->getName() ?>(<?= implode(', ', $method->getParameters()) ?>)
<?php endforeach; ?>

<?php endforeach; ?>
