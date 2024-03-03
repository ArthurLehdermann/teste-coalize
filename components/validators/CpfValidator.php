<?php

namespace app\components\validators;

use Yii;
use yii\validators\Validator;

class CpfValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $cpf = preg_replace('/[^0-9]/', '', $model->$attribute);

        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            $this->addError($model, $attribute, Yii::t('app', 'Invalid CPF.'));
            return;
        }

        for ($j = 9; $j <= 10; $j++) {
            for ($i = 0, $sum = 0; $i < $j; $i++) {
                $sum += $cpf{$i} * (($j + 1) - $i);
            }

            $sum *= 10;
            $digit = $sum % 11;
            $digit = $digit == 10 ? 0 : $digit;

            if ($cpf{$j} != $digit) {
                $this->addError($model, $attribute, Yii::t('app', 'Invalid CPF.'));
                return;
            }
        }
    }
}