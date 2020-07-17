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

    class <?= $item->getFacadeBasename() ?>

    {
<?php foreach ($item->methods() as $method): ?>

        /**
<?php if ($desctiption = $method->getDescription()): ?>
         * <?= $desctiption ?>

         *
<?php endif; ?>
<?php if ($parameters = $method->parameters()): ?>
<?php foreach ($parameters as $parameter): ?>
         * @param <?= $parameter->getType(true) ?> $<?= $parameter->getName() ?>

<?php endforeach; ?>
         *
<?php endif; ?>
         * @return string
         * @static
         */
        public static function <?= $method->getName() ?>(<?= $method->join(true) ?>)
        {
            /** @var \<?= $item->getInstanceClassname() ?> $instance */
            return $instance-><?= $method->getName() ?>(<?= $method->join() ?>);
        }
<?php endforeach; ?>
    }
<?php endforeach; ?>
}
<?php endforeach; ?>
