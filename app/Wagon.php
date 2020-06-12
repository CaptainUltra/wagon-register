<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Pipeline\Pipeline;
use App\QueryFilters\Wagon as Filters;

class Wagon extends Model
{
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['number', 'letter_index', 'v_max', 'seats', 'depot_id', 'revisory_point_id', 'revision_date', 'status_id'];

    /**
     * The attributes that should be treated as dates.
     *
     * @var array
     */
    protected $dates = ['revision_date', 'revision_exp_date'];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status_id' => 4,
    ];
    
    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return '/wagons/' . $this->id;
    }
    
    /**
     * Stylized number (with spaces and dashes)
     */
    public function getStylizedNumber()
    {
        $ab = substr($this->number, 0, 2);
        $cd = substr($this->number, 2, 2);
        $ef = substr($this->number, 4, 2);
        $gh = substr($this->number, 6, 2);
        $xyz = substr($this->number, 8, 3);
        $k = substr($this->number, 11);
        //AB CD EF-GH XYZ-K
        $number = $ab . ' ' . $cd . ' ' . $ef . '-' . $gh . ' ' . $xyz . '-' . $k;
        return $number;
    }
    public function getShortStylizedNumber()
    {
        $ef = substr($this->number, 4, 2);
        $gh = substr($this->number, 6, 2);
        $xyz = substr($this->number, 8, 3);
        $number = $ef . '-' . $gh . ' ' . $xyz;
        return $number;
    }
    /**
     * Set the wagon's date as an instance of carbon
     *
     * @param  string  $value
     * @return void
     */
    public function setRevisionDateAttribute($value)
    {
        if ($value == '') {
            $this->attributes['revision_date'] = null;
        } else {
            $this->attributes['revision_date'] = Carbon::parse($value);
        }
    }
    /**
     * Set the wagon's revision expiration date as an instance of carbon
     *
     * @param  string  $value
     * @return void
     */
    public function setRevisionExpDateAttribute($value)
    {
        if ($value == '') {
            $this->attributes['revision_exp_date'] = null;
        } else {
            $this->attributes['revision_exp_date'] = $value;
        }
    }
    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = [
            'id' => $this->id,
            'short_number' => $this->getShortStylizedNumber()
        ];

        return $array;
    }

    /**
     * Get all records through filtering pipelines.
     */
    public static function allWagons()
    {
        return app(Pipeline::class)
        ->send(Wagon::query())
        ->through([
            Filters\Status::class,
            Filters\Sort::class,
        ])
        ->thenReturn()
        ->paginate(15);
    }
    /**
     * Get the wagon type to which the wagon belongs
     */
    public function wagonType()
    {
        return $this->belongsTo(WagonType::class, 'type_id');
    }
    /**
     * Get the depot that the wagon belongs to
     */
    public function depot()
    {
        return $this->belongsTo(Depot::class);
    }
    /**
     * Get the revisory point that the wagon belongs to
     */
    public function revisoryPoint()
    {
        return $this->belongsTo(RevisoryPoint::class, 'revisory_point_id');
    }

    /**
     * Get the events associated with the wagon
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    /**
     * Get the status that the wagon belongs to
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get the images associated with the wagon
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
