<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class UniqueWithAdditionalColumnsRule implements Rule
{
    /** @var Model $model */
    protected $model;

    /** @var string $uniqueColumnName */
    protected $uniqueColumnName;

    /** @var null|string $ownId */
    protected $ownId = 'id';

    /** @var null|string $idColumnName */
    protected $idColumnName = null;

    /** @var null|string $filterColumnName */
    protected $filterColumnName = null;

    /** @var null|string $filterColumnValue */
    protected $filterColumnValue = null;

    /**
     * Create a new rule instance.
     *
     * @param $modelClass
     * @param $uniqueColumnName
     * @param null $ownId
     * @param null $idColumnName
     * @param null $filterColumnName
     * @param null $filterColumnValue
     */
    public function __construct($modelClass, $uniqueColumnName, $ownId = null,
                                $idColumnName = null, $filterColumnName = null, $filterColumnValue = null)
    {
        $this->model                = new $modelClass;
        $this->uniqueColumnName     = $uniqueColumnName;

        if ($ownId) {
            $this->ownId            = $ownId;
        }

        if ($idColumnName) {
            $this->idColumnName     = $idColumnName;
        }

        if ($filterColumnName) {
            $this->filterColumnName = $filterColumnName;
        }

        if ($filterColumnValue) {
            $this->filterColumnValue= $filterColumnValue;
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $model = $this->model->where($this->uniqueColumnName, $value);

        if ($this->ownId) {
            $model = $model->where($this->idColumnName, '<>', $this->ownId);
        }

        if ($this->filterColumnName) {
            $model = $model->where($this->filterColumnName, $this->filterColumnValue);
        }

        return $model->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute daha önceden kayıt edilmiş.';
    }
}
