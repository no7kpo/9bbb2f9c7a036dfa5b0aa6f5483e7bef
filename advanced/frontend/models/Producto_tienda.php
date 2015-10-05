<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto_tienda".
 *
 * @property integer $idproducto
 * @property integer $idcomercio
 *
 * @property Comercios $idcomercio0
 * @property Productos $idproducto0
 */
class Producto_tienda extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producto_tienda';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idproducto', 'idcomercio'], 'required'],
            [['idproducto', 'idcomercio'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idproducto' => Yii::t('app', 'Idproducto'),
            'idcomercio' => Yii::t('app', 'Idcomercio'),
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
    public function getIdproducto0()
    {
        return $this->hasOne(Productos::className(), ['id' => 'idproducto']);
    }
}
