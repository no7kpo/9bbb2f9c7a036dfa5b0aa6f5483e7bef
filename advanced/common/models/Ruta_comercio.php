<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ruta_comercio".
 *
 * @property integer $idruta
 * @property integer $idcomercio
 * @property integer $orden
 *
 * @property Comercios $idcomercio0
 * @property Rutas $idruta0
 */
class Ruta_comercio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ruta_comercio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idruta', 'idcomercio', 'orden'], 'required'],
            [['idruta', 'idcomercio', 'orden'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idruta' => Yii::t('app', 'Idruta'),
            'idcomercio' => Yii::t('app', 'Idcomercio'),
            'orden' => Yii::t('app', 'Orden'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcomercio0()
    {
        return $this->hasOne(Comercios::className(), ['id' => 'idcomercio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdruta0()
    {
        return $this->hasOne(Rutas::className(), ['id' => 'idruta']);
    }
}
