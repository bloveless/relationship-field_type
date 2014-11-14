<?php namespace Anomaly\Streams\Addon\FieldType\Relationship;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class RelationshipFieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Addon\FieldType\Relationship
 */
class RelationshipFieldType extends FieldType
{

    public function relation()
    {
        return $this->hasOne('Foo'); // TODO: Flesh this out.
    }

    /**
     * When setting the value, if it is an entry
     * then get the ID off of it.
     *
     * @param $value
     * @return mixed
     */
    protected function onSet($value)
    {
        if ($value instanceof EloquentModel) {

            $value = $value->getKey();
        }

        return $value;
    }

    /**
     * Fire after setting the value on the entry.
     * This will make sure the ID was set on the
     * appropriate property.
     *
     * @param $model
     */
    protected function onAfterSet($model)
    {
        if ($id = $model->{parent::getColumnName()}) {

            $model->{$this->getColumnName()};
        }

        unset($model->{parent::getColumnName()});
    }

    /**
     * @return string
     */
    public function getColumnName()
    {
        return parent::getColumnName() . '_id';
    }
}
