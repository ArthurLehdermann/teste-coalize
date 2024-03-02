<?php

namespace app\models;

use app\components\enums\Gender;
use app\components\validators\CpfValidator;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $name
 * @property string $cpf
 * @property string|null $cep
 * @property string|null $street
 * @property string|null $number
 * @property string|null $city
 * @property string|null $state
 * @property string|null $complement
 * @property string|null $photo
 * @property string $gender
 */
class Customer extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'cpf'], 'required'],
            [['gender'], 'string'],
            [['name', 'street', 'number', 'city', 'state', 'complement', 'photo'], 'string', 'max' => 255],
            [['cpf'], 'string', 'max' => 11],
            [['cpf'], 'unique'],
            [['cpf'], CpfValidator::class],
            [['cep'], 'string', 'max' => 8],
            [['gender'], 'in', 'range' => Gender::values()],
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
            'cpf' => 'CPF',
            'cep' => 'CEP',
            'street' => 'Rua',
            'number' => 'Número',
            'city' => 'Cidade',
            'state' => 'Estado',
            'complement' => 'Complemento',
            'photo' => 'Foto',
            'gender' => 'Sexo',
        ];
    }

    public function setCpf($cpf)
    {
        $this->cpf = preg_replace('/\D/', '', $cpf);
    }

    public function getFormattedCpf()
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf);
    }

    public function setCep($cep)
    {
        $this->cep = preg_replace('/\D/', '', $cep);
    }

    public function getFormattedCep()
    {
        return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $this->cep);
    }
}
