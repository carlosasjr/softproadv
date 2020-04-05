<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Company extends Model
{
    protected $fillable = [
        'name',
        'cellphone',
        'cpf',
        'oab',
        'uf_oab',
        'qtd_processes',
        'email',
        'payment_status',
        'subdomain',
        'db_database',
        'db_host',
        'db_username',
        'db_password'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (Empty($model->db_database))
                $model->db_database = $model->subdomain . '-adv';

            if (Empty($model->db_host)) {
                 $model->db_host = env('DB_HOST');
            }

            if (Empty($model->db_username))
                $model->db_username = env('DB_USERNAME');

            if (Empty($model->db_password))
                $model->db_password = env('DB_PASSWORD');

            $model->uuid = (string)Uuid::uuid4();
        });
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
