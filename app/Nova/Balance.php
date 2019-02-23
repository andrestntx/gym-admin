<?php

namespace App\Nova;

use App\MembershipDetail;
use App\Nova\Metrics\BalanceSummary;
use App\Nova\Metrics\NewBalance;
use App\Nova\Metrics\NewExpenses;
use App\Nova\Metrics\NewMemberships;
use App\Nova\Metrics\NewSells;
use Carbon\Carbon;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use DB;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Panel;

class Balance extends Resource
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
    public static $model = 'App\Balance';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'closed_at';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'closed_at',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Cierres de Caja');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Cierre de Caja');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        if(is_null($this->id)) {
            return $this->getCreationFields();
        } else {
            return [
                ID::make()->hideFromIndex()->hideFromDetail(),

                new Panel('Datos del sistema', [
                    Date::make(__('Fecha del cierre'), 'closed_at')
                        ->format('DD MMM')
                        ->sortable()
                        ->hideWhenCreating(),

                    Currency::make(__('Base inicial'), 'init_base')->hideWhenCreating()->hideFromIndex(),
                    Currency::make(__('Total Productos'), 'sold')->hideWhenCreating()->hideFromIndex(),
                    Currency::make(__('Total Afiliaciones'), 'sold_memberships')->hideWhenCreating()->hideFromIndex(),
                    Currency::make(__('Total Gastado'), 'spent')->hideFromIndex()->hideWhenCreating(),
                    Currency::make(__('Balance'), 'balance')->hideWhenCreating()->hideFromIndex(),
                ]),

                new Panel('Datos calculados', [
                    Currency::make(__('Dinero real en caja'), 'real_balance')->hideWhenCreating(),
                    Currency::make(__('Base para el siguiente día'), 'new_base')->hideWhenCreating(),
                    Currency::make(__('Dinero a consignar'), 'saved_money')->hideWhenCreating()
                ]),

                new Panel('Comentarios', [
                    Textarea::make(__('Comentarios'), 'comments')->hideFromIndex()
                ]),

                new Panel('Auditoría', [
                    BelongsTo::make(__('Registrado por'), 'user', User::class)
                        ->exceptOnForms(),

                    DateTime::make(__('Fecha registro'), 'created_at')
                        ->format('DD MMM - hh:mm A')
                        ->onlyOnDetail()
                ]),
            ];
        }
    }

    private function getCreationFields() {
        $usuallyBase = 100000;
        $today = Carbon::now()->toDateString();
        $lastBalance = \App\Balance::orderBy('paid_ad', 'desc')->take(1);
        $initBalance = isset($lastBalance->new_base) ? $lastBalance->new_base : $usuallyBase;

        $spent = \App\Expense::whereDate('paid_at', Carbon::now()->toDateString())->sum('value');
        $sold = \App\Sell::join('products', 'sells.product_id', '=', 'products.id')
            ->whereDate('sells.created_at', $today)
            ->sum(DB::raw('products.price * sells.quantity'));

        $soldMemberships = MembershipDetail::join('memberships', 'clients_memberships.membership_id', '=', 'memberships.id')
            ->whereDate('clients_memberships.start_at', $today)
            ->sum('memberships.price');

        $balance = ($soldMemberships + $sold + $initBalance) - $spent;
        $newBase = min($balance, $usuallyBase);
        $savedMoney = $balance - $newBase;

        return [
            ID::make()->hideFromIndex()->hideFromDetail(),

            Date::make(__('Fecha del cierre'), 'closed_at')
                ->withMeta([
                    "value" => Carbon::now()->toDateString()
                ])
                ->onlyOnForms()
                ->hideWhenUpdating(),

            $this->getField(
                Currency::make(__('Base inicial'), 'init_base'),
                $initBalance,
                'Base con la que inició el día'
            ),

            $this->getField(
                Currency::make(__('Total Afiliaciones'), 'sold_memberships'),
                $soldMemberships,
                'Dinero obtenido por afiliaciones'
            ),

            $this->getField(
                Currency::make(__('Total Productos'), 'sold'),
                $sold,
                'Total de productos vendidos'
            ),

            $this->getField(
                Currency::make(__('Total Gastado'), 'spent'),
                $spent,
                'Total de gastos en el día'
            ),

            $this->getField(
                Currency::make(__('Dinero que debería haber en caja'), 'balance'),
                $balance,
                "Balance: ($initBalance + $soldMemberships + $sold) - $spent"
            ),

            $this->getField(
                Currency::make(__('Dinero real en caja'), 'real_balance'),
                null,
                "Dinero que hay realmente en la caja"
            ),

            $this->getField(
                Currency::make(__('Base para el siguiente día'), 'new_base'),
                $newBase
            ),

            $this->getField(
                Currency::make(__('Dinero a consignar'), 'saved_money'),
                $savedMoney
            ),

            new Panel('Comentarios', [
                Textarea::make(__('Comentarios'), 'comments')
                    ->hideFromIndex()
                    ->rules('required')
            ]),

            DateTime::make(__('Fecha registro'), 'created_at')
                ->format('DD MMM - hh:mm A')
                ->onlyOnDetail()
        ];
    }

    private function getField(Field $field, $value, $help = "") {
        return $field->withMeta(["value" => $value])
            ->onlyOnForms()
            ->hideWhenUpdating()
            ->rules("required")
            ->help($help);
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
            (new NewBalance())->width('1/3'),
            (new NewMemberships())->width('1/3'),
            (new NewSells())->width('1/3'),
            (new NewExpenses())->width('1/3'),
            (new BalanceSummary())->width('1/3')
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
        return [];
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
