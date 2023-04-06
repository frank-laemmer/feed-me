<?php

namespace craft\feedme\fields;

use Cake\Utility\Hash;
use craft\feedme\base\Field;
use craft\feedme\base\FieldInterface;

/**
 *
 * @property-read string $mappingTemplate
 */
class RadioButtons extends Field implements FieldInterface
{
    // Properties
    // =========================================================================

    /**
     * @var string
     */
    public static $name = 'RadioButtons';

    /**
     * @var string
     */
    public static $class = 'craft\fields\RadioButtons';


    // Templates
    // =========================================================================

    /**
     * @inheritDoc
     */
    public function getMappingTemplate()
    {
        return 'feed-me/_includes/fields/option-select';
    }


    // Public Methods
    // =========================================================================

    /**
     * @inheritDoc
     */
    public function parseField()
    {
        $value = $this->fetchValue();
        $default = Hash::get($this->fieldInfo, 'default');

        $options = Hash::get($this->field, 'settings.options');
        $match = Hash::get($this->fieldInfo, 'options.match', 'value');

        foreach ($options as $option) {
            if (
                (isset($option['value']) && $value === $option[$match]) ||
                ($match === 'label' && $value === $default && $value === $option['value'])
            ) {
                return $option['value'];
            }
        }

        if (empty($value)) {
            return $value;
        }

        return null;
    }
}
