<?php

/*
 * Creating a custom validator for slugs
    Since both Content and Category classes have slugs, we'll need to add a custom validator
    to each class that will enable us to ensure that the slug is not already in use by either
    a post or a category. To do this, we have another class called CMSSlugActiveRecord that
    extends CMSActiveRecord with a validateSlug() method that we'll implement as follows:
 */

class CMSSLugActiveRecord extends CMSActiveRecord
{
    /**
     * @param $attributes
     * @param $params
     * @return bool
     */
    public function validateSlug($attributes, $params)
    {
        // Fetch any records that have that slug
        $content = Content::model()->findByAttributes(['slug' => $this->slug]);
        $category = Category::model()->findByAttributes(['slug' => $this->slug]);

        $class = strtolower(get_class($this));

        if ($content == null && $category == null) {
            return true;
        } else {
            if ($this->id == $$class->id) {
                return true;
            }
        }

        $this->addError('slug', 'That slug is already in use');
        return false;
    }

    public function afterSave()
    {
        if (!YII_DEBUG) {
            Yii::app()->cache->delete('Routes');
        }

        parent::afterSave();
    }
}
