<?php

namespace App\Nova;

use App\Nova\Filters\SellsDate;
use App\Nova\Metrics\NewSells;
use http\Exception;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Sell extends Resource
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
    public static $model = 'App\Sell';

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
        'id',
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'product' => ['name'],
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Ventas');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Venta');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        $price = 0;

        if (isset($this->product->price)) $price = $this->product->price;

        return [
            ID::make()->hideFromIndex()->hideFromDetail(),

            DateTime::make(__('Fecha registro'), 'created_at')
                ->format('DD MMM - hh:mm A')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->sortable(),

            BelongsTo::make(__('Producto'), 'product', Product::class),

            Number::make(__('Unidades'), 'quantity')->min(1)->step(1),

            Currency::make(__('Precio'), function () use ($price) {
                return '$' . number_format($price);
            })
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            Currency::make(__('Total'), function () use ($price) {
                return '$' . number_format($price * $this->quantity);
            })
                ->hideWhenUpdating()
                ->hideWhenCreating(),

            BelongsTo::make(__('Registrado por'), 'user', User::class)
                ->hideWhenCreating()
                ->hideWhenUpdating()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            (new NewSells())->width('1/4')
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new SellsDate(),
        ];

    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
