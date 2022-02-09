<?php echo '<?php'; ?>

// @formatter:off

/**
 * A helper file for Laravel, to provide autocomplete information to your IDE
 * Generated for Laravel <?php echo $version; ?> on <?php echo date('Y-m-d H:i:s'); ?>.
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @see https://github.com/TheDragonCode/laravel-ide-facades-helper
 */

<?php /** @var array $items */ ?>
<?php /** @var \DragonCode\LaravelIdeFacadesHelper\Entities\Instance[] $classes */ ?>

<?php foreach ($items as $namespace => $classes) { ?>
namespace <?php echo $namespace; ?>
{
<?php foreach ($classes as $item) { ?>

    class <?php echo $item->getFacadeBasename(); ?>

    {
<?php foreach ($item->methods() as $method) { ?>

        /**
<?php if ($desctiption = $method->getDescription()) { ?>
         * <?php echo $desctiption; ?>

         *
<?php } ?>
<?php if ($parameters = $method->parameters()) { ?>
<?php foreach ($parameters as $parameter) { ?>
         * @param <?php echo $parameter->getType(true); ?> <?php echo $parameter->isVariadic() ? '...' : ''; ?>$<?php echo $parameter->getName(); ?>

<?php } ?>
         *
<?php } ?>
         * @return <?php echo $method->getType(); ?>

         * @static
         */
        public static function <?php echo $method->getName(); ?>(<?php echo $method->join(true); ?>)
        {
            /** @var \<?php echo $item->getInstanceClassname(); ?> $instance */
            <?php echo $method->getType() === 'void' ? '' : 'return '; ?>$instance-><?php echo $method->getName(); ?>(<?php echo $method->join(); ?>);
        }
<?php } ?>
    }
<?php } ?>
}
<?php } ?>
