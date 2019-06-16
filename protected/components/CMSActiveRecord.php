<?php

class CMSActiveRecord extends CActiveRecord
{
    public $_oldAttributes = [];

    /**
     * Adds the CTimestampBehavior to this class
     * @return array
     */
    public function behaviors()
    {
        return [
            'CTimestampBehavior' => [
                'class'             => 'zii.behaviors.CTimestampBehavior',
                'createAttribute'   => 'created',
                'updateAttribute'   => 'updated',
                'setUpdateOnCreate' => true
            ]
        ];
    }

    /**
     * Returns attributes suitable for the API
     * @return array
     */
    public function getAPIAttributes($params = [], $relations = false)
    {
        $attributes = [];
        foreach ($this->attributes as $k => $v) {
            if (in_array($k, $params)) {
                continue;
            }

            if ($k == 'created' || $k == 'updated') {
                $attributes[$k] = strtotime($v);
            } else {
                $attributes[$k] = $v;
            }
        }

        if ($relations != false) {
            foreach ($relations as $relation) {
                if (is_array($this->$relation)) {
                    $attributes[$relation] = [];
                    foreach ($this->$relation as $k) {
                        $attributes[$relation][] = $k->getAPIAttributes();
                    }
                } else {
                    if (isset($this->$relation)) {
                        $attributes[$relation] = $this->$relation->getAPIAttributes();
                    } else {
                        $attributes[$relation] = [];
                    }
                }
            }
        }

        return $attributes;
    }


    /**
     * After finding a user and getting a valid result
     * store the old attributes in $this->_oldAttributes
     * @return parent::afterFind();
     */
    public function afterFind()
    {
        if ($this !== null) {
            $this->_oldAttributes = $this->attributes;
        }
        return parent::afterFind();
    }
}
