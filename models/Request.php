<?php

namespace app\models;

use yii\db\ActiveRecord;

class Request extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%requests}}';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'amount', 'term'], 'required'],
            [['user_id', 'amount', 'term'], 'integer'],
            [['amount'], 'validateAmount'],
            [['term'], 'validateTerm'],
        ];
    }

    public function validateAmount($attribute): void
    {
        if ($this->$attribute <= 0) {
            $this->addError($attribute, 'Amount must be greater than 0');
        }
    }

    public function validateTerm($attribute): void
    {
        if ($this->$attribute <= 0) {
            $this->addError($attribute, 'Term must be greater than 0');
        }
    }

    public function fields(): array
    {
        return [
            'id',
            'user_id',
            'amount',
            'term',
            'status',
            'created_at',
        ];
    }
}
