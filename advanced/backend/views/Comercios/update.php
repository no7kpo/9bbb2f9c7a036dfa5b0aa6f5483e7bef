<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comercios */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Comercios',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comercios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="comercios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
