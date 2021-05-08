<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPelajaran extends Model
{
    //
    protected $fillable = ['user_id', 'mata_pelajaran_id', 'hari_id'];

    /**
     * Get the mapel that owns the JadwalPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id', 'id');
    }

    /**
     * Get the hari that owns the JadwalPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hari(): BelongsTo
    {
        return $this->belongsTo(Hari::class);
    }
}
