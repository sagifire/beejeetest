<?php

namespace app\models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use app\helpers\FlagHelper;

/**
 * Class Task
 *
 * @package app\models
 *
 * @property string $username
 * @property string $email
 * @property string $description
 * @property int $status
 */
class Task extends Model
{

    const STATUS_COMPLETED_BIT = 1;
    const STATUS_EDITED_BIT = 2;

    /**
     * @var string
     */
    protected $table = 'task';

    /**
     * @var array
     */
    protected $fillable = ['username', 'email', 'description'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return bool
     */
    public function isCompleted()
    {
        return FlagHelper::test($this->status, self::STATUS_COMPLETED_BIT);
    }

    /**
     * @param $bit
     */
    public function setCompleted($bit)
    {
        if ($bit) {
            $this->status = FlagHelper::on($this->status, self::STATUS_COMPLETED_BIT);
        } else {
            $this->status = FlagHelper::off($this->status, self::STATUS_COMPLETED_BIT);
        }
    }

    /**
     * @return bool
     */
    public function isEdited()
    {
        return FlagHelper::test($this->status, self::STATUS_EDITED_BIT);
    }

    /**
     * @param Builder $query
     *
     * @return bool
     */
    protected function performUpdate(Builder $query)
    {
        if ($this->isDirty('description')) {
            $this->status = FlagHelper::on($this->status, Task::STATUS_EDITED_BIT);
        }

        return parent::performUpdate($query);
    }

}
