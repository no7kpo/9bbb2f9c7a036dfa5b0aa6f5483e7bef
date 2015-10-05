<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rutas */

$this->title = Yii::t('app', 'Create Rutas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rutas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
