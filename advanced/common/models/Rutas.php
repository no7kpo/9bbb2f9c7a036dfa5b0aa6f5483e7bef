<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rutas".
 *
 * @property integer $id
 * @property string $fecha
 * @property integer $iduser
 *
 * @property RutaComercio[] $rutaComercios
 * @property Comercios[] $idcomercios
 * @property User $iduser0
 */
class Rutas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rutas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'iduser'], 'required'],
            [['fecha'], 'safe'],
            [['iduser'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'iduser' => Yii::t('app', 'Iduser'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutaComercios()
    {
        return $this->hasMany(RutaComercio::className(), ['idruta' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcomercios()
    {
        return $this->hasMany(Comercios::className(), ['id' => 'idcomercio'])->viaTable('ruta_comercio', ['idruta' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIduser0()
    {
        return $this->hasOne(User::className(), ['id' => 'iduser']);
    }
}
