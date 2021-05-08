<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    //
    protected $fillable = ['nama'];

    /**
     * Get all of the jadwal_pelajarans for the MataPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jadwal_pelajarans(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class, 'mata_pelajaran_id', 'id');
    }
}
