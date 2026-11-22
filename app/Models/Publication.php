<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Publication extends Model
{
    use HasFactory, SoftDeletes;

     public function categorie()
{
    return $this->belongsTo(Categorie::class);
}

public function auteur()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function commentaires()
{
    return $this->hasMany(Commentaire::class);
}

public function tags()
{
    return $this->belongsToMany(Tag::class);
}
    protected static function booted(): void
    {
        static::deleting(function (Publication $publication) {
            // If the publication has an image, delete it from the disk
            if ($publication->image) {
                Storage::disk('public')->delete($publication->image);
            }
            // If it has a media file, delete it too
            if ($publication->fichier_media) {
                Storage::disk('public')->delete($publication->fichier_media);
            }
        });
    }
protected $fillable = [
    'titre',
    'contenu',
    'categorie_id',
    'user_id',
    'image',
    'fichier_media',
    'type_media'
];
}
