<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Pipeline\Pipeline;
use App\QueryFilters\Event as Filters;
use App\QueryFilters\Filter;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['date', 'comment', 'wagon_id', 'user_id', 'station_id', 'train_id'];
    protected $dates = ['date'];

    /**
     * Get all records through filtering pipelines.
     */
    public static function allEvents()
    {
        return app(Pipeline::class)
            ->send(Event::query())
            ->through([
                Filters\WagonId::class,
                Filters\TrainId::class,
                Filters\Date::class,
                Filters\CreatedAt::class,
                Filters\StationId::class,
                Filters\UserId::class
            ])
            ->thenReturn()
            ->orderByDesc('id')
            ->paginate(15);
    }
    /**
     * Get the wagon that the event belongs to
     */
    public function wagon()
    {
        return $this->belongsTo(Wagon::class);
    }
    /**
     * Get the user that the event belongs to
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the user that the event belongs to
     */
    public function train()
    {
        return $this->belongsTo(Train::class);
    }
    /**
     * Get the user that the event belongs to
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
    /**
     * Set the wagon's date as an instance of carbon
     *
     * @param  string  $value
     * @return void
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value);
    }
    /**
     * Return url to self
     * 
     * @return string
     */
    public function path()
    {
        return '/events/' . $this->id;
    }
}
