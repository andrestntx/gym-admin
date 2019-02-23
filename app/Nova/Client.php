<?php

namespace App\Nova;

use App\Nova\Metrics\NewMemberships;
use Carbon\Carbon;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class Client extends Resource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Registros';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Client';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'document', 'email', 'phone',
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Clientes');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Cliente');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        $lastMembership = $this->memberships->last();

        return [
            ID::make()->hideFromIndex()->hideFromDetail(),

            DateTime::make(__('Fecha registro'), 'created_at')
                ->format('DD MMM - hh:mm A')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->sortable(),

            Number::make(__('Documento'), 'document')
                ->creationRules('required', 'integer'),

            Text::make(__('Nombre'), 'name')
                ->creationRules('required', 'string'),

            Text::make(__('Teléfono'), 'phone'),

            Text::make(__('Email'), 'email')->hideFromIndex(),

            Text::make(__('Dirección'), 'address')
                ->hideFromIndex(),

            Text::make(__('Ultima afiliación'), function () use ($lastMembership) {
                return $lastMembership ? $lastMembership->detail : 'Sin memberesía';
            })->exceptOnForms(),

            BelongsTo::make(__('Registrado por'), 'user', User::class)
                ->onlyOnDetail(),

            BelongsToMany::make(__('Afiliaciones'), 'memberships', Membership::class)->fields(function () {
                return [
                    Date::make(__('Fecha inicio'), 'start_at'),
                    Date::make(__('Fecha fin'), 'end_at')->exceptOnForms()
                ];
            })
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            (new NewMemberships())->width('1/4')
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
