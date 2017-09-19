<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paypal_key".
 *
 * @property integer $id
 * @property string $client_id
 * @property string $client_secret
 */
class PaypalKey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paypal_key';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'client_secret'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'client_secret' => 'Client Secret',
        ];
    }
}
