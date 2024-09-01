<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CVReview extends Model
{
    protected $table = 'cv_reviews';

    public $incrementing = true;

    protected $fillable = ['file_name', 'file_path', 'result', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function upload(UploadedFile $file, User $user): CVReview
    {
        $originalName = $file->getClientOriginalName();
        $uuid = Str::uuid()->toString();

        $path = $file->storeAs('curriculum_vitaes', $uuid . '.' . $file->getClientOriginalExtension());

        $cvReview = new CVReview();
        $cvReview->file_name = $originalName;
        $cvReview->file_path = $path;
        $cvReview->user_id = $user->id;
        $cvReview->save();

        return $cvReview;
    }
}
