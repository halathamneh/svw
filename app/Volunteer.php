<?php

namespace App;

use App\Http\Resources\VolunteerCollection;
use App\MyModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Pluralizer;

/**
 * @property String full_name
 * @property String first_name
 * @property String last_name
 * @property String birthday
 * @property String gender
 * @property String country
 * @property String city
 * @property String phone
 * @property String profile_picture
 * @property String cover_picture
 * @property String bio
 * @property Collection[Capability] capabilities
 * @property User user
 * @property string profile_url
 */
class Volunteer extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'birthday'];

    protected $fillable = ['first_name', 'last_name', 'birthday',
        'gender', 'country', 'city', 'phone', 'profile_picture',
        'cover_picture', 'bio'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function capabilities()
    {
        return $this->hasMany(Capability::class);
    }

    /*public function getCapabilitiesAttribute($val)
    {
        return Capability::groupify($val);
    }*/

    public function saveEducations($educations)
    {
        if (is_array($educations)) {
            $arr = [];
            foreach ($educations as $item) {
                $arr[] = [
                    'school'         => $item->school,
                    'field_of_study' => $item->field_of_study,
                    'gdate'          => $item->gdate,
                ];
            }
            return $this->educations()->createMany($arr);
        } elseif (is_object($educations)) {
            return $this->educations()->create((array)$educations);
        }
        return false;
    }

    public function saveExperiences($experiences)
    {
        $arr = [];
        foreach ($experiences as $item) {
            $arr[] = [
                'position'          => $item->position,
                'organization_name' => $item->organization_name,
                'period'            => $item->period,
                'description'       => $item->desc,
            ];
        }
        return $this->experiences()->createMany($arr);
    }

    public function saveCapabilities($capabilities)
    {
        $arr = [];
        foreach ($capabilities as $type => $values) {
            $type_singular = Pluralizer::singular($type);
            foreach ($values as $value) {
                $arr[] = [
                    'type'  => $type_singular,
                    'value' => json_encode($value),
                ];
            }
        }
        return $this->capabilities()->createMany($arr);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    public function getGenderAttribute($val)
    {
        return ucfirst($val);
    }

    public function getProfileUrlAttribute()
    {

            return route("profile.volunteer", ["username" => $this->user->username]);

    }


    public static function search($s)
    {
        $results = self::where("first_name", "LIKE", "%$s%")
            ->orWhere("last_name", "LIKE", "%$s%")
            ->with('user')
            ->simplePaginate(15);
        logger($results->count());
        return $results;
    }

}
