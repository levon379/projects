<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_setting".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $macro_path
 * @property integer $speed
 * @property string $timezone
 * @property string $date_format
 * @property string $time_format
 */
class cSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'macro_speed'], 'integer'],
            [['macro_path'], 'validateMacroPath', 'skipOnEmpty' => true],
            [['macro_path', 'timezone'], 'string', 'max' => 255],
            [['date_format', 'time_format'], 'string', 'max' => 20]
        ];
    }

    public function validateMacroPath($attribute, $params)
    {
        $value = $this->$attribute;
        if(substr($value, -1) != '/' && substr($value, -1) != '\\')
        {
            $this->addError($attribute, 'The macro path must have an ending slash.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'macro_path' => 'iMacro Downloads Folder (Path)',
            'timezone' => 'Timezone',
        ];
    }
}
