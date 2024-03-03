<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property int $id_customer
 * @property string|null $photo
 *
 * @property Customer $customer
 */
class Product extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'id_customer'], 'required'],
            [['price'], 'number'],
            [['id_customer'], 'integer'],
            [['name', 'photo'], 'string', 'max' => 255],
            [['id_customer'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['id_customer' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nome',
            'price' => 'Preço',
            'id_customer' => 'Cód. Cliente',
            'customer' => 'Cliente',
            'photo' => 'Foto',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'id_customer']);
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->price = (float) $this->price;
    }
}
