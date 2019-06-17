<?php

/**
 * This is the model class for table "snippet".
 *
 * The followings are the available columns in table 'snippet':
 * @property string $id
 * @property string $title
 * @property string $code
 * @property string $html
 * @property string $language
 */
class Snippet extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'snippet';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['title, code, language', 'required'],
            ['title', 'length', 'max' => 255],
            ['language', 'length', 'max' => 20],
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
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'title'    => 'Title',
            'code'     => 'Code',
            'html'     => 'Html',
            'language' => 'Language',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('html', $this->html, true);
        $criteria->compare('language', $this->language, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Snippet the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     *
     */
    protected function afterValidate()
    {
        $highlighter = new CTextHighlighter();
        $highlighter->language = $this->language;
        $this->html = $highlighter->highlight($this->code);

        return parent::afterValidate();
    }

    /**
     * @return array
     */
    public function getSupportedLanguages()
    {
        return [
            'php'        => 'PHP',
            'css'        => 'CSS',
            'html'       => 'HTML',
            'javascript' => 'JavaScript',
        ];
    }
}
