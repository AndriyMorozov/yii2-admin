<?php

use mdm\admin\AnimateAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Assignment */
/* @var $fullnameField string */

$userName = $model->fio ?: $model->username;
$this->title = Yii::t('rbac-admin', 'Assignment') . ' : ' . $userName;

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('rbac-admin', 'Assignments'),
    'url'   => ['index']
];
$this->params['breadcrumbs'][] = $userName;

AnimateAsset::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
    'items' => $model->getItems(),
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>
<div class="assignment-index form">
  <div class="form__header">
    <h2>Призначення ролі для: <?= $userName ?></h2>
  </div>

  <div class="form__body">
    <div class="body-row">
      <div class="left-items">
        <input
            class="form-control search" data-target="available"
            placeholder="<?= Yii::t('rbac-admin', 'Search for available'); ?>"
        >
        <select multiple size="20" class="form-control list" data-target="available">
        </select>
      </div>
      <div class="center-items">
          <?= Html::a('&gt;&gt;' . $animateIcon, [
              'assign',
              'id' => (string)$model->id
          ], [
              'class'       => 'btn btn-success btn-assign',
              'data-target' => 'available',
              'title'       => Yii::t('rbac-admin', 'Assign'),
          ]); ?><br><br>
          <?= Html::a('&lt;&lt;' . $animateIcon, [
              'revoke',
              'id' => (string)$model->id
          ], [
              'class'       => 'btn btn-danger btn-assign',
              'data-target' => 'assigned',
              'title'       => Yii::t('rbac-admin', 'Remove'),
          ]); ?>
      </div>
      <div class="right-items">
        <input
            class="form-control search" data-target="assigned"
            placeholder="<?= Yii::t('rbac-admin', 'Search for assigned'); ?>"
        >
        <select multiple size="20" class="form-control list" data-target="assigned">
        </select>
      </div>
    </div>
  </div>
</div>
