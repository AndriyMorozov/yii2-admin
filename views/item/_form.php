<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mdm\admin\components\RouteRule;
use mdm\admin\AutocompleteAsset;
use yii\helpers\Json;
use mdm\admin\components\Configs;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$rules = Configs::authManager()->getRules();
unset($rules[RouteRule::RULE_NAME]);
$source = Json::htmlEncode(array_keys($rules));

$js = <<<JS
    $('#rule_name').autocomplete({
        source: $source,
    });
JS;
AutocompleteAsset::register($this);
$this->registerJs($js);
?>

<div class="auth-item-form form">
    <?php $form = ActiveForm::begin(['id' => 'item-form']); ?>
  <div class="form__header">
    <h2><?= $model->isNewRecord ? 'Створення дозволу' : $model->name ?></h2>
  </div>
  <div class="form__body">
    <div class="body-row">
      <div class="row-half">
          <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

          <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
      </div>
    </div>
    <div class="form-group">
        <?php
        echo Html::submitButton($model->isNewRecord ? 'Зберегти' : 'Зберегти', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
            'name'  => 'submit-button'
        ])
        ?>
    </div>
  </div>
    <?php ActiveForm::end(); ?>
</div>
