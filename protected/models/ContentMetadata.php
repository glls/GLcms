<?php

/**
 * This is the model class for table "content_metadata".
 *
 * The followings are the available columns in table 'content_metadata':
 * @property integer $id
 * @property integer $content_id
 * @property string $key
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Users $content
 */
class ContentMetadata extends CMSActiveRecord
{
    public function behaviors()
    {
        return [];
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'content_metadata';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['key, value', 'required'],
            ['content_id', 'numerical', 'integerOnly' => true],
            ['key, value', 'length', 'max' => 255],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            ['id, content_id, key, value', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'content' => [self::BELONGS_TO, 'Content', 'content_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'content_id' => 'Content',
            'key'        => 'Key',
            'value'      => 'Value',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('content_id', $this->content_id);
        $criteria->compare('t.key', $this->key, true);
        $criteria->compare('value', $this->value, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ContentMetadata the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
