<?php

use mdm\admin\AnimateAsset;
use mdm\admin\components\ItemController;
use mdm\admin\models\AuthItem;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model AuthItem */
/* @var $context ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AnimateAsset::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
    'items' => $model->getItems(),
    'users' => $model->getUsers(),
    'getUserUrl' => Url::to(['get-users', 'id' => $model->name])
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>
<div class="auth-item-view">
  <div class="upper-level">
    <div class="permission-info">
      <h2><?= $model->name ?></h2>
      <p><?= $model->description ?></p>
      <p>
          <?= Html::a(Yii::t('rbac-admin', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']); ?>
          <?=
          Html::a(Yii::t('rbac-admin', 'Delete'), ['delete', 'id' => $model->name], [
              'class' => 'btn btn-danger',
              'data-confirm' => Yii::t('rbac-admin', 'Are you sure to delete this item?'),
              'data-method' => 'post',
          ]);
          ?>
      </p>
    </div>
    <div class="users">
      <h2>Призначено користувачам</h2>
      <div id="list-users"></div>
    </div>
  </div>
  <div class="lower-level">
    <div class="left-items">
      <input class="form-control search" data-target="available"
             placeholder="<?= Yii::t('rbac-admin', 'Search for available'); ?>">
      <select multiple size="20" class="form-control list" data-target="available"></select>
    </div>
    <div class="center-items">
        <?=
        Html::a('&gt;&gt;' . $animateIcon, ['assign', 'id' => $model->name], [
            'class' => 'btn btn-success btn-assign',
            'data-target' => 'available',
            'title' => Yii::t('rbac-admin', 'Assign'),
        ]);
        ?><br><br>
        <?=
        Html::a('&lt;&lt;' . $animateIcon, ['remove', 'id' => $model->name], [
            'class' => 'btn btn-danger btn-assign',
            'data-target' => 'assigned',
            'title' => Yii::t('rbac-admin', 'Remove'),
        ]);
        ?>
    </div>
    <div class="right-items">
      <input class="form-control search" data-target="assigned"
             placeholder="<?= Yii::t('rbac-admin', 'Search for assigned'); ?>">
      <select multiple size="20" class="form-control list" data-target="assigned"></select>
    </div>
  </div>
</div>
